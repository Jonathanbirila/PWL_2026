@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h1 class="page-title">Dashboard Administrator</h1>
        <p class="page-subtitle">Ringkasan inventaris, supplier, dan data transaksi penjualan toko.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('product.create') }}" class="btn btn-teal">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
        <a href="{{ route('supplier.create') }}" class="btn btn-outline-teal">
            <i class="bi bi-plus-circle"></i> Tambah Supplier
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Transaksi Penjualan Terbaru -->
    <div class="col-lg-7">
        <div class="card card-custom h-100">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="fw-bold text-dark">
                    <i class="bi bi-clock-history me-1 text-teal"></i> Transaksi Penjualan Terbaru
                </div>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-teal">
                    Semua Transaksi
                </a>
            </div>
            <div class="card-body p-0">
                @if ($recentTransactions->isEmpty())
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                        Belum ada transaksi penjualan yang tercatat.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransactions as $trx)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $trx->invoice_number }}</span>
                                            <div class="small text-muted">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-person me-1"></i>{{ $trx->user->name ?? 'Guest/Admin' }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-teal">
                                            Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-sm btn-outline-teal px-2 py-1">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Produk Terbaru -->
    <div class="col-lg-5">
        <div class="card card-custom h-100">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="fw-bold text-dark">
                    <i class="bi bi-box-seam me-1 text-teal"></i> Produk Tersedia
                </div>
                <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-teal">
                    Semua Produk
                </a>
            </div>
            <div class="card-body p-0">
                @if ($recentProducts->isEmpty())
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-box-arrow-in-down fs-1 d-block mb-2 text-secondary"></i>
                        Belum ada produk.
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach ($recentProducts as $prod)
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $prod->product_name }}</h6>
                                    <span class="badge-barcode">{{ $prod->barcode_number }}</span>
                                    <small class="text-muted ms-2">{{ $prod->supplier->supplier_name ?? '-' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-teal d-block">Rp {{ number_format($prod->sell_price, 0, ',', '.') }}</span>
                                    <small class="text-muted">Beli: Rp {{ number_format($prod->buy_price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
