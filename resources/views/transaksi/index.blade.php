@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Data Transaksi</h5>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">+ Tambah Transaksi</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr>
                    <td>{{ $t->kode_transaksi }}</td>
                    <td>{{ $t->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $t->jumlah_barang }}</td>
                    <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="{{ route('transaksi.edit', $t->kode_transaksi) }}" class="btn btn-warning btn-sm btn-action">Edit</a>
                        <form action="{{ route('transaksi.destroy', $t->kode_transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-action">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection