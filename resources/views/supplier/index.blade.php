@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
        <h1 class="page-title d-flex align-items-center gap-2">
            <i class="bi bi-truck text-primary"></i>
            Daftar Supplier
        </h1>
        <p class="page-subtitle">Kelola informasi mitra pemasok dan data kontak untuk kebutuhan pengadaan.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Supplier
        </a>
    </div>
</div>

<div class="card card-custom overflow-hidden">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold text-dark">Data Mitra Supplier</h5>
            <small class="text-muted">Menampilkan seluruh rekanan supplier yang terdaftar</small>
        </div>
        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-medium">
            <i class="bi bi-database me-1"></i> {{ $suppliers->count() }} Data
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">#</th>
                    <th>Nama Supplier</th>
                    <th>Nomor Telepon / HP</th>
                    <th>Alamat Email</th>
                    <th>Tanggal Terdaftar</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <span class="fw-bold text-dark">
                                    {{ $supplier->supplier_name }}
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($supplier->phone)
                                <a href="tel:{{ $supplier->phone }}" class="text-decoration-none text-dark d-inline-flex align-items-center gap-1 fw-medium">
                                    <i class="bi bi-telephone text-primary"></i>
                                    {{ $supplier->phone }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-envelope text-primary"></i>
                                    {{ $supplier->email }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $supplier->created_at ? $supplier->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-light border text-primary px-2 py-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier {{ $supplier->supplier_name }}?');" class="d-inline">
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
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-building-slash fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Belum ada supplier terdaftar</h6>
                                <p class="text-muted small mb-3">Tambahkan supplier pertama untuk mulai menghubungkannya dengan produk.</p>
                                <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg"></i> Tambah Supplier Pertama
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
