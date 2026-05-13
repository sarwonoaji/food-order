<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        // default table list, edit as needed or fetch from DB/config
        $tables = ['A1','A2','A3','A4','A5','B1','B2','B3','B4','B5'];
        $base = url('/');

        return view('admin.qr.index', compact('tables', 'base'));
    }
}
