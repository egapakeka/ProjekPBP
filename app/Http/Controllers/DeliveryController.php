<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Menampilkan daftar pengiriman (index)
    public function index()
    {
        // ambil data deliveries dengan relasi order (pastikan relation order() ada di model Delivery)
        $deliveries = Delivery::with('order')->latest()->paginate(10);

        // kirim variabel bernama $deliveries ke view
        return view('admin.deliveries.index', compact('deliveries'));
    }

    // Form tambah pengiriman
    public function create()
    {
        // ambil orders yang belum punya delivery (pastikan Order model punya relasi delivery())
        $orders = Order::whereDoesntHave('delivery')->get();

        return view('admin.deliveries.create', compact('orders'));
    }

    // Simpan pengiriman baru
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'kurir' => 'required|string|max:100',
            'no_resi' => 'nullable|string|max:100',
            'status_pengiriman' => 'required|in:diproses,dikirim,selesai,batal',
        ]);

        Delivery::create([
            'order_id' => $request->order_id,
            'kurir' => $request->kurir,
            'no_resi' => $request->no_resi,
            'status_pengiriman' => $request->status_pengiriman,
        ]);

        return redirect()->route('admin.deliveries.index')->with('success', 'Pengiriman berhasil ditambahkan.');
    }

    // Form edit
    public function edit(Delivery $delivery)
    {
        return view('admin.deliveries.edit', compact('delivery'));
    }

    // Update data
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'kurir' => 'required|string|max:100',
            'no_resi' => 'nullable|string|max:100',
            'status_pengiriman' => 'required|in:diproses,dikirim,selesai,batal',
        ]);

        $delivery->update($request->only(['kurir','no_resi','status_pengiriman']));

        return redirect()->route('admin.deliveries.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    // Hapus pengiriman
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()->route('admin.deliveries.index')->with('success', 'Pengiriman dihapus.');
    }
}
