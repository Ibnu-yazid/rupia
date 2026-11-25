@extends('layouts.app')

@section('title', 'Kategori')
@section('heading', 'Kelola Kategori')

@section('content')
<div class="rupia-section-banner">
    <div>
        <span class="rupia-eyebrow">CATEGORY MANAGEMENT</span>
        <h2>{{ isset($category) ? 'Perbarui Kategori Keuangan' : 'Atur Kategori Pemasukan & Pengeluaran' }}</h2>
        <p>Kelompokkan transaksi agar pencatatan arus kas dan analisis laporan lebih terstruktur.</p>
    </div>
    <span class="badge-rupia-income">
        <i class="bi bi-tags me-1"></i>{{ $categories->count() }} Kategori
    </span>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="rupia-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="rupia-card-title">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h2>
                    <span class="panel-heading-icon" style="width:34px;height:34px;font-size:15px;">
                        <i class="bi {{ isset($category) ? 'bi-pencil-square' : 'bi-plus-lg' }}"></i>
                    </span>
                </div>

                <form method="POST" action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}">
                    @csrf
                    @if (isset($category)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label" for="name">Nama kategori</label>
                        <input
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            placeholder="Contoh: Gaji, Makan Siang, Transport"
                            value="{{ old('name', $category->name ?? '') }}"
                            required
                        >
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="type">Tipe</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="income" @selected(old('type', $category->type ?? '') === 'income')>Pemasukan</option>
                            <option value="expense" @selected(old('type', $category->type ?? '') === 'expense')>Pengeluaran</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-rupia-primary" type="submit">
                            <i class="bi bi-check2 me-1"></i>{{ isset($category) ? 'Simpan perubahan' : 'Tambah kategori' }}
                        </button>
                        @if (isset($category))
                            <a class="btn btn-rupia-outline" href="{{ route('categories.index') }}">Batal</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="rupia-card overflow-hidden">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--rupia-border) !important;">
                <h2 class="rupia-card-title">Daftar kategori</h2>
                <span class="text-muted small">Tersimpan otomatis per akun</span>
            </div>

            <div class="table-responsive">
                <table class="table rupia-table align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($categories as $item)
                        <tr>
                            <td class="fw-semibold" style="color: var(--rupia-navy);">{{ $item->name }}</td>
                            <td>
                                <span class="{{ $item->type === 'income' ? 'badge-rupia-income' : 'badge-rupia-expense' }}">
                                    <i class="bi {{ $item->type === 'income' ? 'bi-arrow-down-left' : 'bi-arrow-up-right' }} me-1"></i>
                                    {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-rupia-outline btn-sm me-1" href="{{ route('categories.edit', $item) }}">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form class="d-inline" method="POST" action="{{ route('categories.destroy', $item) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-rupia-danger-outline btn-sm" type="submit">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="rupia-empty-state">
                                    <i class="bi bi-folder-plus"></i>
                                    <div class="fw-semibold mb-1" style="color: var(--rupia-navy);">Belum ada kategori</div>
                                    <div class="small">Tambahkan kategori pemasukan atau pengeluaran pertama kamu lewat form di samping.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection