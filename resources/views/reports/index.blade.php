@extends('layouts.app')

@section('title', 'Laporan')
@section('heading', 'Laporan & Grafik Keuangan')

@section('content')
<div class="rupia-section-banner">
    <div>
        <span class="rupia-eyebrow">FINANCIAL ANALYTICS</span>
        <h2>Ringkasan Visual & Tren Arus Kas</h2>
        <p>Bandingkan proporsi pengeluaran per kategori dan pergerakan pemasukan serta pengeluaran bulanan.</p>
    </div>
    <div class="welcome-date text-end">
        <span>Periode</span>
        <strong>{{ now()->translatedFormat('F Y') }}</strong>
    </div>
</div>

@php
    $hasCategoryData = collect($categoryTotals ?? [])->sum(fn ($v) => (float) $v) > 0;
    $hasCashflowData = collect($incomeTotals ?? [])->sum(fn ($v) => (float) $v) > 0
        || collect($expenseTotals ?? [])->sum(fn ($v) => (float) $v) > 0;
@endphp

<div class="row g-4">
    <div class="col-xl-6">
        <div class="rupia-card h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="rupia-card-title">Pengeluaran Berdasarkan Kategori</h2>
                        <p class="text-muted small mb-0">Distribusi porsi pengeluaran tercatat</p>
                    </div>
                    <span class="panel-heading-icon" style="background:#faefec;color:#c77e70;">
                        <i class="bi bi-pie-chart"></i>
                    </span>
                </div>

                @if ($hasCategoryData)
                    <div class="flex-grow-1" style="min-height: 300px; height: 300px;">
                        <canvas id="expenseChart"></canvas>
                    </div>
                @else
                    <div class="rupia-empty-state my-auto">
                        <i class="bi bi-pie-chart"></i>
                        <div class="fw-semibold mb-1" style="color: var(--rupia-navy);">Belum ada data pengeluaran</div>
                        <div class="small">Grafik kategori akan muncul setelah transaksi pengeluaran dicatat.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="rupia-card h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="rupia-card-title">Tren Arus Keuangan Bulanan</h2>
                        <p class="text-muted small mb-0">Perbandingan pemasukan dan pengeluaran</p>
                    </div>
                    <span class="panel-heading-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>
                </div>

                <div class="flex-grow-1" style="min-height: 300px; height: 300px;">
                    <canvas id="cashflowChart"></canvas>
                </div>
                @unless ($hasCashflowData)
                    <div class="text-center text-muted small mt-2">
                        Belum ada aktivitas transaksi bulanan — seluruh nilai saat ini Rp 0.
                    </div>
                @endunless
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rupiahFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    @if ($hasCategoryData)
    new Chart(document.getElementById('expenseChart'), {
        type: 'doughnut',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                data: @json($categoryTotals),
                backgroundColor: ['#c77e70', '#d49a6a', '#789b83', '#718ba7', '#9b8ab4', '#6b9ac4'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.label}: ${rupiahFormatter.format(ctx.parsed || 0)}`
                    }
                }
            }
        }
    });
    @endif

    new Chart(document.getElementById('cashflowChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($incomeTotals),
                    borderColor: '#789b83',
                    backgroundColor: 'rgba(120, 155, 131, 0.16)',
                    borderWidth: 2.5,
                    tension: 0.35,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: @json($expenseTotals),
                    borderColor: '#c77e70',
                    backgroundColor: 'rgba(199, 126, 112, 0.14)',
                    borderWidth: 2.5,
                    tension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => rupiahFormatter.format(value)
                    }
                }
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${rupiahFormatter.format(ctx.parsed.y || 0)}`
                    }
                }
            }
        }
    });
</script>
@endpush