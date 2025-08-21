<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Admin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pesanan' => Pesanan::count(),
            'pesanan_pending' => Pesanan::where('status', 'Pending')->count(),
            'pesanan_dikerjakan' => Pesanan::where('status', 'Dikerjakan')->count(),
            'pesanan_selesai' => Pesanan::where('status', 'Selesai')->count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_admin' => Admin::count(),
        ];

        $recentOrders = Pesanan::with(['pelanggan', 'admin'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recentOrders'));
    }

    public function report()
    {
        $pesanan = Pesanan::with(['pelanggan', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.report', compact('pesanan'));
    }
}
