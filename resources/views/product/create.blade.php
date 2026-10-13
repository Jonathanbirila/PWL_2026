@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="mb-3">
            <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header-custom d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam text-teal"></i>
                        Tambah Produk Baru
                    </h5>
                    <p class="text-muted small mb-0">Isi formulir berikut untuk mendaftarkan produk baru ke sistem.</p>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="barcode_number" class="form-label">Kode Barcode <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input 
                                type="text" 
                                class="form-control @error('barcode_number') is-invalid @enderror" 
                                id="barcode_number" 
                                name="barcode_number" 
                                value="{{ old('barcode_number') }}" 
                                placeholder="Contoh: BRG-001 atau 899123456789"
                                required
                            >
                            @error('barcode_number')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                            <input 
                                type="text" 
                                class="form-control @error('product_name') is-invalid @enderror" 
                                id="product_name" 
                                name="product_name" 
                                value="{{ old('product_name') }}" 
                                placeholder="Contoh: Kopi Bubuk Robusta 250g"
                                required
                            >
                            @error('product_name')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="supplier_id" class="form-label mb-0">Supplier / Pemasok <span class="text-danger">*</span></label>
                            <a href="{{ route('supplier.create') }}" class="small text-teal text-decoration-none fw-medium">
                                <i class="bi bi-plus"></i> Tambah Supplier Baru
                            </a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <select 
                                class="form-select @error('supplier_id') is-invalid @enderror" 
                                id="supplier_id" 
                                name="supplier_id" 
                                required
                            >
                                <option value="" disabled {{ old('supplier_id') ? '' : 'selected' }}>-- Pilih Supplier --</option>
                                @forelse ($supp as $s)
                                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->supplier_name }} ({{ $s->phone ?? $s->email }})
                                    </option>
                                @empty
                                    <option value="" disabled>Belum ada data supplier</option>
                                @endforelse
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($supp->isEmpty())
                            <div class="alert alert-warning py-2 px-3 mt-2 small d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>Belum ada supplier. Silakan <a href="{{ route('supplier.create') }}" class="alert-link">buat supplier</a> terlebih dahulu sebelum menambahkan produk.</span>
                            </div>
                        @endif
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="buy_price" class="form-label">Harga Beli (Modal) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text fw-semibold text-muted">Rp</span>
                                <input 
                                    type="number" 
                                    class="form-control @error('buy_price') is-invalid @enderror" 
                                    id="buy_price" 
                                    name="buy_price" 
                                    value="{{ old('buy_price') }}" 
                                    placeholder="0"
                                    min="0"
                                    required
                                >
                                @error('buy_price')
                                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="sell_price" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text fw-semibold text-muted">Rp</span>
                                <input 
                                    type="number" 
                                    class="form-control @error('sell_price') is-invalid @enderror" 
                                    id="sell_price" 
                                    name="sell_price" 
                                    value="{{ old('sell_price') }}" 
                                    placeholder="0"
                                    min="0"
                                    required
                                >
                                @error('sell_price')
                                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons: Split Layout (Left: Batal, Right: Simpan) -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-teal px-4">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection