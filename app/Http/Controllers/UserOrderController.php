<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Orders::with(['items.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $order = Orders::with(['items.product', 'vouchers'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('orders.show', compact('order'));
    }

    public function markAsReceived(Request $request, Orders $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'selesai') {
            return redirect()
                ->route('orders.show', $order)
                ->with('info', 'Pesanan ini sudah ditandai selesai.');
        }

        if ($order->status === 'dibatalkan') {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Pesanan yang dibatalkan tidak dapat ditandai selesai.');
        }

        $order->update(['status' => 'selesai']);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Terima kasih! Pesanan telah ditandai selesai.');
    }
}
