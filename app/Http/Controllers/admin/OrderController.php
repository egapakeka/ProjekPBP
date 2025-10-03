<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $status = request('status');

        $orders = Orders::with(['user','items.product'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders','status'));
    }

    public function updateStatus(Request $request, Orders $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', "Status pesanan #{$order->id} diubah menjadi {$validated['status']}.");
    }
}
