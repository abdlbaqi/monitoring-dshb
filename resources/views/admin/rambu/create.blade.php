@extends('layouts.app')

@section('title', 'Tambah Data Rambu')
@section('page-title', 'Tambah Data Rambu')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('rambu.index') }}">Data Rambu</a></li>
        <li class="breadcrumb-item active">Tambah Rambu</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Tambah Data Rambu Lalu Lintas</h4>
        <p class="text-muted mb-0">Masukkan informasi lengkap rambu lalu lintas</p>
    </div>
    <a href="{{ route('rambu.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Main Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Form Tambah Rambu</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rambu.store') }}" method="POST" id="rambuForm">
                    @csrf
                    
                    <!-- Jalan Selection -->
                    <div class="mb-4">
                        <label for="jalan_id" class="form-label">
                            Pilih Jalan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-map"></i></span>
                            <select class="form-select @error('jalan_id') is-invalid @enderror" 
                                    id="jalan_id" 
                                    name="jalan_id" 
                                    required>
                                <option value="">Pilih Jalan</option>
                                @foreach($jalans as $jalan)
                                    <option value="{{ $jalan->id }}" 
                                            {{ old('jalan_id') == $jalan->id ? 'selected' : '' }}
                                            data-panjang="{{ $jalan->panjang_km }}">
                                        {{ $jalan->nama_jalan }} ({{ $jalan->kode_jalan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('jalan_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Jenis Rambu -->
                        <div class="col-md-6 mb-3">
                            <label for="jenis_rambu" class="form-label">
                                Jenis Rambu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                <select class="form-select @error('jenis_rambu') is-invalid @enderror" 
                                        id="jenis_rambu" 
                                        name="jenis_rambu" 
                                        required>
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisRambu as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_rambu') == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('jenis_rambu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode Rambu -->
                        <div class="col-md-6 mb-3">
                            <label for="kode_rambu" class="form-label">
                                Kode Rambu <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="text" 
                                       class="form-control @error('kode_rambu') is-invalid @enderror" 
                                       id="kode_rambu" 
                                       name="kode_rambu" 
                                       value="{{ old('kode_rambu') }}"
                                       placeholder="Contoh: R001, P001, L001"
                                       required>
                            </div>
                            @error('kode_rambu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Rambu -->
                    <div class="mb-3">
                        <label for="nama_rambu" class="form-label">
                            Nama Rambu <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-signpost"></i></span>
                            <input type="text" 
                                   class="form-control @error('nama_rambu') is-invalid @enderror" 
                                   id="nama_rambu" 
                                   name="nama_rambu" 
                                   value="{{ old('nama_rambu') }}"
                                   placeholder="Contoh: Rambu Batas Kecepatan 60 km/jam"
                                   required>
                        </div>
                        @error('nama_rambu')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Jumlah Seharusnya -->
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_seharusnya" class="form-label">
                                Jumlah Seharusnya <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calculator"></i></span>
                                <input type="number" 
                                       class="form-control @error('jumlah_seharusnya') is-invalid @enderror" 
                                       id="jumlah_seharusnya" 
                                       name="jumlah_seharusnya" 
                                       value="{{ old('jumlah_seharusnya', 1) }}"
                                       min="0"
                                       required>
                                <span class="input-group-text">unit</span>
                            </div>
                            @error('jumlah_seharusnya')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Terpasang -->
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_terpasang" class="form-label">
                                Jumlah Terpasang <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                <input type="number" 
                                       class="form-control @error('jumlah_terpasang') is-invalid @enderror" 
                                       id="jumlah_terpasang" 
                                       name="jumlah_terpasang" 
                                       value="{{ old('jumlah_terpasang', 0) }}"
                                       min="0"
                                       required>
                                <span class="input-group-text">unit</span>
                            </div>
                            @error('jumlah_terpasang')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Posisi KM -->
                        <div class="col-md-6 mb-3">
                            <label for="km_posisi" class="form-label">Posisi KM</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="number" 
                                       class="form-control @error('km_posisi') is-invalid @enderror" 
                                       id="km_posisi" 
                                       name="km_posisi" 
                                       value="{{ old('km_posisi') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00">
                                <span class="input-group-text">km</span>
                            </div>
                            @error('km_posisi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="kmHelp">
                                Posisi rambu dalam kilometer dari titik awal jalan
                            </div>
                        </div>

                        <!-- Kondisi -->
                        <div class="col-md-6 mb-3">
                            <label for="kondisi" class="form-label">
                                Kondisi <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-gear"></i></span>
                                <select class="form-select @error('kondisi') is-invalid @enderror" 
                                        id="kondisi" 
                                        name="kondisi" 
                                        required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>
                                        Baik
                                    </option>
                                    <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>
                                        Rusak Ringan
                                    </option>
                                    <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>
                                        Rusak Berat
                                    </option>
                                </select>
                            </div>
                            @error('kondisi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Pemasangan -->
                    <div class="mb-3">
                        <label for="tanggal_pemasangan" class="form-label">Tanggal Pemasangan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" 
                                   class="form-control @error('tanggal_pemasangan') is-invalid @enderror" 
                                   id="tanggal_pemasangan" 
                                   name="tanggal_pemasangan" 
                                   value="{{ old('tanggal_pemasangan') }}">
                        </div>
                        @error('tanggal_pemasangan')
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
                                      placeholder="Informasi tambahan tentang rambu (opsional)">{{ old('keterangan') }}</textarea>
                        </div>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rambu.index') }}" class="btn btn-outline-secondary">
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
                    <h6 class="text-primary">Jenis Rambu</h6>
                    <ul class="small text-muted mb-0">
                        <li><strong>Peringatan:</strong> Memberi peringatan bahaya</li>
                        <li><strong>Larangan:</strong> Melarang tindakan tertentu</li>
                        <li><strong>Perintah:</strong> Memerintahkan tindakan</li>
                        <li><strong>Petunjuk:</strong> Memberi petunjuk arah/info</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Kode Rambu</h6>
                    <div class="alert alert-light py-2">
                        <small>
                            <strong>Format:</strong><br>
                            R001 - Rambu Peringatan<br>
                            L001 - Rambu Larangan<br>
                            P001 - Rambu Perintah<br>
                            T001 - Rambu Petunjuk
                        </small>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Kondisi</h6>
                    <ul class="small text-muted">
                        <li><strong>Baik:</strong> Tidak ada kerusakan</li>
                        <li><strong>Rusak Ringan:</strong> Ada kerusakan kecil</li>
                        <li><strong>Rusak Berat:</strong> Perlu penggantian</li>
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

        <!-- Performance Indicator -->
        <div class="card mt-3">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-speedometer2"></i> Indikator Kinerja</h6>
            </div>
            <div class="card-body text-center" id="performanceIndicator">
                <div class="progress mb-2" style="height: 20px;">
                    <div class="progress-bar" id="performanceBar" style="width: 0%">0%</div>
                </div>
                <small class="text-muted">Persentase rambu terpasang</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('rambuForm');
    const preview = document.getElementById('preview');
    const submitBtn = document.getElementById('submitBtn');
    const performanceBar = document.getElementById('performanceBar');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        submitBtn.disabled = true;
    });
    
    // Live preview and performance calculation
    const inputs = ['jalan_id', 'jenis_rambu', 'kode_rambu', 'nama_rambu', 'jumlah_seharusnya', 'jumlah_terpasang', 'km_posisi', 'kondisi', 'tanggal_pemasangan'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        }
    });
    
    function updatePreview() {
        const jalanSelect = document.getElementById('jalan_id');
        const jalanText = jalanSelect.options[jalanSelect.selectedIndex]?.text || '';
        const jenisRambu = document.getElementById('jenis_rambu').value;
        const kodeRambu = document.getElementById('kode_rambu').value;
        const namaRambu = document.getElementById('nama_rambu').value;
        const jumlahSeharusnya = parseInt(document.getElementById('jumlah_seharusnya').value) || 0;
        const jumlahTerpasang = parseInt(document.getElementById('jumlah_terpasang').value) || 0;
        const kmPosisi = document.getElementById('km_posisi').value;
        const kondisi = document.getElementById('kondisi').value;
        const tanggalPemasangan = document.getElementById('tanggal_pemasangan').value;
        
        // Update performance indicator
        const performance = jumlahSeharusnya > 0 ? Math.round((jumlahTerpasang / jumlahSeharusnya) * 100) : 0;
        performanceBar.style.width = performance + '%';
        performanceBar.textContent = performance + '%';
        
        // Color based on performance
        performanceBar.className = 'progress-bar';
        if (performance >= 90) {
            performanceBar.classList.add('bg-success');
        } else if (performance >= 70) {
            performanceBar.classList.add('bg-warning');
        } else {
            performanceBar.classList.add('bg-danger');
        }
        
        // Check if any field has value
        if (!jalanText && !jenisRambu && !kodeRambu && !namaRambu) {
            preview.innerHTML = `
                <p class="text-muted small">
                    <i class="bi bi-info-circle"></i> 
                    Preview akan muncul saat Anda mengisi form
                </p>
            `;
            return;
        }
        
        // Jenis rambu color
        let jenisColor = 'secondary';
        if (jenisRambu === 'Peringatan') jenisColor = 'warning';
        else if (jenisRambu === 'Larangan') jenisColor = 'danger';
        else if (jenisRambu === 'Perintah') jenisColor = 'success';
        else if (jenisRambu === 'Petunjuk') jenisColor = 'info';
        
        // Kondisi color
        let kondisiColor = 'secondary';
        let kondisiText = kondisi;
        if (kondisi === 'baik') {
            kondisiColor = 'success';
            kondisiText = 'Baik';
        } else if (kondisi === 'rusak_ringan') {
            kondisiColor = 'warning';
            kondisiText = 'Rusak Ringan';
        } else if (kondisi === 'rusak_berat') {
            kondisiColor = 'danger';
            kondisiText = 'Rusak Berat';
        }
        
        preview.innerHTML = `
            <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0">${namaRambu || 'Nama Rambu'}</h6>
                    <span class="badge bg-${jenisColor}">${jenisRambu || 'Jenis'}</span>
                </div>
                <p class="small text-muted mb-1">
                    <i class="bi bi-hash"></i> ${kodeRambu || 'Kode'}
                </p>
                <p class="small text-muted mb-1">
                    <i class="bi bi-map"></i> ${jalanText.split('(')[0] || 'Jalan'}
                </p>
                ${kmPosisi ? `<p class="small text-muted mb-1">
                    <i class="bi bi-geo-alt"></i> KM ${kmPosisi}
                </p>` : ''}
                <div class="row text-center mt-2">
                    <div class="col-4">
                        <small class="text-muted">Seharusnya</small>
                        <div class="fw-bold">${jumlahSeharusnya}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">Terpasang</small>
                        <div class="fw-bold text-primary">${jumlahTerpasang}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">Kinerja</small>
                        <div class="fw-bold text-${performance >= 90 ? 'success' : performance >= 70 ? 'warning' : 'danger'}">${performance}%</div>
                    </div>
                </div>
                ${kondisi ? `<div class="mt-2">
                    <span class="badge bg-${kondisiColor}">${kondisiText}</span>
                </div>` : ''}
                ${tanggalPemasangan ? `<p class="small text-muted mt-2 mb-0">
                    <i class="bi bi-calendar"></i> Dipasang: ${new Date(tanggalPemasangan).toLocaleDateString('id-ID')}
                </p>` : ''}
            </div>
        `;
    }
    
    // Auto-generate kode rambu based on jenis
    document.getElementById('jenis_rambu').addEventListener('change', function() {
        const kodeInput = document.getElementById('kode_rambu');
        if (!kodeInput.value && this.value) {
            let prefix = '';
            switch(this.value) {
                case 'Peringatan': prefix = 'R'; break;
                case 'Larangan': prefix = 'L'; break;
                case 'Perintah': prefix = 'P'; break;
                case 'Petunjuk': prefix = 'T'; break;
            }
            if (prefix) {
                const timestamp = String(Date.now()).slice(-3);
                kodeInput.value = prefix + '0' + timestamp;
                updatePreview();
            }
        }
    });
    
    // Validate KM position against selected road length
    document.getElementById('km_posisi').addEventListener('blur', function() {
        const jalanSelect = document.getElementById('jalan_id');
        const selectedOption = jalanSelect.options[jalanSelect.selectedIndex];
        
        if (selectedOption && selectedOption.dataset.panjang) {
            const roadLength = parseFloat(selectedOption.dataset.panjang);
            const kmPosition = parseFloat(this.value);
            
            if (kmPosition > roadLength) {
                alert(`Posisi KM (${kmPosition}) melebihi panjang jalan (${roadLength} km)`);
                this.focus();
            }
        }
    });
    
    // Auto-set jumlah terpasang when jumlah seharusnya changes
    document.getElementById('jumlah_seharusnya').addEventListener('change', function() {
        const terpasangInput = document.getElementById('jumlah_terpasang');
        if (terpasangInput.value == 0 || !terpasangInput.value) {
            // Don't auto-set, let user decide
        }
        updatePreview();
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

.progress {
    border-radius: 10px;
}

.progress-bar {
    transition: width 0.3s ease;
}

@media (max-width: 768px) {
    .col-lg-4 .card {
        margin-top: 1rem;
    }
}
</style>
@endpush