<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'RUPIA') - RUPIA</title>

    <!-- Google Font: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- RUPIA Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/rupia-style.css') }}">
</head>
<body class="rupia-body">
@auth
    <aside class="rupia-sidebar">
        <div class="rupia-brand">
            <span class="rupia-brand-mark"><i class="bi bi-wallet2"></i></span>
            <span>RUPIA</span>
        </div>
        <nav class="nav flex-column rupia-nav">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Transaksi</span>
            </a>
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Laporan</span>
            </a>
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                <i class="bi bi-info-circle"></i>
                <span>About Us</span>
            </a>
        </nav>
    </aside>
@endauth

<main class="{{ auth()->check() ? 'rupia-page' : 'rupia-auth-page' }}">
    @auth
        <header class="rupia-topbar d-flex justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <h1 class="rupia-page-title mb-0">@yield('heading', 'Dashboard Keuangan')</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-sm-3">
                <span class="rupia-user-chip d-none d-sm-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-circle"></i>
                    <span>Halo, {{ auth()->user()->name }}</span>
                </span>
                <a class="btn btn-rupia-outline btn-sm" href="{{ route('profile.edit') }}">
                    <i class="bi bi-gear me-1"></i>Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="btn btn-rupia-danger-outline btn-sm" type="submit">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </header>
    @endauth

    <div class="{{ auth()->check() ? 'rupia-content' : 'container py-5' }}">
        @if (session('success'))
            <div class="alert rupia-alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert rupia-alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>