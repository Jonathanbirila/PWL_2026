@extends('layouts.app')

@section('title', 'Katalog Belanja')

@section('content')
<!-- Hero Banner -->
<div class="card card-custom border-0 text-white mb-4 overflow-hidden" style="background: var(--primary-gradient);">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-teal px-3 py-2 rounded-pill fw-bold mb-2">
                    <i class="bi bi-bag-heart-fill me-1"></i> Toko Resmi PWL
                </span>
                <h1 class="display-6 fw-bold mb-2">Selamat Berbelanja, {{ Auth::user()->name }}!</h1>
                <p class="lead mb-0 text-white-50">
                    Pilih produk berkualitas di bawah ini dan lakukan pemesanan secara instan. Transaksi Anda akan otomatis tercatat di sistem.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('pembeli.transactions') }}" class="btn btn-light text-teal fw-semibold px-4 py-2 shadow-sm rounded-pill">
                    <i class="bi bi-clock-history me-1"></i> Riwayat Belanja Saya
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="page-title">Katalog Produk Tersedia</h3>
        <p class="page-subtitle">Silakan pilih produk yang ingin Anda beli.</p>
    </div>
</div>

@if ($products->isEmpty())
    <div class="card card-custom p-5 text-center text-muted">
        <i class="bi bi-box2 fs-1 d-block mb-3 text-secondary"></i>
        <h5>Belum Ada Produk Tersedia</h5>
        <p class="mb-0">Saat ini belum ada produk yang dijual. Silakan hubungi Administrator untuk menambahkan produk.</p>
    </div>
@else
    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-custom h-100 border-0 shadow-sm transition-hover">
                    <div class="bg-light p-4 text-center rounded-top-3 border-bottom position-relative">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-teal-light text-teal border border-teal-subtle">
                            {{ $product->barcode_number }}
                        </span>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm text-teal" style="width: 72px; height: 72px;">
                            <i class="bi bi-box-seam fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-truck me-1"></i>{{ $product->supplier->supplier_name ?? 'Supplier Umum' }}
                        </small>
                        <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $product->product_name }}">
                            {{ $product->product_name }}
                        </h5>
                        <div class="mt-auto pt-2">
                            <div class="d-flex justify-content-between align-items-baseline mb-3">
                                <span class="text-muted small">Harga:</span>
                                <span class="fs-5 fw-bold text-teal">
                                    Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                                </span>
                            </div>
                            <button type="button" class="btn btn-teal w-100 justify-content-center py-2"
                                onclick="openBuyModal({{ $product->id }}, '{{ addslashes($product->product_name) }}', {{ $product->sell_price }}, '{{ $product->barcode_number }}')">
                                <i class="bi bi-cart-plus me-1"></i> Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Modal Checkout / Beli Produk -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <form action="{{ route('pembeli.checkout') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background: var(--primary-gradient);">
                    <h5 class="modal-title fw-bold" id="buyModalLabel">
                        <i class="bi bi-bag-check me-1"></i> Konfirmasi Pembelian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="items[0][product_id]" id="modal_product_id">

                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border mb-3">
                        <div class="rounded-3 bg-white p-3 text-teal shadow-sm">
                            <i class="bi bi-box-seam fs-2"></i>
                        </div>
                        <div>
                            <span class="badge-barcode mb-1 d-inline-block" id="modal_barcode">-</span>
                            <h5 class="fw-bold mb-1 text-dark" id="modal_product_name">-</h5>
                            <span class="fw-semibold text-teal fs-6" id="modal_product_price">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_quantity" class="form-label">Jumlah Pembelian (Qty)</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                            <input type="number" class="form-control text-center fw-bold fs-5" id="modal_quantity" 
                                name="items[0][quantity]" value="1" min="1" required oninput="calculateTotal()">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 bg-teal-light border border-teal-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-semibold">Total Pembayaran:</span>
                            <span class="fs-4 fw-bold text-teal" id="modal_subtotal">Rp 0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-teal px-4">
                        <i class="bi bi-check2-circle me-1"></i> Checkout & Bayar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentPrice = 0;
    const buyModal = new bootstrap.Modal(document.getElementById('buyModal'));

    function openBuyModal(id, name, price, barcode) {
        document.getElementById('modal_product_id').value = id;
        document.getElementById('modal_product_name').innerText = name;
        document.getElementById('modal_barcode').innerText = barcode;
        document.getElementById('modal_product_price').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('modal_quantity').value = 1;
        
        currentPrice = price;
        calculateTotal();
        buyModal.show();
    }

    function changeQty(delta) {
        const qtyInput = document.getElementById('modal_quantity');
        let current = parseInt(qtyInput.value) || 1;
        current += delta;
        if (current < 1) current = 1;
        qtyInput.value = current;
        calculateTotal();
    }

    function calculateTotal() {
        const qtyInput = document.getElementById('modal_quantity');
        let qty = parseInt(qtyInput.value) || 1;
        if (qty < 1) qty = 1;
        const total = currentPrice * qty;
        document.getElementById('modal_subtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endpush
@endsection

