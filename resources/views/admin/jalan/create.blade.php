@extends('layouts.app')

@section('title', 'Tambah Data Jalan')
@section('page-title', 'Tambah Data Jalan')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jalan.index') }}">Data Jalan</a></li>
        <li class="breadcrumb-item active">Tambah Jalan</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Tambah Data Jalan Baru</h4>
        <p class="text-muted mb-0">Masukkan informasi lengkap ruas jalan</p>
    </div>
    <a href="{{ route('jalan.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Main Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Form Tambah Jalan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('jalan.store') }}" method="POST" id="jalanForm">
                    @csrf
                    
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
                                       value="{{ old('kode_jalan') }}"
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
                                       value="{{ old('nama_jalan') }}"
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
                                    <option value="Arteri" {{ old('kelas_jalan') == 'Arteri' ? 'selected' : '' }}>
                                        Arteri
                                    </option>
                                    <option value="Kolektor" {{ old('kelas_jalan') == 'Kolektor' ? 'selected' : '' }}>
                                        Kolektor
                                    </option>
                                    <option value="Lokal" {{ old('kelas_jalan') == 'Lokal' ? 'selected' : '' }}>
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
                                       value="{{ old('panjang_km') }}"
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
                                   value="{{ old('lokasi') }}"
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
                                      placeholder="Informasi tambahan tentang jalan (opsional)">{{ old('keterangan') }}</textarea>
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
                        <button type="reset" class="btn btn-outline-warning">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Help Card -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Panduan Pengisian</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Kode Jalan</h6>
                    <p class="small text-muted mb-2">
                        Kode unik untuk setiap jalan. Gunakan format yang konsisten.
                    </p>
                    <div class="alert alert-light py-2">
                        <small><strong>Contoh:</strong> JL001, JL002, JL003</small>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Kelas Jalan</h6>
                    <ul class="small text-muted mb-0">
                        <li><strong>Arteri:</strong> Jalan utama penghubung wilayah</li>
                        <li><strong>Kolektor:</strong> Jalan penghubung antar kecamatan</li>
                        <li><strong>Lokal:</strong> Jalan dalam kawasan permukiman</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Tips</h6>
                    <ul class="small text-muted">
                        <li>Pastikan semua field wajib (*) terisi</li>
                        <li>Panjang jalan dalam satuan kilometer</li>
                        <li>Lokasi sebaiknya lengkap dengan kecamatan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-eye"></i> Preview Data</h6>
            </div>
            <div class="card-body" id="preview">
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Preview akan muncul saat Anda mengisi form
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jalanForm');
    const preview = document.getElementById('preview');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        submitBtn.disabled = true;
    });
    
    // Live preview
    const inputs = ['kode_jalan', 'nama_jalan', 'kelas_jalan', 'panjang_km', 'lokasi'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        }
    });
    
    function updatePreview() {
        const kode = document.getElementById('kode_jalan').value;
        const nama = document.getElementById('nama_jalan').value;
        const kelas = document.getElementById('kelas_jalan').value;
        const panjang = document.getElementById('panjang_km').value;
        const lokasi = document.getElementById('lokasi').value;
        
        if (!kode && !nama && !kelas && !panjang && !lokasi) {
            preview.innerHTML = `
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Preview akan muncul saat Anda mengisi form
                </p>
            `;
            return;
        }
        
        let kelasColor = 'secondary';
        if (kelas === 'Arteri') kelasColor = 'danger';
        else if (kelas === 'Kolektor') kelasColor = 'warning';
        else if (kelas === 'Lokal') kelasColor = 'success';
        
        preview.innerHTML = `
            <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0">${nama || 'Nama Jalan'}</h6>
                    <span class="badge bg-${kelasColor}">${kelas || 'Kelas'}</span>
                </div>
                <p class="small text-muted mb-1">
                    <i class="bi bi-hash"></i> ${kode || 'Kode'}
                </p>
                <p class="small text-muted mb-1">
                    <i class="bi bi-rulers"></i> ${panjang || '0'} km
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-geo-alt"></i> ${lokasi || 'Lokasi'}
                </p>
            </div>
        `;
    }
    
    // Auto-generate kode jalan suggestion
    document.getElementById('nama_jalan').addEventListener('blur', function() {
        const kodeInput = document.getElementById('kode_jalan');
        if (!kodeInput.value && this.value) {
            // Simple auto-generation logic
            const words = this.value.split(' ');
            let suggestion = 'JL';
            words.forEach((word, index) => {
                if (index < 2 && word.length > 0) {
                    suggestion += word.charAt(0).toUpperCase();
                }
            });
            suggestion += String(Date.now()).slice(-3); // Add timestamp suffix
            kodeInput.value = suggestion;
            updatePreview();
        }
    });
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

.alert-light {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}

#preview .border {
    background-color: #f8f9fa;
}

.btn-group .btn {
    min-width: 100px;
}

@media (max-width: 768px) {
    .col-lg-4 .card {
        margin-top: 1rem;
    }
}
</style>
@endpush