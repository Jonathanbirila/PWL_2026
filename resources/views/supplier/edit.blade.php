@extends('layouts.app')

@section('title', 'Edit Supplier: ' . $supplier->supplier_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="mb-3">
            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-light border text-muted">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Supplier
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header-custom">
                <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i>
                    Edit Data Supplier
                </h5>
                <p class="text-muted small mb-0">Perbarui kontak dan informasi rekanan #{{ $supplier->id }} ({{ $supplier->supplier_name }}).</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="supplier_name" class="form-label">Nama Supplier / Perusahaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input 
                                type="text" 
                                class="form-control @error('supplier_name') is-invalid @enderror" 
                                id="supplier_name" 
                                name="supplier_name" 
                                value="{{ old('supplier_name', $supplier->supplier_name) }}" 
                                placeholder="Nama Supplier"
                                required
                            >
                            @error('supplier_name')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input 
                                type="text" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $supplier->phone) }}" 
                                placeholder="Contoh: 081234567890"
                                required
                            >
                            @error('phone')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $supplier->email) }}" 
                                placeholder="Email"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top">
                        <a href="{{ route('supplier.index') }}" class="btn btn-light border px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg"></i> Perbarui Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
