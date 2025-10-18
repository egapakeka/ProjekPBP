<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order_Items;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Vouchers;
use App\Models\Voucher_Usages;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function summary(Request $request)
    {
        $validated = $request->validate([
            'selected_items' => ['required', 'string'],
        ]);

        $ids = $this->normalizeSelectedIds($validated['selected_items']);

        return $this->buildSummaryResponse($ids);
    }

    public function buyNow(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $product = Products::findOrFail($validated['product_id']);

        if ($product->stock < $validated['qty']) {
            return back()->withErrors([
                'qty' => __('Stok produk tersisa :stock unit.', ['stock' => $product->stock]),
            ])->withInput();
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->update(['qty' => $validated['qty']]);
        } else {
            $item = $cart->items()->create([
                'product_id' => $product->id,
                'qty' => $validated['qty'],
            ]);
        }

        return $this->buildSummaryResponse(collect([$item->id]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'selected_items' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'voucher_id' => ['nullable', 'exists:vouchers,id'],
        ]);

        $ids = $this->normalizeSelectedIds($validated['selected_items']);

        if ($ids->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Pilih minimal satu produk untuk checkout.'));
        }

        $items = $this->getUserCartItems($ids->all());

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Tidak ditemukan produk valid untuk checkout.'));
        }

        foreach ($items as $item) {
            if (! $item->product) {
                return redirect()->route('cart.index')->with('error', __('Salah satu produk tidak tersedia.'));
            }

            if ($item->product->stock < $item->qty) {
                return redirect()->route('cart.index')->with('error', __('Stok untuk :product tidak mencukupi.', ['product' => $item->product->name]));
            }
        }

        $user = Auth::user();
        $total = $items->sum(fn (CartItem $item) => $item->product->price * $item->qty);

        $discount = 0;
        $voucher = null;

        if (! empty($validated['voucher_id'])) {
            $voucher = Vouchers::find($validated['voucher_id']);

            if (! $voucher || ! $voucher->isValidFor($user, $total)) {
                return back()->withInput()->with('error', __('Voucher tidak valid untuk pesanan ini.'));
            }

            $discount = $voucher->calculateDiscount($total);
        }

        $finalAmount = max($total - $discount, 0);

        DB::transaction(function () use ($items, $validated, $user, $total, $discount, $finalAmount, $voucher) {
            $order = Orders::create([
                'user_id' => $user->id,
                'total' => $total,
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'address_text' => $validated['address'],
            ]);

            foreach ($items as $item) {
                $product = $item->product;
                $price = $product->price;
                $qty = $item->qty;
                $subtotal = $price * $qty;

                Order_Items::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $qty);
            }

            if ($voucher) {
                Voucher_Usages::create([
                    'voucher_id' => $voucher->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                ]);
            }

            CartItem::whereIn('id', $items->pluck('id'))->delete();
        });

        return redirect()->route('cart.index')->with('status', __('Checkout berhasil. Pesanan menunggu konfirmasi admin.'));
    }

    protected function normalizeSelectedIds(string $selected): \Illuminate\Support\Collection
    {
        return collect(explode(',', $selected))
            ->map(fn ($id) => (int) trim($id))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();
    }

    protected function getUserCartItems(array $ids)
    {
        if (empty($ids)) {
            return collect();
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        return CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $ids)
            ->get();
    }

    protected function buildSummaryResponse(Collection $ids)
    {
        if ($ids->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Pilih minimal satu produk untuk checkout.'));
        }

        $items = $this->getUserCartItems($ids->all());

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Tidak ditemukan produk valid untuk checkout.'));
        }

        foreach ($items as $item) {
            if (! $item->product) {
                return redirect()->route('cart.index')->with('error', __('Salah satu produk tidak tersedia.'));
            }

            if ($item->product->stock < $item->qty) {
                return redirect()->route('cart.index')->with('error', __('Stok untuk :product tidak mencukupi.', ['product' => $item->product->name]));
            }
        }

        $total = $items->sum(fn (CartItem $item) => $item->product->price * $item->qty);
        $totalQty = $items->sum('qty');

        $user = Auth::user();

        $vouchers = Vouchers::all()
            ->filter(fn ($voucher) => $voucher->isValidFor($user, $total))
            ->values();

        return view('checkout.summary', [
            'items' => $items,
            'total' => $total,
            'totalQty' => $totalQty,
            'selectedIds' => $ids->implode(','),
            'vouchers' => $vouchers,
        ]);
    }
}
