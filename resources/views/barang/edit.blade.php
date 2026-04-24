@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 520px;">
    <div class="card-body">
        <h5 class="card-title mb-4">Edit Barang</h5>
        <form action="{{ route('barang.update', $barang->kode_barang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kode Barang</label>
                <input type="text" class="form-control" value="{{ $barang->kode_barang }}" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang', $barang->nama_barang) }}">
                @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Harga Barang (Rp)</label>
                <input type="number" name="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror" value="{{ old('harga_barang', $barang->harga_barang) }}" min="0">
                @error('harga_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection