<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;

class OrderController extends Controller
{
    public function index()
    {
        $status = request('status');

        $orders = Orders::with(['user','items.product'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);   // <-- PENTING: gunakan paginate, bukan get()

        return view('admin.orders.index', compact('orders','status'));
    }
}

