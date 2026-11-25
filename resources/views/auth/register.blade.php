@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center gap-2 fw-extrabold" style="font-size:1.5rem;letter-spacing:2px;color:var(--rupia-navy);">
                <span class="rupia-brand-mark" style="background:var(--rupia-green-soft);color:var(--rupia-green-dark);">
                    <i class="bi bi-wallet2"></i>
                </span>
                <span>RUPIA</span>
            </div>
            <p class="text-muted small mt-1 mb-0">Buat akun baru untuk mulai mencatat arus kas</p>
        </div>

        <div class="rupia-card">
            <div class="card-body p-4">
                <h2 class="h5 fw-bold text-center mb-4" style="color:var(--rupia-navy);">Daftar Akun RUPIA</h2>
                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password (minimal 8 karakter)</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">Ulangi password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                    <button class="btn btn-rupia-primary w-100 py-2" type="submit">Daftar</button>
                </form>
                <p class="text-center small text-muted mt-3 mb-0">
                    Sudah punya akun? <a class="fw-semibold text-decoration-none" style="color:var(--rupia-green-dark);" href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection