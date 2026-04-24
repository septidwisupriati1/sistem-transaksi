@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Data Barang</h5>
            <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">+ Tambah Barang</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                <tr>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="{{ route('barang.edit', $barang->kode_barang) }}" class="btn btn-warning btn-sm btn-action">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->kode_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-action">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection