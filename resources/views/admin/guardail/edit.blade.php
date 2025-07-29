@extends('layouts.app')

@section('page-title', 'Edit Data Guardrail')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Edit Data Guardrail</h3>
                <div class="card-tools">
                    <a href="{{ route('guardrail.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            
            <form action="{{ route('guardrail.update', $guardrail) }}" method="POST">
                @csrf
                @method('PUT')
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
                            <div class="form-group mb-3">
                                <label for="jalan_id">Jalan <span class="text-danger">*</span></label>
                                <select name="jalan_id" id="jalan_id" 
                                        class="form-control @error('jalan_id') is-invalid @enderror" required>
                                    <option value="">Pilih Jalan</option>
                                    @foreach($jalans as $jalan)
                                        <option value="{{ $jalan->id }}" 
                                            {{ (old('jalan_id') ?? $guardrail->jalan_id) == $jalan->id ? 'selected' : '' }}>
                                            {{ $jalan->nama_jalan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jalan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Guardrail -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tipe_guardrail">Tipe Guardrail <span class="text-danger">*</span></label>
                                <select name="tipe_guardrail" id="tipe_guardrail" 
                                        class="form-control @error('tipe_guardrail') is-invalid @enderror" required>
                                    <option value="">Pilih Tipe</option>
                                    @foreach($tipeGuardrail as $tipe)
                                        <option value="{{ $tipe }}" 
                                            {{ (old('tipe_guardrail') ?? $guardrail->tipe_guardrail) == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipe_guardrail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kondisi -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kondisi">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" id="kondisi" 
                                        class="form-control @error('kondisi') is-invalid @enderror" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" 
                                        {{ (old('kondisi') ?? $guardrail->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak_ringan" 
                                        {{ (old('kondisi') ?? $guardrail->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" 
                                        {{ (old('kondisi') ?? $guardrail->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Pemasangan -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal_pemasangan">Tanggal Pemasangan</label>
                                <input type="date" name="tanggal_pemasangan" id="tanggal_pemasangan" 
                                       class="form-control @error('tanggal_pemasangan') is-invalid @enderror"
                                       value="{{ old('tanggal_pemasangan') ?? ($guardrail->tanggal_pemasangan ? $guardrail->tanggal_pemasangan->format('Y-m-d') : '') }}">
                                @error('tanggal_pemasangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Panjang Seharusnya -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="panjang_seharusnya">Panjang Seharusnya (m) <span class="text-danger">*</span></label>
                                <input type="number" name="panjang_seharusnya" id="panjang_seharusnya" 
                                       class="form-control @error('panjang_seharusnya') is-invalid @enderror"
                                       value="{{ old('panjang_seharusnya') ?? $guardrail->panjang_seharusnya }}" 
                                       step="0.1" min="0" placeholder="0.0" required>
                                @error('panjang_seharusnya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Panjang Terpasang -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="panjang_terpasang">Panjang Terpasang (m) <span class="text-danger">*</span></label>
                                <input type="number" name="panjang_terpasang" id="panjang_terpasang" 
                                       class="form-control @error('panjang_terpasang') is-invalid @enderror"
                                       value="{{ old('panjang_terpasang') ?? $guardrail->panjang_terpasang }}" 
                                       step="0.1" min="0" placeholder="0.0" required>
                                @error('panjang_terpasang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- KM Awal -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="km_awal">KM Awal <span class="text-danger">*</span></label>
                                <input type="number" name="km_awal" id="km_awal" 
                                       class="form-control @error('km_awal') is-invalid @enderror"
                                       value="{{ old('km_awal') ?? $guardrail->km_awal }}" 
                                       step="0.001" placeholder="0.000" required>
                                @error('km_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- KM Akhir -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="km_akhir">KM Akhir <span class="text-danger">*</span></label>
                                <input type="number" name="km_akhir" id="km_akhir" 
                                       class="form-control @error('km_akhir') is-invalid @enderror"
                                       value="{{ old('km_akhir') ?? $guardrail->km_akhir }}" 
                                       step="0.001" placeholder="0.000" required>
                                @error('km_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror"
                                          rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') ?? $guardrail->keterangan }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Info Update -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Info:</strong> Data terakhir diperbarui pada 
                        {{ $guardrail->updated_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('guardrail.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                    <a href="{{ route('guardrail.show', $guardrail) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto calculate km_akhir when km_awal and panjang_terpasang change
    const kmAwal = document.getElementById('km_awal');
    const panjangTerpasang = document.getElementById('panjang_terpasang');
    const kmAkhir = document.getElementById('km_akhir');
    
    function calculateKmAkhir() {
        const awal = parseFloat(kmAwal.value) || 0;
        const panjang = parseFloat(panjangTerpasang.value) || 0;
        const akhir = awal + (panjang / 1000); // Convert meter to km
        kmAkhir.value = akhir.toFixed(3);
    }
    
    kmAwal.addEventListener('input', calculateKmAkhir);
    panjangTerpasang.addEventListener('input', calculateKmAkhir);
});
</script>
@endpush
@endsection