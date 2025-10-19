<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpTicket;

class HelpController extends Controller
{
    public function show()
    {
        return view('pages.help');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        HelpTicket::create($data);

        return back()
            ->withInput()
            ->with('status', __('Terima kasih, :name! Pesan kamu sudah kami terima.', ['name' => $data['name']]));
    }
}
