@extends('layouts.app')

@section('title', 'Edit Data Jalan')
@section('page-title', 'Edit Data Jalan')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jalan.index') }}">Data Jalan</a></li>
        <li class="breadcrumb-item active">Edit: {{ $jalan->nama_jalan }}</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Edit Data Jalan</h4>
        <p class="text-muted mb-0">Perbarui informasi ruas jalan: <strong>{{ $jalan->nama_jalan }}</strong></p>
    </div>
    <div class="btn-group">
        <a href="{{ route('jalan.show', $jalan) }}" class="btn btn-outline-info">
            <i class="bi bi-eye"></i> Detail
        </a>
        <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Main Form -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Form Edit Jalan</h5>
                    <span class="badge bg-dark">{{ $jalan->kode_jalan }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('jalan.update', $jalan) }}" method="POST" id="jalanEditForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Kode Jalan -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_jalan" class="form-label">
                                Kode Jalan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="text" 
                                       class="form-control @error('kode_jalan') is-invalid @enderror" 
                                       id="kode_jalan" 
                                       name="kode_jalan" 
                                       value="{{ old('kode_jalan', $jalan->kode_jalan) }}"
                                       placeholder="Contoh: JL001"
                                       required>
                            </div>
                            @error('kode_jalan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Format: huruf dan angka, contoh JL001, JL002, dst.
                            </div>
                        </div>

                        <!-- Nama Jalan -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_jalan" class="form-label">
                                Nama Jalan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-signpost"></i></span>
                                <input type="text" 
                                       class="form-control @error('nama_jalan') is-invalid @enderror" 
                                       id="nama_jalan" 
                                       name="nama_jalan" 
                                       value="{{ old('nama_jalan', $jalan->nama_jalan) }}"
                                       placeholder="Contoh: Jl. Jenderal Sudirman"
                                       required>
                            </div>
                            @error('nama_jalan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kelas Jalan -->
                        <div class="col-md-6 mb-3">
                            <label for="kelas_jalan" class="form-label">
                                Kelas Jalan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                <select class="form-select @error('kelas_jalan') is-invalid @enderror" 
                                        id="kelas_jalan" 
                                        name="kelas_jalan" 
                                        required>
                                    <option value="">Pilih Kelas Jalan</option>
                                    <option value="Arteri" {{ old('kelas_jalan', $jalan->kelas_jalan) == 'Arteri' ? 'selected' : '' }}>
                                        Arteri
                                    </option>
                                    <option value="Kolektor" {{ old('kelas_jalan', $jalan->kelas_jalan) == 'Kolektor' ? 'selected' : '' }}>
                                        Kolektor
                                    </option>
                                    <option value="Lokal" {{ old('kelas_jalan', $jalan->kelas_jalan) == 'Lokal' ? 'selected' : '' }}>
                                        Lokal
                                    </option>
                                </select>
                            </div>
                            @error('kelas_jalan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Panjang -->
                        <div class="col-md-6 mb-3">
                            <label for="panjang_km" class="form-label">
                                Panjang (km) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-rulers"></i></span>
                                <input type="number" 
                                       class="form-control @error('panjang_km') is-invalid @enderror" 
                                       id="panjang_km" 
                                       name="panjang_km" 
                                       value="{{ old('panjang_km', $jalan->panjang_km) }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required>
                                <span class="input-group-text">km</span>
                            </div>
                            @error('panjang_km')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">
                            Lokasi <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" 
                                   class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" 
                                   name="lokasi" 
                                   value="{{ old('lokasi', $jalan->lokasi) }}"
                                   placeholder="Contoh: Kecamatan Tanjung Karang Pusat, Bandar Lampung"
                                   required>
                        </div>
                        @error('lokasi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3"
                                      placeholder="Informasi tambahan tentang jalan (opsional)">{{ old('keterangan', $jalan->keterangan) }}</textarea>
                        </div>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="resetToOriginal()">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-warning" id="updateBtn">
                            <i class="bi bi-check-circle"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change History Card -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-clock-history"></i> Informasi Perubahan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Dibuat:</small>
                        <p class="mb-2">{{ $jalan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Terakhir diupdate:</small>
                        <p class="mb-0">{{ $jalan->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Current Data Preview -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-eye"></i> Data Saat Ini</h6>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 bg-light">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0">{{ $jalan->nama_jalan }}</h6>
                        @php
                            $badgeClass = match($jalan->kelas_jalan) {
                                'Arteri' => 'bg-danger',
                                'Kolektor' => 'bg-warning',
                                'Lokal' => 'bg-success',
                                default => 'bg-secondary'
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $jalan->kelas_jalan }}</span>
                    </div>
                    <p class="small text-muted mb-1">
                        <i class="bi bi-hash"></i> {{ $jalan->kode_jalan }}
                    </p>
                    <p class="small text-muted mb-1">
                        <i class="bi bi-rulers"></i> {{ number_format($jalan->panjang_km, 2) }} km
                    </p>
                    <p class="small text-muted mb-0">
                        <i class="bi bi-geo-alt"></i> {{ $jalan->lokasi }}
                    </p>
                    @if($jalan->keterangan)
                        <hr class="my-2">
                        <p class="small text-muted mb-0">
                            <i class="bi bi-card-text"></i> {{ $jalan->keterangan }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-eye"></i> Preview Perubahan</h6>
            </div>
            <div class="card-body" id="livePreview">
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Belum ada perubahan
                </p>
            </div>
        </div>

        <!-- Infrastructure Summary -->
        <div class="card mt-3">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="bi bi-gear"></i> Infrastruktur Terkait</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-2">
                        <div class="border rounded p-2">
                            <i class="bi bi-sign-stop text-info fs-4"></i>
                            <p class="small mb-0 mt-1">Rambu</p>
                            <strong>{{ $jalan->rambu->count() }}</strong>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="border rounded p-2">
                            <i class="bi bi-dash-lg text-success fs-4"></i>
                            <p class="small mb-0 mt-1">Marka</p>
                            <strong>{{ $jalan->marka->count() }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <i class="bi bi-shield text-warning fs-4"></i>
                            <p class="small mb-0 mt-1">Guardrail</p>
                            <strong>{{ $jalan->guardrail->count() }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <i class="bi bi-traffic-light text-danger fs-4"></i>
                            <p class="small mb-0 mt-1">APILL</p>
                            <strong>{{ $jalan->apill->count() }}</strong>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('jalan.show', $jalan) }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-eye"></i> Lihat Detail Infrastruktur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jalanEditForm');
    const livePreview = document.getElementById('livePreview');
    const updateBtn = document.getElementById('updateBtn');
    
    // Store original values
    const originalValues = {
        kode_jalan: '{{ $jalan->kode_jalan }}',
        nama_jalan: '{{ $jalan->nama_jalan }}',
        kelas_jalan: '{{ $jalan->kelas_jalan }}',
        panjang_km: '{{ $jalan->panjang_km }}',
        lokasi: '{{ $jalan->lokasi }}',
        keterangan: '{{ $jalan->keterangan }}'
    };
    
    // Form submission
    form.addEventListener('submit', function(e) {
        updateBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengupdate...';
        updateBtn.disabled = true;
    });
    
    // Reset to original function
    window.resetToOriginal = function() {
        Object.keys(originalValues).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.value = originalValues[key];
            }
        });
        updateLivePreview();
    };
    
    // Live preview
    const inputs = ['kode_jalan', 'nama_jalan', 'kelas_jalan', 'panjang_km', 'lokasi', 'keterangan'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', updateLivePreview);
            input.addEventListener('change', updateLivePreview);
        }
    });
    
    function updateLivePreview() {
        const currentValues = {
            kode_jalan: document.getElementById('kode_jalan').value,
            nama_jalan: document.getElementById('nama_jalan').value,
            kelas_jalan: document.getElementById('kelas_jalan').value,
            panjang_km: document.getElementById('panjang_km').value,
            lokasi: document.getElementById('lokasi').value,
            keterangan: document.getElementById('keterangan').value
        };
        
        // Check for changes
        const changes = [];
        Object.keys(originalValues).forEach(key => {
            if (currentValues[key] !== originalValues[key]) {
                changes.push({
                    field: key,
                    from: originalValues[key],
                    to: currentValues[key]
                });
            }
        });
        
        if (changes.length === 0) {
            livePreview.innerHTML = `
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Belum ada perubahan
                </p>
            `;
            return;
        }
        
        // Show preview with changes
        let kelasColor = 'secondary';
        if (currentValues.kelas_jalan === 'Arteri') kelasColor = 'danger';
        else if (currentValues.kelas_jalan === 'Kolektor') kelasColor = 'warning';
        else if (currentValues.kelas_jalan === 'Lokal') kelasColor = 'success';
        
        let changesHtml = changes.map(change => {
            const fieldLabels = {
                'kode_jalan': 'Kode Jalan',
                'nama_jalan': 'Nama Jalan', 
                'kelas_jalan': 'Kelas Jalan',
                'panjang_km': 'Panjang',
                'lokasi': 'Lokasi',
                'keterangan': 'Keterangan'
            };
            
            return `
                <div class="small mb-1">
                    <strong>${fieldLabels[change.field]}:</strong><br>
                    <span class="text-muted">Dari: ${change.from || 'kosong'}</span><br>
                    <span class="text-primary">Ke: ${change.to || 'kosong'}</span>
                </div>
            `;
        }).join('<hr class="my-2">');
        
        livePreview.innerHTML = `
            <div class="border rounded p-3" style="background-color: #f0f8ff;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0 text-primary">${currentValues.nama_jalan || 'Nama Jalan'}</h6>
                    <span class="badge bg-${kelasColor}">${currentValues.kelas_jalan || 'Kelas'}</span>
                </div>
                <p class="small text-muted mb-1">
                    <i class="bi bi-hash"></i> ${currentValues.kode_jalan || 'Kode'}
                </p>
                <p class="small text-muted mb-1">
                    <i class="bi bi-rulers"></i> ${currentValues.panjang_km || '0'} km
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-geo-alt"></i> ${currentValues.lokasi || 'Lokasi'}
                </p>
                <hr>
                <div class="small">
                    <strong class="text-warning">Perubahan (${changes.length}):</strong>
                    <div class="mt-2">
                        ${changesHtml}
                    </div>
                </div>
            </div>
        `;
    }
    
    // Initial preview update
    updateLivePreview();
});
</script>
@endpush

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.card-header h5, .card-header h6 {
    font-weight: 600;
}

#livePreview .border {
    background-color: #f0f8ff;
    border-color: #b3d9ff !important;
}

.btn-group .btn {
    min-width: 100px;
}

.border.rounded.p-2 {
    background-color: #f8f9fa;
    transition: background-color 0.2s;
}

.border.rounded.p-2:hover {
    background-color: #e9ecef;
}

@media (max-width: 768px) {
    .col-lg-4 .card {
        margin-top: 1rem;
    }
}
</style>
@endpush