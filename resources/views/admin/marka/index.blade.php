@extends('layouts.app')

@section('page-title', 'Data Marka Jalan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Data Marka Jalan</h3>
                @can('admin-only')
                <a href="{{ route('marka.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Marka
                </a>
                @endcan
            </div>
                
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('marka.index') }}" class="mb-3">
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
                                    <th>Jenis Marka</th>
                                    <th>Warna</th>
                                    <th>Panjang (m)</th>
                                    <th>KM</th>
                                    <th>Kondisi</th>
                                    <th>Tanggal Pemasangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($markas as $index => $marka)
                                    <tr>
                                        <td>{{ $markas->firstItem() + $index }}</td>
                                        <td>{{ $marka->jalan->nama_jalan ?? '-' }}</td>
                                        <td>{{ $marka->jenis_marka }}</td>
                                        <td>
                                            <span class="badge bg-{{ $marka->warna == 'Putih' ? 'light text-dark' : 'warning' }}">
                                                {{ $marka->warna }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">Seharusnya:</small> {{ number_format($marka->panjang_seharusnya, 1) }}<br>
                                            <small class="text-muted">Terpasang:</small> {{ number_format($marka->panjang_terpasang, 1) }}
                                        </td>
                                        <td>{{ $marka->km_awal }} - {{ $marka->km_akhir }}</td>
                                        <td>
                                            @if($marka->kondisi == 'baik')
                                                <span class="badge bg-success">Baik</span>
                                            @elseif($marka->kondisi == 'pudar')
                                                <span class="badge bg-warning">Pudar</span>
                                            @else
                                                <span class="badge bg-danger">Hilang</span>
                                            @endif
                                        </td>
                                        <td>{{ $marka->tanggal_pemasangan ? $marka->tanggal_pemasangan->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('marka.show', $marka) }}" class="btn btn-outline-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @can('admin-only')
                                                <a href="{{ route('marka.edit', $marka) }}" class="btn btn-outline-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('marka.destroy', $marka) }}" method="POST" 
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
                                        <td colspan="9" class="text-center">Tidak ada data marka</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $markas->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection