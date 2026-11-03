@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h1 class="page-title">Data Transaksi Penjualan</h1>
        <p class="page-subtitle">Daftar seluruh transaksi pembelian yang dilakukan oleh pelanggan/pembeli.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('transactions.create') }}" class="btn btn-teal">
            <i class="bi bi-plus-circle"></i> Buat Transaksi Manual
        </a>
    </div>
</div>

<!-- Header Statistik Mini -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card card-custom p-3 bg-white border-start border-4 border-teal">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">Total Keseluruhan Transaksi</span>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalTransactions }} Transaksi</h4>
                </div>
                <div class="rounded-3 p-2 bg-teal-light text-teal fs-3">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card card-custom p-3 bg-white border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">Total Akumulasi Nilai Transaksi</span>
                    <h4 class="fw-bold mb-0 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                </div>
                <div class="rounded-3 p-2 bg-success-subtle text-success fs-3">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom">
    <div class="card-header-custom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="fw-bold text-dark">
            <i class="bi bi-list-check me-1 text-teal"></i> Daftar Riwayat Transaksi
        </div>
        <form method="GET" action="{{ route('transactions.index') }}" class="d-flex gap-2">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" placeholder="Cari invoice / pembeli..."
                    value="{{ request('search') }}">
                <button class="btn btn-teal" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            @if(request('search'))
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        @if ($transactions->isEmpty())
            <div class="p-5 text-center text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                <h5>Belum Ada Data Transaksi</h5>
                <p class="small mb-0">Transaksi yang dilakukan oleh pembeli atau admin akan muncul di halaman ini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Invoice</th>
                            <th>Pembeli</th>
                            <th>Tanggal & Waktu</th>
                            <th>Tipe</th>
                            <th>Jumlah Item</th>
                            <th>Total Belanja</th>
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
                                    @if ($trx->user)
                                        <div class="fw-semibold text-dark">{{ $trx->user->name }}</div>
                                        <small class="text-muted">{{ $trx->user->email }}</small>
                                    @else
                                        <span class="badge bg-secondary">Umum / Tanpa Akun</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $trx->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $trx->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border text-capitalize">
                                        {{ $trx->transaction_type }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-teal-light text-teal border border-teal-subtle">
                                        {{ $trx->details->sum('quantity') }} pcs ({{ $trx->details->count() }} produk)
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-outline-teal"
                                            title="Lihat Detail Nota">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi {{ $trx->invoice_number }}?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Transaksi">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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

