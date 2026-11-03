@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $transaction->invoice_number)

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 no-print">
    <div>
        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
        </a>
        <h1 class="page-title">Nota / Faktur Transaksi</h1>
        <p class="page-subtitle">Detail rincian produk yang dibeli pada transaksi ini.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-teal">
            <i class="bi bi-printer"></i> Cetak Faktur / Nota
        </button>
    </div>
</div>

<div class="card card-custom p-4 mb-4">
    <!-- Invoice Header -->
    <div class="row align-items-center pb-4 mb-4 border-bottom">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="navbar-brand-icon">
                    <i class="bi bi-shop"></i>
                </span>
                <h4 class="fw-bold mb-0 text-dark">PWL Store & Inventaris</h4>
            </div>
            <p class="text-muted small mb-0">
                Jl. Kampus PWL No. 2026, Praktikum Web Lanjut<br>
                Email: support@pwlstore.test • Telp: (021) 1234567
            </p>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6 mb-2">
                <i class="bi bi-check-circle-fill me-1"></i> Transaksi Berhasil
            </span>
            <h5 class="fw-bold font-monospace text-dark mb-1">{{ $transaction->invoice_number }}</h5>
            <div class="text-muted small">Tanggal: {{ $transaction->created_at->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <!-- Data Pembeli & Info Transaksi -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-light border">
                <span class="text-muted small text-uppercase fw-bold d-block mb-2">Data Pelanggan / Pembeli:</span>
                @if ($transaction->user)
                    <div class="fw-bold text-dark fs-6">{{ $transaction->user->name }}</div>
                    <div class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $transaction->user->email }}</div>
                    <div class="text-muted small mt-1">
                        <span class="badge bg-secondary">Role: {{ ucfirst($transaction->user->role) }}</span>
                    </div>
                @else
                    <div class="fw-bold text-dark fs-6">Pelanggan Umum (Tanpa Akun)</div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-light border">
                <span class="text-muted small text-uppercase fw-bold d-block mb-2">Informasi Pembayaran:</span>
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-muted">Metode Pembayaran:</span>
                    <span class="fw-semibold">Tunai / Transfer Bank</span>
                </div>
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-muted">Tipe Transaksi:</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-capitalize">
                        {{ $transaction->transaction_type }}
                    </span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Waktu Pencatatan:</span>
                    <span class="fw-semibold">{{ $transaction->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Produk (Transaction Details) -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-custom">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Produk</th>
                    <th>Kode Barcode</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center" style="width: 100px;">Jumlah</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $index => $detail)
                    @php
                        $subtotalItem = $detail->price * $detail->quantity;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $detail->product->product_name ?? 'Produk Dihapus' }}</div>
                            <small class="text-muted">{{ $detail->product->supplier->supplier_name ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge-barcode">{{ $detail->product->barcode_number ?? '-' }}</span>
                        </td>
                        <td class="text-end">
                            Rp {{ number_format($detail->price, 0, ',', '.') }}
                        </td>
                        <td class="text-center fw-semibold">
                            {{ $detail->quantity }}
                        </td>
                        <td class="text-end fw-bold text-dark">
                            Rp {{ number_format($subtotalItem, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="4" class="text-end fw-bold">Total Kuantitas:</td>
                    <td class="text-center fw-bold text-teal">{{ $transaction->details->sum('quantity') }} pcs</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-end fw-bold fs-5 text-dark">Grand Total Pembayaran:</td>
                    <td class="text-end fw-bold fs-5 text-teal">
                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Footer Nota -->
    <div class="text-center text-muted small pt-3 border-top">
        <p class="mb-1">Terima kasih telah berbelanja di PWL Store.</p>
        <p class="mb-0">Faktur ini merupakan bukti transaksi yang sah yang diterbitkan oleh sistem komputer.</p>
    </div>
</div>
@endsection

