@extends('layouts.app')

@section('page-title', 'Data Guardrail')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Data Guardrail</h3>
                @can('admin-only')
                <a href="{{ route('guardrail.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Guardrail
                </a>
                @endcan
            </div>
            
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('guardrail.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="jalan_id" class="form-control">
                                <option value="">Semua Jalan</option>
                                @foreach($jalans as $jalan)
                                    <option value="{{ $jalan->id }}" 
                                        {{ request('jalan_id') == $jalan->id ? 'selected' : '' }}>
                                        {{ $jalan->nama_jalan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jalan</th>
                                <th>Tipe Guardrail</th>
                                <th>Panjang (m)</th>
                                <th>KM</th>
                                <th>Kondisi</th>
                                <th>Tanggal Pemasangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guardrails as $index => $guardrail)
                                <tr>
                                    <td>{{ $guardrails->firstItem() + $index }}</td>
                                    <td>{{ $guardrail->jalan->nama_jalan ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $guardrail->tipe_guardrail == 'Baja' ? 'secondary' : ($guardrail->tipe_guardrail == 'Beton' ? 'info' : 'warning') }}">
                                            {{ $guardrail->tipe_guardrail }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">Seharusnya:</small> {{ number_format($guardrail->panjang_seharusnya, 1) }}<br>
                                        <small class="text-muted">Terpasang:</small> {{ number_format($guardrail->panjang_terpasang, 1) }}
                                    </td>
                                    <td>{{ $guardrail->km_awal }} - {{ $guardrail->km_akhir }}</td>
                                    <td>
                                        @if($guardrail->kondisi == 'baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($guardrail->kondisi == 'rusak_ringan')
                                            <span class="badge bg-warning">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td>{{ $guardrail->tanggal_pemasangan ? $guardrail->tanggal_pemasangan->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('guardrail.show', $guardrail) }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('admin-only')
                                            <a href="{{ route('guardrail.edit', $guardrail) }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('guardrail.destroy', $guardrail) }}" method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data guardrail</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $guardrails->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection