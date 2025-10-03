<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
<<<<<<< HEAD
use Illuminate\Http\Request;
=======
>>>>>>> felis

class OrderController extends Controller
{
    public function index()
    {
        $status = request('status');

<<<<<<< HEAD
        $orders = Orders::with(['user','items.product'])
=======
        $orders = Orders::with(['user','items.product','voucherUsage.voucher'])
>>>>>>> felis
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders','status'));
    }

<<<<<<< HEAD
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
=======
    public function show($id)
    {
        $order = Orders::with(['user','items.product','vouchers'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
>>>>>>> felis
    }
}
