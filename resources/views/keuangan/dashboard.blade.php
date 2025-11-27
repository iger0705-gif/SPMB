@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title" style="font-family: 'Poppins', sans-serif; font-weight: 700;"><i class="fas fa-cash-register me-2"></i>Dashboard Keuangan</h4>
        <p class="page-subtitle" style="font-family: 'Inter', sans-serif;">Monitoring pembayaran dan verifikasi keuangan PPDB</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; border-left: 4px solid #10B981;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon rounded-3 p-3" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="bi bi-cash-coin" style="color: #10B981; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="stat-number mb-1 text-success" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h3>
                            <p class="stat-label mb-0" style="font-family: 'Inter', sans-serif; color: #6B7280;">Total Pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; border-left: 4px solid #F59E0B;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon rounded-3 p-3" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="bi bi-clock-history" style="color: #F59E0B; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="stat-number mb-1 text-warning" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ $menungguVerifikasi }}</h3>
                            <p class="stat-label mb-0" style="font-family: 'Inter', sans-serif; color: #6B7280;">Menunggu Verifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; border-left: 4px solid #3B82F6;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon rounded-3 p-3" style="background: rgba(59, 130, 246, 0.1);">
                                <i class="bi bi-check-circle" style="color: #3B82F6; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="stat-number mb-1 text-primary" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ $terverifikasiHariIni }}</h3>
                            <p class="stat-label mb-0" style="font-family: 'Inter', sans-serif; color: #6B7280;">Terverifikasi Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; border-left: 4px solid #EF4444;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon rounded-3 p-3" style="background: rgba(239, 68, 68, 0.1);">
                                <i class="bi bi-x-circle" style="color: #EF4444; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="stat-number mb-1 text-danger" style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ $ditolak }}</h3>
                            <p class="stat-label mb-0" style="font-family: 'Inter', sans-serif; color: #6B7280;">Pembayaran Ditolak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Grafik Status Pembayaran -->
        <div class="col-xl-6">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="bi bi-pie-chart-fill me-2"></i>Status Pembayaran
                    </h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $statusColors = [
                            'BELUM_BAYAR' => ['color' => '#94A3B8', 'label' => 'Belum Bayar', 'icon' => 'clock'],
                            'MENUNGGU_VERIFIKASI' => ['color' => '#F59E0B', 'label' => 'Menunggu Verifikasi', 'icon' => 'hourglass'],
                            'TERBAYAR' => ['color' => '#10B981', 'label' => 'Terbayar', 'icon' => 'check-circle'],
                            'DITOLAK' => ['color' => '#EF4444', 'label' => 'Ditolak', 'icon' => 'x-circle'],
                        ];
                        $totalStatus = $statusPembayaran->sum('total');
                    @endphp
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <div class="chart-container" style="height: 200px; position: relative;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @foreach($statusPembayaran as $status)
                            @php
                                $statusInfo = $statusColors[$status->status] ?? ['color' => '#64748b', 'label' => $status->status, 'icon' => 'circle'];
                                $percentage = $totalStatus > 0 ? ($status->total / $totalStatus * 100) : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-3 p-2 rounded-2" style="background: #F9FAFB;">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-{{ $statusInfo['icon'] }} me-2" style="color: {{ $statusInfo['color'] }}; font-size: 1rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-family: 'Inter', sans-serif; font-weight: 500; font-size: 0.9rem;">{{ $statusInfo['label'] }}</span>
                                        <div class="text-end">
                                            <div style="font-family: 'Poppins', sans-serif; font-weight: 700; color: {{ $statusInfo['color'] }}; font-size: 1.1rem;">{{ $status->total }}</div>
                                            <small style="font-family: 'Inter', sans-serif; color: #6B7280; font-size: 0.8rem;">{{ number_format($percentage, 1) }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pembayaran per Hari -->
        <div class="col-xl-6">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="bi bi-bar-chart-fill me-2"></i>Pembayaran 7 Hari Terakhir
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="height: 300px; position: relative;">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Pembayaran Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = {
        labels: {!! json_encode($statusPembayaran->map(function($item) use ($statusColors) { 
            return $statusColors[$item->status]['label']; 
        })) !!},
        datasets: [{
            data: {!! json_encode($statusPembayaran->pluck('total')) !!},
            backgroundColor: {!! json_encode($statusPembayaran->map(function($item) use ($statusColors) { 
                return $statusColors[$item->status]['color']; 
            })) !!},
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 8
        }]
    };

    new Chart(statusCtx, {
        type: 'doughnut',
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Daily Pembayaran Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyData = {
        labels: {!! json_encode($pembayaranPerHari->map(function($item) { 
            return \Carbon\Carbon::parse($item->tanggal)->format('d M'); 
        })) !!},
        datasets: [{
            label: 'Jumlah Pembayaran',
            data: {!! json_encode($pembayaranPerHari->pluck('total')) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.6)',
            borderColor: '#3B82F6',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    };

    new Chart(dailyCtx, {
        type: 'bar',
        data: dailyData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            family: 'Inter'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Inter'
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection