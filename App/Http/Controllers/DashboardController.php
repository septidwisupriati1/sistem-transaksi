<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang        = Barang::count();
        $totalTransaksi     = Transaksi::count();
        $totalPendapatan    = Transaksi::sum('total_harga');
        $totalItemTerjual   = Transaksi::sum('jumlah_barang');

        $transaksiTerbaru = Transaksi::with('barang')
                            ->orderByDesc('kode_transaksi')
                            ->take(5)
                            ->get();

        $barangTerlaris = Transaksi::selectRaw('kode_barang, SUM(jumlah_barang) as total_terjual, SUM(total_harga) as total_pendapatan')
                            ->groupBy('kode_barang')
                            ->orderByDesc('total_terjual')
                            ->with('barang')
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalTransaksi',
            'totalPendapatan',
            'totalItemTerjual',
            'transaksiTerbaru',
            'barangTerlaris'
        ));
    }
}