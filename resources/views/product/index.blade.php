@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
        <h1 class="page-title d-flex align-items-center gap-2">
            <i class="bi bi-box-seam text-primary"></i>
            Daftar Produk
        </h1>
        <p class="page-subtitle">Kelola dan pantau seluruh data inventaris produk serta informasi harga.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>
</div>


<div class="card card-custom overflow-hidden">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold text-dark">Tabel Inventaris Produk</h5>
            <small class="text-muted">Menampilkan semua produk yang terdaftar</small>
        </div>
        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-medium">
            <i class="bi bi-database me-1"></i> {{ $gets->count() }} Data
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">#</th>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Supplier</th>
                    <th class="text-end">Harga Beli</th>
                    <th class="text-end">Harga Jual</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gets as $get)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge-barcode">
                                <i class="bi bi-upc-scan me-1 text-primary"></i>{{ $get->barcode_number }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">
                                {{ $get->product_name }}
                            </span>
                        </td>
                        <td>
                            @if($get->supplier)
                                <span class="badge bg-light text-primary border border-primary-subtle px-2.5 py-1.5 rounded-2">
                                    <i class="bi bi-building me-1"></i>{{ $get->supplier->supplier_name }}
                                </span>
                            @else
                                <span class="badge bg-light text-muted border px-2 py-1 rounded-2">
                                    Tidak ada supplier
                                </span>
                            @endif
                        </td>
                        <td class="text-end text-muted fw-medium">
                            Rp {{ number_format($get->buy_price, 0, ',', '.') }}
                        </td>
                        <td class="text-end fw-bold text-dark">
                            Rp {{ number_format($get->sell_price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('product.edit', $get->id) }}" class="btn btn-sm btn-light border text-primary px-2 py-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('product.destroy', $get->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $get->product_name }}?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger px-2 py-1" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Belum ada produk terdaftar</h6>
                                <p class="text-muted small mb-3">Mulai tambahkan produk baru ke dalam sistem inventaris Anda.</p>
                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg"></i> Tambah Produk Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection