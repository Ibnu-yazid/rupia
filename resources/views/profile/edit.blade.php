@extends('layouts.app')

@section('title', 'Profil')
@section('heading', 'Edit Profil Pengguna')

@section('content')
<div class="rupia-section-banner">
    <div>
        <span class="rupia-eyebrow">ACCOUNT SETTINGS</span>
        <h2>Pengaturan Akun & Profil</h2>
        <p>Perbarui foto profil, informasi akun, maupun kata sandi keamanan kamu.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="rupia-card">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="text-center mb-4">
                        @if ($user->photo_path)
                            <img
                                src="{{ asset('storage/'.$user->photo_path) }}"
                                alt="Foto profil"
                                class="rounded-circle border"
                                width="112"
                                height="112"
                                style="object-fit: cover; border-color: var(--rupia-border) !important;"
                            >
                        @else
                            <div
                                class="d-inline-flex align-items-center justify-content-center rounded-circle mx-auto"
                                style="width: 112px; height: 112px; background: var(--rupia-green-soft); color: var(--rupia-green-dark); font-size: 2.5rem;"
                            >
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="photo">Foto profil (JPG/PNG, maks. 2 MB)</label>
                        <input class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" type="file" accept="image/*">
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nama lengkap</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4" style="border-color: var(--rupia-border);">

                    <div class="mb-3">
                        <label class="form-label" for="password">Password baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span></label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">Ulangi password baru</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                    </div>

                    <button class="btn btn-rupia-primary w-100 py-2" type="submit">
                        <i class="bi bi-check2-circle me-1"></i>Simpan perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection