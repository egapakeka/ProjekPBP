<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    protected function getUserCart(): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    public function index(): View
    {
        $cart = $this->getUserCart()->load(['items.product']);

        $total = $cart->items->sum(function (CartItem $item) {
            if (! $item->product) {
                return 0;
            }

            return $item->product->price * $item->qty;
        });

        return view('cart.index', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Products::findOrFail($validated['product_id']);
        if ($product->stock < 1) {
            return back()->withErrors(['qty' => 'Produk sedang habis.'])->withInput();
        }

        $cart = $this->getUserCart();
        $qty = $validated['qty'] ?? 1;

        $item = $cart->items()->where('product_id', $validated['product_id'])->first();
        $currentQty = $item?->qty ?? 0;
        $desiredQty = $currentQty + $qty;

        if ($desiredQty > $product->stock) {
            return back()->withErrors([
                'qty' => 'Stok produk tersisa '.$product->stock.' unit. Tidak dapat menambahkan jumlah yang diminta.',
            ])->withInput();
        }

        if ($item) {
            $item->update([
                'qty' => $desiredQty,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $validated['product_id'],
                'qty' => $qty,
            ]);
        }

        return redirect()->route('cart.index')->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $this->authorizeItem($item);

        $product = $item->product;
        if ($product && $request->qty > $product->stock) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Stok produk tidak mencukupi.',
                    'errors' => [
                        'qty' => ['Stok produk tersisa '.$product->stock.' unit.'],
                    ],
                    'max' => $product->stock,
                ], 422);
            }

            return back()->withErrors([
                'qty' => 'Stok produk tersisa '.$product->stock.' unit.',
            ])->withInput();
        }

        $item->update([
            'qty' => $request->qty,
        ]);

        if ($request->expectsJson()) {
            $item->refresh()->load('product');
            $cart = $item->cart()->with('items.product')->first();

            $subtotal = $this->calculateSubtotal($item);
            $total = $cart->items->sum(function (CartItem $cartItem) {
                return $this->calculateSubtotal($cartItem);
            });

            return response()->json([
                'qty' => $item->qty,
                'subtotal' => $subtotal,
                'subtotal_formatted' => $this->formatCurrency($subtotal),
                'total' => $total,
                'total_formatted' => $this->formatCurrency($total),
                'items_count' => $cart->items->sum('qty'),
            ]);
        }

        return redirect()->route('cart.index')->with('status', 'Kuantitas produk diperbarui.');
    }

    public function destroy(CartItem $item): RedirectResponse
    {
        $this->authorizeItem($item);

        $item->delete();

        return redirect()->route('cart.index')->with('status', 'Produk dihapus dari keranjang.');
    }

    protected function authorizeItem(CartItem $item): void
    {
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }
    }

    protected function calculateSubtotal(CartItem $item): float
    {
        $price = optional($item->product)->price ?? 0;

        return $price * $item->qty;
    }

    protected function formatCurrency(float $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
