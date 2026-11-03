@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="p-4 text-center text-white" style="background: var(--primary-gradient);">
        <div class="d-inline-flex align-items-center justify-content-center bg-white text-teal rounded-circle mb-2" style="width: 48px; height: 48px;">
            <i class="bi bi-shield-lock-fill fs-4"></i>
        </div>
        <h4 class="fw-bold mb-1">Masuk ke Akun</h4>
        <p class="small text-white-50 mb-0">Login sebagai Admin atau Pembeli</p>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                    id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@example.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                    id="password" name="password" required placeholder="Masukkan password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-teal w-100 justify-content-center py-2 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
            </button>
        </form>

        <div class="text-center small text-muted">
            Belum punya akun? <a href="{{ route('register') }}" class="text-teal fw-semibold text-decoration-none">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection
