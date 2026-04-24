@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 520px;">
    <div class="card-body">
        <h5 class="card-title mb-4">Tambah Transaksi</h5>
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kode Transaksi</label>
                <input type="text" name="kode_transaksi" class="form-control @error('kode_transaksi') is-invalid @enderror" value="{{ old('kode_transaksi') }}">
                @error('kode_transaksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Barang</label>
                <select name="kode_barang" id="kode_barang" class="form-select @error('kode_barang') is-invalid @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                    <option value="{{ $barang->kode_barang }}"
                        data-harga="{{ $barang->harga_barang }}"
                        {{ old('kode_barang') == $barang->kode_barang ? 'selected' : '' }}>
                        {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
                    </option>
                    @endforeach
                </select>
                @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Barang</label>
                <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control @error('jumlah_barang') is-invalid @enderror" value="{{ old('jumlah_barang', 1) }}" min="1">
                @error('jumlah_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Total Harga (otomatis)</label>
                <input type="text" id="preview_total" class="form-control bg-light" readonly placeholder="Pilih barang & jumlah...">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function hitungTotal() {
        const select  = document.getElementById('kode_barang');
        const jumlah  = parseInt(document.getElementById('jumlah_barang').value) || 0;
        const harga   = parseFloat(select.options[select.selectedIndex]?.dataset.harga) || 0;
        const total   = harga * jumlah;
        document.getElementById('preview_total').value =
            total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '';
    }
    document.getElementById('kode_barang').addEventListener('change', hitungTotal);
    document.getElementById('jumlah_barang').addEventListener('input', hitungTotal);
</script>
@endsection