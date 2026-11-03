@extends('layouts.app')

@section('title', 'Nota Pembelian ' . $transaction->invoice_number)

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 no-print">
    <div>
        <a href="{{ route('pembeli.transactions') }}" class="btn btn-sm btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Belanja
        </a>
        <h1 class="page-title">Nota Bukti Pembelian</h1>
        <p class="page-subtitle">Terima kasih atas pesanan Anda. Berikut adalah rincian transaksi belanja Anda.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pembeli.shop') }}" class="btn btn-outline-teal">
            <i class="bi bi-cart-plus"></i> Belanja Lagi
        </a>
        <button onclick="window.print()" class="btn btn-teal">
            <i class="bi bi-printer"></i> Cetak Nota
        </button>
    </div>
</div>

<div class="card card-custom p-4 mb-4">
    <!-- Header Nota -->
    <div class="row align-items-center pb-4 mb-4 border-bottom">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="navbar-brand-icon">
                    <i class="bi bi-shop"></i>
                </span>
                <h4 class="fw-bold mb-0 text-dark">PWL Store</h4>
            </div>
            <p class="text-muted small mb-0">
                Pusat Belanja Produk Terbaik Mahasiswa PWL 2026<br>
                Jl. Kampus PWL No. 2026 • Telp: (021) 1234567
            </p>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6 mb-2">
                <i class="bi bi-check-circle-fill me-1"></i> Pembayaran Berhasil
            </span>
            <h5 class="fw-bold font-monospace text-dark mb-1">{{ $transaction->invoice_number }}</h5>
            <div class="text-muted small">Waktu Transaksi: {{ $transaction->created_at->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <!-- Data Pelanggan -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-light border">
                <span class="text-muted small text-uppercase fw-bold d-block mb-1">Ditujukan Kepada:</span>
                <div class="fw-bold text-dark fs-6">{{ $transaction->user->name ?? Auth::user()->name }}</div>
                <div class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $transaction->user->email ?? Auth::user()->email }}</div>
                <div class="text-muted small mt-1">Status: <span class="badge bg-success">Pelanggan Terdaftar</span></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-light border">
                <span class="text-muted small text-uppercase fw-bold d-block mb-1">Status Pembayaran:</span>
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-muted">Metode:</span>
                    <span class="fw-semibold">Pembayaran Lunas (Cash / Digital)</span>
                </div>
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-muted">Status Pesanan:</span>
                    <span class="badge bg-success">Pesanan Selesai</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">No. Referensi:</span>
                    <span class="fw-semibold font-monospace">TRX-{{ $transaction->id }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Produk (Transaction Details) -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-custom">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama Barang / Produk</th>
                    <th>Kode Barcode</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center" style="width: 100px;">Jumlah</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $index => $detail)
                    @php
                        $itemSubtotal = $detail->price * $detail->quantity;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $detail->product->product_name ?? 'Produk' }}</div>
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
                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
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
                    <td colspan="5" class="text-end fw-bold fs-5 text-dark">Total Pembayaran:</td>
                    <td class="text-end fw-bold fs-5 text-teal">
                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Catatan Penutup -->
    <div class="text-center text-muted small pt-3 border-top">
        <p class="mb-1 fw-semibold text-dark">Terima kasih atas pesanan dan kepercayaan Anda!</p>
        <p class="mb-0">Simpan nota ini sebagai bukti pembayaran sah pembelian Anda.</p>
    </div>
</div>
@endsection

