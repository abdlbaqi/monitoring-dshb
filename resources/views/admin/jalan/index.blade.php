@extends('layouts.app')

@section('title', 'Data Jalan')
@section('page-title', 'Data Jalan')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Ruas Jalan</h4>
        <p class="text-muted mb-0">Kelola data ruas jalan dan infrastruktur terkait</p>
    </div>
    <div>
        <a href="{{ route('jalan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jalan
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="bi bi-map fs-2 mb-2"></i>
                <h5>Total Jalan</h5>
                <h3>{{ $jalans->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="bi bi-diagram-3 fs-2 mb-2"></i>
                <h5>Arteri</h5>
                <h3>{{ $jalans->where('kelas_jalan', 'Arteri')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="bi bi-arrow-left-right fs-2 mb-2"></i>
                <h5>Kolektor</h5>
                <h3>{{ $jalans->where('kelas_jalan', 'Kolektor')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="bi bi-house-door fs-2 mb-2"></i>
                <h5>Lokal</h5>
                <h3>{{ $jalans->where('kelas_jalan', 'Lokal')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('jalan.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari nama jalan atau kode..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="kelas">
                        <option value="">Semua Kelas Jalan</option>
                        <option value="Arteri" {{ request('kelas') == 'Arteri' ? 'selected' : '' }}>Arteri</option>
                        <option value="Kolektor" {{ request('kelas') == 'Kolektor' ? 'selected' : '' }}>Kolektor</option>
                        <option value="Lokal" {{ request('kelas') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="lokasi" 
                           placeholder="Filter by lokasi..." 
                           value="{{ request('lokasi') }}">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary">
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
        <h5 class="mb-0"><i class="bi bi-table"></i> Tabel Data Jalan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Kode Jalan</th>
                        <th width="20%">Nama Jalan</th>
                        <th width="10%">Kelas</th>
                        <th width="10%">Panjang (km)</th>
                        <th width="15%">Lokasi</th>
                        <th width="15%">Infrastruktur</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jalans as $index => $jalan)
                        <tr>
                            <td>{{ $jalans->firstItem() + $index }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $jalan->kode_jalan }}</span>
                            </td>
                            <td>
                                <strong>{{ $jalan->nama_jalan }}</strong>
                                @if($jalan->keterangan)
                                    <br><small class="text-muted">{{ Str::limit($jalan->keterangan, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($jalan->kelas_jalan) {
                                        'Arteri' => 'bg-danger',
                                        'Kolektor' => 'bg-warning',
                                        'Lokal' => 'bg-success',
                                        default => 'bg-secondary'
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $jalan->kelas_jalan }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($jalan->panjang_km, 2) }}</strong> km
                            </td>
                            <td>{{ $jalan->lokasi }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-info" title="Rambu">
                                        <i class="bi bi-sign-stop"></i> {{ $jalan->rambu_count }}
                                    </span>
                                    <span class="badge bg-success" title="Marka">
                                        <i class="bi bi-dash-lg"></i> {{ $jalan->marka_count }}
                                    </span>
                                    <span class="badge bg-warning text-dark" title="Guardrail">
                                        <i class="bi bi-shield"></i> {{ $jalan->guardrail_count }}
                                    </span>
                                    <span class="badge bg-danger" title="APILL">
                                        <i class="bi bi-traffic-light"></i> {{ $jalan->apill_count }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('jalan.show', $jalan) }}" 
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('jalan.edit', $jalan) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('jalan.destroy', $jalan) }}" method="POST" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus data jalan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                                    <h5 class="text-muted">Tidak ada data jalan</h5>
                                    <p class="text-muted">Silakan tambah data jalan baru</p>
                                    <a href="{{ route('jalan.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Tambah Jalan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($jalans->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $jalans->firstItem() }} sampai {{ $jalans->lastItem() }} 
                    dari {{ $jalans->total() }} data
                </div>
                <div>
                    {{ $jalans->links() }}
                </div>
            </div>
        </div>
    @endif
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

.card {
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endpush