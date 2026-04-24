<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('barang')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksi,kode_transaksi',
            'kode_barang'    => 'required|exists:barang,kode_barang',
            'jumlah_barang'  => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->kode_barang);
        $total  = $barang->harga_barang * $request->jumlah_barang;

        Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang'    => $request->kode_barang,
            'jumlah_barang'  => $request->jumlah_barang,
            'total_harga'    => $total,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barangs   = Barang::all();
        return view('transaksi.edit', compact('transaksi', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang'   => 'required|exists:barang,kode_barang',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        $barang    = Barang::findOrFail($request->kode_barang);
        $total     = $barang->harga_barang * $request->jumlah_barang;
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'kode_barang'   => $request->kode_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'total_harga'   => $total,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}