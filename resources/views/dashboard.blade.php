
@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard Keuangan')

@section('content')

<div class="rupia-dashboard">

    {{-- Welcome section --}}
    <div class="dashboard-welcome">
        <div>
            <span class="welcome-label">FINANCIAL OVERVIEW</span>
            <h2>Kelola keuanganmu dengan lebih baik.</h2>
            <p>Pantau pemasukan, pengeluaran, dan saldo keuanganmu di sini.</p>
        </div>

        <div class="welcome-date">
            <span>Hari ini</span>
            <strong>{{ now()->format('d M Y') }}</strong>
        </div>
    </div>

    {{-- Financial summary --}}
    <div class="row g-3 summary-grid">

        {{-- Income --}}
        <div class="col-md-4">
            <div class="finance-card income-card">
                <div class="finance-card-top">
                    <div>
                        <span class="finance-label">TOTAL PEMASUKAN</span>
                        <div class="finance-icon">
                            <i class="bi bi-arrow-down-left"></i>
                        </div>
                    </div>
                    <span class="finance-indicator">INCOME</span>
                </div>

                <h3>Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                <p>Total seluruh pemasukan tercatat</p>
            </div>
        </div>

        {{-- Expense --}}
        <div class="col-md-4">
            <div class="finance-card expense-card">
                <div class="finance-card-top">
                    <div>
                        <span class="finance-label">TOTAL PENGELUARAN</span>
                        <div class="finance-icon">
                            <i class="bi bi-arrow-up-right"></i>
                        </div>
                    </div>
                    <span class="finance-indicator">EXPENSE</span>
                </div>

                <h3>Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                <p>Total seluruh pengeluaran tercatat</p>
            </div>
        </div>

        {{-- Balance --}}
        <div class="col-md-4">
            <div class="finance-card balance-card">
                <div class="finance-card-top">
                    <div>
                        <span class="finance-label">SISA SALDO</span>
                        <div class="finance-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                    <span class="finance-indicator">BALANCE</span>
                </div>

                <h3>Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                <p>Saldo dari seluruh transaksi tercatat</p>
            </div>
        </div>

    </div>

    {{-- Quick access --}}
    <div class="dashboard-panel mt-4">

        <div class="panel-heading">
            <div>
                <span class="welcome-label">QUICK ACCESS</span>
                <h4>Akses Cepat</h4>
                <p>Pilih aktivitas yang ingin kamu lakukan.</p>
            </div>

            <div class="panel-heading-icon">
                <i class="bi bi-grid"></i>
            </div>
        </div>

        <div class="quick-access-grid">

            <a href="{{ route('transactions.index') }}"
               class="quick-access-item">

                <div class="quick-icon transaction-icon">
                    <i class="bi bi-plus-lg"></i>
                </div>

                <div>
                    <strong>Catat Transaksi</strong>
                    <span>Tambahkan pemasukan atau pengeluaran</span>
                </div>

                <i class="bi bi-arrow-up-right quick-arrow"></i>
            </a>

            <a href="{{ route('categories.index') }}"
               class="quick-access-item">

                <div class="quick-icon category-icon">
                    <i class="bi bi-collection"></i>
                </div>

                <div>
                    <strong>Kelola Kategori</strong>
                    <span>Atur kategori keuanganmu</span>
                </div>

                <i class="bi bi-arrow-up-right quick-arrow"></i>
            </a>

        </div>
    </div>

    {{-- Footer note --}}
    <div class="dashboard-footer">
        <i class="bi bi-shield-check"></i>
        <span>Catatan keuanganmu tersimpan di RUPIA.</span>
    </div>

</div>

@endsection
