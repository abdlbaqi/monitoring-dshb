@extends('layouts.app')

@section('page-title', 'Tambah Data Marka Jalan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Tambah Data Marka Jalan</h3>
                <div class="card-tools">
                    <a href="{{ route('marka.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
                
                <form action="{{ route('marka.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Jalan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jalan_id">Jalan <span class="text-danger">*</span></label>
                                    <select name="jalan_id" id="jalan_id" 
                                            class="form-control @error('jalan_id') is-invalid @enderror" required>
                                        <option value="">Pilih Jalan</option>
                                        @foreach($jalans as $jalan)
                                            <option value="{{ $jalan->id }}" 
                                                {{ old('jalan_id') == $jalan->id ? 'selected' : '' }}>
                                                {{ $jalan->nama_jalan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jalan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Marka -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_marka">Jenis Marka <span class="text-danger">*</span></label>
                                    <input type="text" name="jenis_marka" id="jenis_marka" 
                                           class="form-control @error('jenis_marka') is-invalid @enderror"
                                           value="{{ old('jenis_marka') }}" 
                                           placeholder="Contoh: Garis Tengah, Garis Tepi, dll" required>
                                    @error('jenis_marka')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Warna -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="warna">Warna <span class="text-danger">*</span></label>
                                    <select name="warna" id="warna" 
                                            class="form-control @error('warna') is-invalid @enderror" required>
                                        <option value="">Pilih Warna</option>
                                        <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : '' }}>Putih</option>
                                        <option value="Kuning" {{ old('warna') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                                    </select>
                                    @error('warna')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kondisi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kondisi">Kondisi <span class="text-danger">*</span></label>
                                    <select name="kondisi" id="kondisi" 
                                            class="form-control @error('kondisi') is-invalid @enderror" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="pudar" {{ old('kondisi') == 'pudar' ? 'selected' : '' }}>Pudar</option>
                                        <option value="hilang" {{ old('kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                    @error('kondisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Panjang Seharusnya -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="panjang_seharusnya">Panjang Seharusnya (m) <span class="text-danger">*</span></label>
                                    <input type="number" name="panjang_seharusnya" id="panjang_seharusnya" 
                                           class="form-control @error('panjang_seharusnya') is-invalid @enderror"
                                           value="{{ old('panjang_seharusnya') }}" 
                                           step="0.1" min="0" placeholder="0.0" required>
                                    @error('panjang_seharusnya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Panjang Terpasang -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="panjang_terpasang">Panjang Terpasang (m) <span class="text-danger">*</span></label>
                                    <input type="number" name="panjang_terpasang" id="panjang_terpasang" 
                                           class="form-control @error('panjang_terpasang') is-invalid @enderror"
                                           value="{{ old('panjang_terpasang') }}" 
                                           step="0.1" min="0" placeholder="0.0" required>
                                    @error('panjang_terpasang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- KM Awal -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="km_awal">KM Awal <span class="text-danger">*</span></label>
                                    <input type="number" name="km_awal" id="km_awal" 
                                           class="form-control @error('km_awal') is-invalid @enderror"
                                           value="{{ old('km_awal') }}" 
                                           step="0.001" placeholder="0.000" required>
                                    @error('km_awal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- KM Akhir -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="km_akhir">KM Akhir <span class="text-danger">*</span></label>
                                    <input type="number" name="km_akhir" id="km_akhir" 
                                           class="form-control @error('km_akhir') is-invalid @enderror"
                                           value="{{ old('km_akhir') }}" 
                                           step="0.001" placeholder="0.000" required>
                                    @error('km_akhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Pemasangan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_pemasangan">Tanggal Pemasangan</label>
                                    <input type="date" name="tanggal_pemasangan" id="tanggal_pemasangan" 
                                           class="form-control @error('tanggal_pemasangan') is-invalid @enderror"
                                           value="{{ old('tanggal_pemasangan') }}">
                                    @error('tanggal_pemasangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" 
                                              class="form-control @error('keterangan') is-invalid @enderror"
                                              rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('marka.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    // Auto calculate km_akhir when km_awal and panjang_terpasang change
    $('#km_awal, #panjang_terpasang').on('input', function() {
        var kmAwal = parseFloat($('#km_awal').val()) || 0;
        var panjangTerpasang = parseFloat($('#panjang_terpasang').val()) || 0;
        var kmAkhir = kmAwal + (panjangTerpasang / 1000); // Convert meter to km
        $('#km_akhir').val(kmAkhir.toFixed(3));
    });
});
</script>
@endsection
@endsection