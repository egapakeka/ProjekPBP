<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpTicket;

class HelpTicketController extends Controller
{
    public function index()
    {
        $tickets = HelpTicket::latest()->paginate(10);

        return view('admin.help.index', compact('tickets'));
    }
}
