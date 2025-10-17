<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
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

        $cart = $this->getUserCart();
        $qty = $validated['qty'] ?? 1;

        $item = $cart->items()->where('product_id', $validated['product_id'])->first();

        if ($item) {
            $item->update([
                'qty' => $item->qty + $qty,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $validated['product_id'],
                'qty' => $qty,
            ]);
        }

        return redirect()->route('cart.index')->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $this->authorizeItem($item);

        $item->update([
            'qty' => $request->qty,
        ]);

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
}
