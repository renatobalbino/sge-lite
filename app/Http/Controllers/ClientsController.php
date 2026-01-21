<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

final class ClientsController extends Controller
{
    public function index(): View
    {
        return view('admin.clients.index');
    }
}
