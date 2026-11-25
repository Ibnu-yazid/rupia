@extends('layouts.app')

@section('title', 'Tentang RUPIA')
@section('heading', 'Tentang Tim Pengembang')

@section('content')
<div class="rupia-section-banner">
    <div>
        <span class="rupia-eyebrow">ABOUT APPLICATION</span>
        <h2>RUPIA (Recording, Understanding & Planning Income Allocation)</h2>
        <p>Aplikasi web manajemen keuangan pribadi untuk membantu pengguna mengelola arus kas secara transparan dan terstruktur.</p>
    </div>
    <span class="panel-heading-icon">
        <i class="bi bi-wallet2"></i>
    </span>
</div>

<div class="rupia-card">
    <div class="card-body p-4">
        <h3 class="rupia-card-title mb-3">Tim Pengembang RUPIA</h3>
        <div class="row g-2">
            @foreach (['Agung Cahya', 'Irham Fariz', 'Hilmi Nazwal', 'Ibnu Yazid Syach', 'Reza Rismawan'] as $member)
                <div class="col-md-6">
                    <div class="p-3 rounded-3 d-flex align-items-center gap-3" style="background:#f8faf6;border:1px solid var(--rupia-border);">
                        <span class="quick-icon transaction-icon" style="width:36px;height:36px;font-size:15px;">
                            <i class="bi bi-person-check"></i>
                        </span>
                        <span class="fw-semibold" style="color:var(--rupia-navy);">{{ $member }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-muted small mt-4 mb-0">
            <i class="bi bi-mortarboard me-1" style="color:var(--rupia-green);"></i>
            Program Studi Informatika - Kelas A 24 | Fakultas Sains dan Informatika | Universitas Jenderal Achmad Yani
        </p>
    </div>
</div>
@endsection