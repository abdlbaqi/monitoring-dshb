@extends('layouts.app')

@section('title', 'Data Rambu Lalu Lintas')
@section('page-title', 'Data Rambu Lalu Lintas')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Rambu Lalu Lintas</h4>
        <p class="text-muted mb-0">Kelola data rambu lalu lintas di seluruh ruas jalan</p>
    </div>
    <div>
        @can('admin-only')
            <a href="{{ route('rambu.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Rambu
            </a>
        @endcan
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="bi bi-sign-stop fs-2 mb-2"></i>
                <h5>Total Rambu</h5>
                <h3>{{ $rambus->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle fs-2 mb-2"></i>
                <h5>Peringatan</h5>
                <h3>{{ $rambus->where('jenis_rambu', 'Peringatan')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="bi bi-slash-circle fs-2 mb-2"></i>
                <h5>Larangan</h5>
                <h3>{{ $rambus->where('jenis_rambu', 'Larangan')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="bi bi-arrow-right-circle fs-2 mb-2"></i>
                <h5>Petunjuk</h5>
                <h3>{{ $rambus->where('jenis_rambu', 'Petunjuk')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('rambu.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari nama atau kode rambu..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="jalan_id">
                        <option value="">Semua Jalan</option>
                        @foreach($jalans as $jalan)
                            <option value="{{ $jalan->id }}" {{ request('jalan_id') == $jalan->id ? 'selected' : '' }}>
                                {{ $jalan->nama_jalan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="jenis_rambu">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisRambu as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_rambu') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('rambu.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-table"></i> Tabel Data Rambu</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Kode & Nama</th>
                        <th width="10%">Jenis</th>
                        <th width="15%">Lokasi Jalan</th>
                        <th width="10%">Posisi</th>
                        <th width="15%">Jumlah</th>
                        <th width="10%">Kondisi</th>
                        <th width="10%">Kinerja</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rambus as $index => $rambu)
                        <tr>
                            <td>{{ $rambus->firstItem() + $index }}</td>
                            <td>
                                <div>
                                    <span class="badge bg-secondary mb-1">{{ $rambu->kode_rambu }}</span>
                                    <br>
                                    <strong class="small">{{ $rambu->nama_rambu }}</strong>
                                </div>
                            </td>
                            <td>
                                @php
                                    $jenisColor = match($rambu->jenis_rambu) {
                                        'Peringatan' => 'bg-warning text-dark',
                                        'Larangan' => 'bg-danger',
                                        'Perintah' => 'bg-success',
                                        'Petunjuk' => 'bg-info',
                                        default => 'bg-secondary'
                                    }
                                @endphp
                                <span class="badge {{ $jenisColor }}">{{ $rambu->jenis_rambu }}</span>
                            </td>
                            <td>
                                <strong>{{ $rambu->jalan->nama_jalan }}</strong>
                                <br>
                                <small class="text-muted">{{ $rambu->jalan->kode_jalan }}</small>
                            </td>
                            <td>
                                @if($rambu->km_posisi)
                                    <span class="badge bg-light text-dark">
                                        KM {{ number_format($rambu->km_posisi, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div class="d-flex justify-content-between">
                                        <span>Seharusnya:</span>
                                        <strong>{{ $rambu->jumlah_seharusnya }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Terpasang:</span>
                                        <strong class="text-primary">{{ $rambu->jumlah_terpasang }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $kondisiColor = match($rambu->kondisi) {
                                        'baik' => 'bg-success',
                                        'rusak_ringan' => 'bg-warning text-dark',
                                        'rusak_berat' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    $kondisiText = match($rambu->kondisi) {
                                        'baik' => 'Baik',
                                        'rusak_ringan' => 'Rusak Ringan',
                                        'rusak_berat' => 'Rusak Berat',
                                        default => 'Unknown'
                                    }
                                @endphp
                                <span class="badge {{ $kondisiColor }}">{{ $kondisiText }}</span>
                            </td>
                            <td>
                                @php
                                    $persentase = $rambu->jumlah_seharusnya > 0 
                                        ? round(($rambu->jumlah_terpasang / $rambu->jumlah_seharusnya) * 100, 1) 
                                        : 0;
                                    $kinerjaBadge = $persentase >= 90 ? 'bg-success' : 
                                                   ($persentase >= 70 ? 'bg-warning text-dark' : 'bg-danger');
                                @endphp
                                <div class="text-center">
                                    <span class="badge {{ $kinerjaBadge }}">{{ $persentase }}%</span>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar {{ str_replace('bg-', 'bg-', $kinerjaBadge) }}" 
                                             style="width: {{ $persentase }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('rambu.show', $rambu) }}" 
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('admin-only')
                                        <a href="{{ route('rambu.edit', $rambu) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rambu.destroy', $rambu) }}" method="POST" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Yakin ingin menghapus data rambu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-sign-stop fs-1 text-muted mb-2"></i>
                                    <h5 class="text-muted">Tidak ada data rambu</h5>
                                    <p class="text-muted">Silakan tambah data rambu baru</p>
                                    @can('admin-only')
                                        <a href="{{ route('rambu.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Tambah Rambu
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($rambus->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $rambus->firstItem() }} sampai {{ $rambus->lastItem() }} 
                    dari {{ $rambus->total() }} data
                </div>
                <div>
                    {{ $rambus->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Ringkasan Kinerja</h6>
            </div>
            <div class="card-body">
                @php
                    $totalSeharusnya = $rambus->sum('jumlah_seharusnya');
                    $totalTerpasang = $rambus->sum('jumlah_terpasang');
                    $overallPerformance = $totalSeharusnya > 0 ? round(($totalTerpasang / $totalSeharusnya) * 100, 1) : 0;
                @endphp
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-muted">{{ $totalSeharusnya }}</h4>
                        <small>Seharusnya</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-primary">{{ $totalTerpasang }}</h4>
                        <small>Terpasang</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success">{{ $overallPerformance }}%</h4>
                        <small>Kinerja</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-tools"></i> Kondisi Rambu</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-success">{{ $rambus->where('kondisi', 'baik')->count() }}</h4>
                        <small>Baik</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning">{{ $rambus->where('kondisi', 'rusak_ringan')->count() }}</h4>
                        <small>Rusak Ringan</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger">{{ $rambus->where('kondisi', 'rusak_berat')->count() }}</h4>
                        <small>Rusak Berat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Actions -->
<div class="card mt-4">
    <div class="card-body">
        <h6 class="card-title">Aksi Tambahan</h6>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>
            <button type="button" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>
            <button type="button" class="btn btn-outline-primary">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.progress {
    height: 4px;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transition: box-shadow 0.15s ease-in-out;
}

.table-responsive {
    border-radius: 0.375rem;
}
</style>
@endpush