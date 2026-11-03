@extends('layouts.app')

@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
        </a>
        <h1 class="page-title">Buat Transaksi Baru (Admin)</h1>
        <p class="page-subtitle">Input transaksi penjualan langsung dan cetak faktur.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="card card-custom mb-4">
                <div class="card-header-custom fw-bold text-dark">
                    <i class="bi bi-person-badge me-1 text-teal"></i> Informasi Transaksi
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Pilih Pembeli (Customer)</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="">-- Pelanggan Umum / Anonim --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="transaction_type" class="form-label">Tipe Transaksi</label>
                            <select name="transaction_type" id="transaction_type" class="form-select" required>
                                <option value="penjualan" selected>Penjualan ke Pelanggan</option>
                                <option value="pembelian">Pembelian dari Supplier</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mb-4">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><i class="bi bi-cart me-1 text-teal"></i> Rincian Produk (Items)</span>
                    <button type="button" class="btn btn-sm btn-outline-teal" id="add-row">
                        <i class="bi bi-plus-lg"></i> Tambah Baris
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0" id="items-table">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Produk</th>
                                    <th style="width: 25%;">Kuantitas (Qty)</th>
                                    <th style="width: 25%;" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="items-container">
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][product_id]" class="form-select product-select" required>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->sell_price }}">
                                                    {{ $product->product_name }} (Rp {{ number_format($product->sell_price, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control qty-input" min="1" value="1" required>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light p-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-teal">
                        <i class="bi bi-check-circle me-1"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let rowIndex = 1;
    const container = document.getElementById('items-container');
    const addBtn = document.getElementById('add-row');

    addBtn.addEventListener('click', function() {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Update names
        newRow.querySelector('.product-select').name = `items[${rowIndex}][product_id]`;
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.qty-input').name = `items[${rowIndex}][quantity]`;
        newRow.querySelector('.qty-input').value = 1;

        const removeBtn = newRow.querySelector('.remove-row');
        removeBtn.disabled = false;
        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });

        container.appendChild(newRow);
        rowIndex++;
    });
</script>
@endpush
@endsection

