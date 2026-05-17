<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\QrCode;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $qrcodes = QrCode::orderBy('table_number')->get();
        $tables = $qrcodes->pluck('table_number')->all();
        // use fixed base host as requested
        $base = 'http://10.44.46.254:8000';

        $tablesStatus = [];
        foreach ($tables as $table) {
            $open = Order::where('table_number', $table)
                ->where('status', '!=', 'SELESAI')
                ->latest()
                ->first();

            if ($open) {
                $tablesStatus[$table] = [
                    'occupied' => true,
                    'status' => $open->status,
                    'order_id' => $open->id,
                ];
            } else {
                $tablesStatus[$table] = [
                    'occupied' => false,
                ];
            }
        }

        // apply filter to qrcodes collection
        $allowedFilters = ['siap','proses','memesan','kosong','all'];
        if (!in_array($filter, $allowedFilters)) {
            $filter = 'all';
        }

        $qrcodes = $qrcodes->filter(function($q) use ($tablesStatus, $filter) {
            $table = $q->table_number;
            $info = $tablesStatus[$table] ?? ['occupied' => false];

            if ($filter === 'all') return true;
            if ($filter === 'kosong') return !$info['occupied'];
            // for 'siap','proses','memesan' match against order status text (case-insensitive, substring)
            if ($info['occupied'] && !empty($info['status'])) {
                return strpos(strtolower($info['status']), $filter) !== false;
            }
            return false;
        })->values();

        return view('admin.qrcodes.index', compact('qrcodes', 'tables', 'base', 'tablesStatus', 'filter'));
    }

    public function create()
    {
        return view('admin.qrcodes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:10',
            'code' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

       
        QrCode::create($request->all());

        return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code berhasil ditambahkan');
    }

    public function show($id)
    {
        $qrcode = QrCode::findOrFail($id);

        return view('admin.qrcodes.show', compact('qrcode'));
    }

    public function edit($id)
    {
        $qrcode = QrCode::findOrFail($id);

        return view('admin.qrcodes.edit', compact('qrcode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|string|max:10',
            'code' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        // Dalam implementasi dengan DB, update ke database
        $qrcode = QrCode::findOrFail($id);
        $qrcode->update($request->all());

        return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Dalam implementasi dengan DB, hapus dari database
        $qrcode = QrCode::findOrFail($id);
        $qrcode->delete();

        return redirect()->route('admin.qrcodes.index')->with('success', 'QR Code berhasil dihapus');
    }
}
