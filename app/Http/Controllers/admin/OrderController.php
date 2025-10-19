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

        $orders = Orders::with(['user', 'items.product', 'voucherUsages.voucher'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders','status'));
    }

    public function updateStatus(Request $request, Orders $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        $statusMeta = $this->statusMeta($order->status);
        $message = "Status pesanan #{$order->id} diubah menjadi {$statusMeta['label']}.";

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'status' => $order->status,
                'label' => $statusMeta['label'],
                'badge_class' => $statusMeta['class'],
            ]);
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }

    public function show($id)
    {
        $order = Orders::with(['user','items.product','vouchers'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    protected function statusMeta(string $status): array
    {
        $map = [
            'pending' => ['label' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-800'],
            'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
            'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-indigo-100 text-indigo-800'],
            'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
        ];

        return $map[$status] ?? [
            'label' => ucfirst($status),
            'class' => 'bg-gray-100 text-gray-800',
        ];
    }
}
