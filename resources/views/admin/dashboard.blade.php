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

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-start border-4 border-teal border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Produk</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalProducts }}</h3>
                </div>
                <div class="rounded-3 p-3 bg-teal-light text-teal fs-4">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top">
                <a href="{{ route('product.index') }}" class="small text-teal text-decoration-none fw-semibold">
                    Kelola Produk &rarr;
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-start border-4 border-primary border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Supplier</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalSuppliers }}</h3>
                </div>
                <div class="rounded-3 p-3 bg-primary-subtle text-primary fs-4">
                    <i class="bi bi-truck"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top">
                <a href="{{ route('supplier.index') }}" class="small text-primary text-decoration-none fw-semibold">
                    Kelola Supplier &rarr;
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-start border-4 border-success border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Transaksi</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalTransactions }}</h3>
                </div>
                <div class="rounded-3 p-3 bg-success-subtle text-success fs-4">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top">
                <a href="{{ route('transactions.index') }}" class="small text-success text-decoration-none fw-semibold">
                    Lihat Transaksi &rarr;
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom p-3 border-start border-4 border-warning border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Pendapatan</span>
                    <h4 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                </div>
                <div class="rounded-3 p-3 bg-warning-subtle text-warning fs-4">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top">
                <span class="small text-muted">{{ $totalCustomers }} Akun Pembeli</span>
            </div>
        </div>
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
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
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
                                        <td>
                                            <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-sm btn-outline-teal">
                                                <i class="bi bi-eye"></i> Detail
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

