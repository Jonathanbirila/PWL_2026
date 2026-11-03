@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="p-4 text-center text-white" style="background: var(--primary-gradient);">
        <div class="d-inline-flex align-items-center justify-content-center bg-white text-teal rounded-circle mb-2" style="width: 48px; height: 48px;">
            <i class="bi bi-person-plus-fill fs-4"></i>
        </div>
        <h4 class="fw-bold mb-1">Daftar Akun Baru</h4>
        <p class="small text-white-50 mb-0">Silakan isi data untuk registrasi</p>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                    id="name" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Contoh: Budi Santoso">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                    id="email" name="email" value="{{ old('email') }}" required
                    placeholder="nama@example.com">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role Akun</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="pembeli" {{ old('role', 'pembeli') === 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                    id="password" name="password" required placeholder="Minimal 6 karakter">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" 
                    id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
            </div>

            <button type="submit" class="btn btn-teal w-100 justify-content-center py-2 mb-3">
                <i class="bi bi-check-lg me-1"></i> Daftar Sekarang
            </button>
        </form>

        <div class="text-center small text-muted">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-teal fw-semibold text-decoration-none">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
