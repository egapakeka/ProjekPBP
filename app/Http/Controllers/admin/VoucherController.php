<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vouchers;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Vouchers::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        if ($validated['discount_type'] !== 'percent') {
            $validated['max_discount'] = null;
        }

        Vouchers::create($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil ditambahkan');
    }

    public function edit($id)
    {
        $voucher = Vouchers::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Vouchers::findOrFail($id);

        $validated = $request->validate($this->rules($request, $voucher));

        if ($validated['discount_type'] !== 'percent') {
            $validated['max_discount'] = null;
        }

        $voucher->update($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui');
    }

    public function destroy($id)
    {
        $voucher = Vouchers::findOrFail($id);
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus');
    }

    public function show($id)
    {
        $voucher = Vouchers::findOrFail($id);
        return view('admin.vouchers.show', compact('voucher'));
    }

    protected function rules(Request $request, ?Vouchers $voucher = null): array
    {
        $codeRule = 'required|unique:vouchers,code';

        if ($voucher) {
            $codeRule .= ',' . $voucher->id;
        }

        $rules = [
            'code' => $codeRule,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
        ];

        if ($request->discount_type === 'percent') {
            $rules['discount_value'] .= '|max:100';
        } else {
            $rules['max_discount'] = 'nullable';
        }

        return $rules;
    }
}
