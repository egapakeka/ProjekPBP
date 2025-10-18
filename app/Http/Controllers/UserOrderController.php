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
}
