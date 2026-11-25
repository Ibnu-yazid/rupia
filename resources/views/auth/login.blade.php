@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center gap-2 fw-extrabold" style="font-size:1.5rem;letter-spacing:2px;color:var(--rupia-navy);">
                <span class="rupia-brand-mark" style="background:var(--rupia-green-soft);color:var(--rupia-green-dark);">
                    <i class="bi bi-wallet2"></i>
                </span>
                <span>RUPIA</span>
            </div>
            <p class="text-muted small mt-1 mb-0">Masuk untuk mengelola keuangan pribadimu</p>
        </div>

        <div class="rupia-card">
            <div class="card-body p-4">
                <h2 class="h5 fw-bold text-center mb-4" style="color:var(--rupia-navy);">Login RUPIA</h2>
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1">
                        <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                    </div>
                    <button class="btn btn-rupia-success w-100 py-2" type="submit">Login</button>
                </form>
                <p class="text-center small text-muted mt-3 mb-0">
                    Belum punya akun? <a class="fw-semibold text-decoration-none" style="color:var(--rupia-green-dark);" href="{{ route('register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection