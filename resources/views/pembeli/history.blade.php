@extends('layouts.app')

@section('title', 'Riwayat Transaksi Saya')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h1 class="page-title">Riwayat Belanja Saya</h1>
        <p class="page-subtitle">Daftar semua faktur dan nota transaksi belanja yang pernah Anda lakukan.</p>
    </div>
    <div>
        <a href="{{ route('pembeli.shop') }}" class="btn btn-teal">
            <i class="bi bi-cart-plus me-1"></i> Belanja Produk Lagi
        </a>
    </div>
</div>

<div class="card card-custom">
    <div class="card-header-custom fw-bold text-dark">
        <i class="bi bi-clock-history me-1 text-teal"></i> Daftar Pesanan & Faktur
    </div>
    <div class="card-body p-0">
        @if ($transactions->isEmpty())
            <div class="p-5 text-center text-muted">
                <i class="bi bi-bag-x fs-1 d-block mb-3 text-secondary"></i>
                <h5>Anda Belum Memiliki Transaksi</h5>
                <p class="small mb-3">Yuk mulai belanja sekarang dan temukan berbagai produk menarik!</p>
                <a href="{{ route('pembeli.shop') }}" class="btn btn-teal">
                    <i class="bi bi-shop me-1"></i> Buka Katalog Toko
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Invoice</th>
                            <th>Tanggal Pembelian</th>
                            <th>Rincian Produk</th>
                            <th>Total Belanja</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $index => $trx)
                            <tr>
                                <td>{{ $transactions->firstItem() + $index }}</td>
                                <td>
                                    <span class="fw-bold text-teal font-monospace">{{ $trx->invoice_number }}</span>
                                </td>
                                <td>
                                    <div>{{ $trx->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $trx->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $trx->details->sum('quantity') }} barang ({{ $trx->details->count() }} macam)
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('pembeli.transaction.detail', $trx->id) }}" class="btn btn-sm btn-outline-teal">
                                        <i class="bi bi-receipt"></i> Lihat Nota
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $transactions->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

