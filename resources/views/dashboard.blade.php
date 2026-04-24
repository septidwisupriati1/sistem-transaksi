@extends('layouts.app')

@section('content')

{{-- Kartu Ringkasan --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div style="font-size: 2rem;">📦</div>
                <div class="fs-4 fw-bold text-primary">{{ $totalBarang }}</div>
                <div class="text-muted small">Total Barang</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div style="font-size: 2rem;">🧾</div>
                <div class="fs-4 fw-bold text-success">{{ $totalTransaksi }}</div>
                <div class="text-muted small">Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div style="font-size: 2rem;">🛒</div>
                <div class="fs-4 fw-bold text-warning">{{ $totalItemTerjual }}</div>
                <div class="text-muted small">Item Terjual</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div style="font-size: 2rem;">💰</div>
                <div class="fs-4 fw-bold text-danger">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="text-muted small">Total Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Grafik Barang Terlaris --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title mb-3">Grafik Barang Terlaris</h6>
                <canvas id="chartBarang" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Barang Terlaris Table --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title mb-3">Top 5 Barang Terlaris</h6>
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangTerlaris as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td><span class="badge bg-primary">{{ $item->total_terjual }}</span></td>
                            <td class="small">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Transaksi Terbaru --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="card-title mb-0">Transaksi Terbaru</h6>
            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $t)
                <tr>
                    <td>{{ $t->kode_transaksi }}</td>
                    <td>{{ $t->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $t->jumlah_barang }}</td>
                    <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($barangTerlaris->pluck('barang.nama_barang'));
    const data   = @json($barangTerlaris->pluck('total_terjual'));

    new Chart(document.getElementById('chartBarang'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: data,
                backgroundColor: [
                    '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'
                ],
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endsection