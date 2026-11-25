@extends('layouts.app')

@section('title', 'Transaksi')
@section('heading', 'Manajemen Transaksi')

@section('content')
<div class="rupia-section-banner">
    <div>
        <span class="rupia-eyebrow">CASHFLOW LOG</span>
        <h2>Catat & Pantau Transaksi Harian</h2>
        <p>Masukkan transaksi pemasukan atau pengeluaran secara rutin agar saldo dan grafik selalu akurat.</p>
    </div>
    <span class="badge-rupia-income">
        <i class="bi bi-receipt me-1"></i>{{ $transactions->count() }} Transaksi
    </span>
</div>

<div class="rupia-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="rupia-card-title">Catat Transaksi Baru</h2>
            <span class="text-muted small">Kategori otomatis menyesuaikan tipe</span>
        </div>

        <form method="POST" action="{{ route('transactions.store') }}" class="row g-3">
            @csrf
            <div class="col-md-2">
                <label class="form-label" for="transaction_date">Tanggal</label>
                <input
                    class="form-control @error('transaction_date') is-invalid @enderror"
                    id="transaction_date"
                    type="date"
                    name="transaction_date"
                    value="{{ old('transaction_date', now()->toDateString()) }}"
                    required
                >
                @error('transaction_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label" for="type">Tipe</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="income" @selected(old('type') === 'income')>Pemasukan</option>
                    <option value="expense" @selected(old('type', 'expense') === 'expense')>Pengeluaran</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="category_id">Kategori</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    <option value="">-- Pilih kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" data-type="{{ $category->type }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label class="form-label" for="amount">Nominal (Rp)</label>
                <input
                    class="form-control @error('amount') is-invalid @enderror"
                    id="amount"
                    type="number"
                    min="0.01"
                    step="0.01"
                    placeholder="0"
                    name="amount"
                    value="{{ old('amount') }}"
                    required
                >
                @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label" for="description">Keterangan</label>
                <input
                    class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    placeholder="Opsional, mis. Kopi pagi"
                    name="description"
                    value="{{ old('description') }}"
                >
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 pt-1">
                <button class="btn btn-rupia-success" type="submit">
                    <i class="bi bi-plus-circle me-1"></i>Simpan transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<div class="rupia-card overflow-hidden">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--rupia-border) !important;">
        <h2 class="rupia-card-title">Riwayat Transaksi</h2>
        <span class="text-muted small">Urutan transaksi terbaru</span>
    </div>

    <div class="table-responsive">
        <table class="table rupia-table align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td class="text-nowrap">{{ $transaction->transaction_date->format('d-m-Y') }}</td>
                    <td>
                        <span class="{{ $transaction->type === 'income' ? 'badge-rupia-income' : 'badge-rupia-expense' }}">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="fw-medium">{{ $transaction->category->name }}</td>
                    <td class="fw-bold" style="color: {{ $transaction->type === 'income' ? '#3d664b' : '#8f4335' }};">
                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
                    </td>
                    <td class="text-muted">{{ $transaction->description ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="rupia-empty-state">
                            <i class="bi bi-journal-x"></i>
                            <div class="fw-semibold mb-1" style="color: var(--rupia-navy);">Belum ada transaksi</div>
                            <div class="small">Catat transaksi pertama kamu menggunakan form di atas.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeInput = document.getElementById('type');
    const categoryInput = document.getElementById('category_id');
    function filterCategories() {
        for (const option of categoryInput.options) {
            option.hidden = option.value !== '' && option.dataset.type !== typeInput.value;
        }
        if (categoryInput.selectedOptions[0]?.hidden) categoryInput.value = '';
    }
    typeInput.addEventListener('change', filterCategories);
    filterCategories();
</script>
@endpush