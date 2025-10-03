<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;

class OrderController extends Controller
{
    public function index()
    {
        $status = request('status');

        $orders = Orders::with(['user','items.product','voucherUsage.voucher'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders','status'));
    }

    public function show($id)
    {
        $order = Orders::with(['user','items.product','vouchers'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
