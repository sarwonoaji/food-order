<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class QrCodeController extends Controller
{
    public function index()
    {
        // default table list, edit as needed or fetch from DB/config
        $tables = ['A1','A2','A3','A4','A5','B1','B2','B3','B4','B5'];
        $base = url('/');

        // compute occupancy per table (occupied if there's any order for that table with status != 'SELESAI')
        $tablesStatus = [];
        foreach ($tables as $t) {
            $open = Order::where('table_number', $t)
                ->where('status', '!=', 'SELESAI')
                ->latest()
                ->first();

            if ($open) {
                $tablesStatus[$t] = [
                    'occupied' => true,
                    'status' => $open->status,
                    'order_id' => $open->id,
                ];
            } else {
                $tablesStatus[$t] = [
                    'occupied' => false,
                ];
            }
        }

        return view('admin.qr.index', compact('tables', 'base', 'tablesStatus'));
    }
}
