@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Infrastruktur Jalan')

@section('content')

<!-- Informasi Indikator Kinerja -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-secondary shadow-sm" role="alert">
            <h5 class="fw-bold mb-2"><i class="bi bi-info-circle-fill"></i> Indikator Kinerja Dinas Perhubungan</h5>
            <p class="mb-0">
                Indikator kinerja Dinas Perhubungan adalah ukuran atau parameter yang digunakan untuk menilai tingkat pencapaian sasaran dan tujuan program di bidang perhubungan, sebagaimana diatur dalam dokumen perencanaan pembangunan daerah berdasarkan <strong>Permendagri Nomor 86 Tahun 2017</strong>. Indikator ini digunakan untuk mengukur keberhasilan pelaksanaan kegiatan secara <strong>efektif</strong>, <strong>efisien</strong>, dan <strong>terukur</strong>.
            </p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <i class="bi bi-map fs-1 mb-2"></i>
                <h5 class="card-title">Total Jalan</h5>
                <h2 class="mb-0">{{ number_format($totalJalan) }}</h2>
                <small>Ruas Jalan</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card rambu">
            <div class="card-body text-center">
                <i class="bi bi-sign-stop fs-1 mb-2"></i>
                <h5 class="card-title">Rambu</h5>
                <h2 class="mb-0">{{ number_format($totalRambu) }}</h2>
                <small>{{ $persentaseRambu }}% Terpasang</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card marka">
            <div class="card-body text-center">
                <i class="bi bi-dash-lg fs-1 mb-2"></i>
                <h5 class="card-title">Marka</h5>
                <h2 class="mb-0">{{ number_format($totalMarka, 2) }}</h2>
                <small>{{ $persentaseMarka }}% Terpasang (km)</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card guardrail">
            <div class="card-body text-center">
                <i class="bi bi-shield fs-1 mb-2"></i>
                <h5 class="card-title">Guardrail</h5>
                <h2 class="mb-0">{{ number_format($totalGuardrail, 2) }}</h2>
                <small>{{ $persentaseGuardrail }}% Terpasang (km)</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card stat-card apill">
            <div class="card-body text-center">
                <i class="bi bi-traffic-light fs-1 mb-2"></i>
                <h5 class="card-title">APILL</h5>
                <h2 class="mb-0">{{ number_format($totalApill) }}</h2>
                <small>{{ $persentaseApill }}% Terpasang</small>
            </div>
        </div>
    </div>
</div>

<!-- Performance Overview -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Persentase Kinerja Keseluruhan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Rambu Lalu Lintas</span>
                        <span class="fw-bold">{{ $persentaseRambu }}%</span>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-info" style="width: {{ $persentaseRambu }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Marka Jalan</span>
                        <span class="fw-bold">{{ $persentaseMarka }}%</span>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" style="width: {{ $persentaseMarka }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Guardrail</span>
                        <span class="fw-bold">{{ $persentaseGuardrail }}%</span>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning" style="width: {{ $persentaseGuardrail }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>APILL</span>
                        <span class="fw-bold">{{ $persentaseApill }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: {{ $persentaseApill }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Distribusi Kinerja</h5>
            </div>
            <div class="card-body">
                <canvas id="performanceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Performance by Road -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Kinerja Per Ruas Jalan</h5>
            </div>
            <div class="card-body">
                <div style="height: 400px; overflow-x: auto;">
                    <canvas id="roadPerformanceChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('jalan.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Data Jalan
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('rambu.create') }}" class="btn btn-info w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Rambu
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('marka.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Marka
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="#" class="btn btn-secondary w-100">
                            <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Performance pie chart
    const performanceCtx = document.getElementById('performanceChart').getContext('2d');
    new Chart(performanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Rambu', 'Marka', 'Guardrail', 'APILL'],
            datasets: [{
                data: [{{ $persentaseRambu }}, {{ $persentaseMarka }}, {{ $persentaseGuardrail }}, {{ $persentaseApill }}],
                backgroundColor: [
                    '#17a2b8',
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Road performance chart
    const roadCtx = document.getElementById('roadPerformanceChart').getContext('2d');
    const chartData = @json($chartData);
    
    const roadLabels = chartData.map(item => item.jalan);
    const rambuData = chartData.map(item => item.rambu);
    const markaData = chartData.map(item => item.marka);
    const guardrailData = chartData.map(item => item.guardrail);
    const apillData = chartData.map(item => item.apill);

    new Chart(roadCtx, {
        type: 'bar',
        data: {
            labels: roadLabels,
            datasets: [
                {
                    label: 'Rambu (%)',
                    data: rambuData,
                    backgroundColor: '#17a2b8',
                    borderColor: '#117a8b',
                    borderWidth: 1
                },
                {
                    label: 'Marka (%)',
                    data: markaData,
                    backgroundColor: '#28a745',
                    borderColor: '#1e7e34',
                    borderWidth: 1
                },
                {
                    label: 'Guardrail (%)',
                    data: guardrailData,
                    backgroundColor: '#ffc107',
                    borderColor: '#d39e00',
                    borderWidth: 1
                },
                {
                    label: 'APILL (%)',
                    data: apillData,
                    backgroundColor: '#dc3545',
                    borderColor: '#bd2130',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush