@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    #map { height: 600px; width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .filter-panel { 
        background: white; 
        border-radius: 12px; 
        padding: 20px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        font-family: 'Inter', sans-serif;
    }
    .stat-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
    }
    .stat-box h4 { font-family: 'Poppins', sans-serif; font-weight: 700; margin: 0; }
    .stat-box p { margin: 0; font-size: 13px; opacity: 0.9; }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 13px;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-geo-alt-fill me-2"></i>Peta Sebaran Domisili</h4>
        <p class="page-subtitle">Visualisasi geografis lokasi domisili pendaftar</p>
    </div>

    <!-- Statistik Peta -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-box">
                <h4>{{ $totalPendaftar }}</h4>
                <p>Total Pendaftar di Peta</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h4>{{ $kepadatanTertinggi->kecamatan ?? '-' }}</h4>
                <p>Kepadatan Tertinggi ({{ $kepadatanTertinggi->total ?? 0 }} siswa)</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h4 id="wilayahTerjauh">-</h4>
                <p>Wilayah Terjauh dari Sekolah</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Filter Panel -->
        <div class="col-lg-3">
            <div class="filter-panel">
                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-funnel-fill me-2 text-primary"></i>Filter Peta
                </h6>
                <form method="GET" id="filterForm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-mortarboard me-1"></i>Jurusan</label>
                        <select name="jurusan_id" class="form-select form-select-sm">
                            <option value="">☑ Semua Jurusan</option>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i>Gelombang</label>
                        <select name="gelombang_id" class="form-select form-select-sm">
                            <option value="">☑ Semua Gelombang</option>
                            @foreach($gelombang as $g)
                            <option value="{{ $g->id }}" {{ request('gelombang_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-flag me-1"></i>Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">☑ Semua Status</option>
                            <option value="ADM_PASS" {{ request('status') == 'ADM_PASS' ? 'selected' : '' }}>Lulus Administrasi</option>
                            <option value="SUBMIT" {{ request('status') == 'SUBMIT' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>Terbayar</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-sm">
                        <i class="bi bi-search me-2"></i>Terapkan Filter
                    </button>
                    <a href="{{ route('peta.index') }}" class="btn btn-outline-secondary w-100 btn-sm mt-2">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                    </a>
                </form>

                <hr class="my-3">

                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-palette-fill me-2 text-success"></i>Legend
                </h6>
                @foreach($jurusan as $index => $j)
                @php
                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'];
                @endphp
                <div class="legend-item">
                    <div class="legend-color" style="background: {{ $colors[$index % 5] }};"></div>
                    <span>{{ $j->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Map -->
        <div class="col-lg-9">
            <div id="map"></div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
    // Initialize map (centered on Cileunyi)
    var map = L.map('map').setView([-6.9397, 107.7536], 13); // Cileunyi, Bandung coordinates

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    // Marker colors by jurusan
    var jurusanColors = {!! json_encode($jurusan->pluck('nama', 'id')->toArray()) !!};
    var colorPalette = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'];
    
    // Create marker cluster group
    var markers = L.markerClusterGroup({
        chunkedLoading: true,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true
    });

    // School location (Cileunyi, Bandung)
    var schoolLat = -6.9397;
    var schoolLng = 107.7536;
    
    // Add school marker (permanent, not in cluster)
    var schoolIcon = L.divIcon({
        className: 'school-marker',
        html: '<div style="background: #ef4444; width: 35px; height: 35px; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(239,68,68,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;"><i class="bi bi-building text-white" style="font-size: 18px;"></i></div>',
        iconSize: [35, 35]
    });
    var schoolMarker = L.marker([schoolLat, schoolLng], {
        icon: schoolIcon,
        zIndexOffset: 1000 // Always on top
    });
    schoolMarker.bindPopup('<div style="min-width: 200px;"><strong style="font-size: 15px;">SMK Bakti Nusantara 666</strong><br><small>Jl. Percobaan Km. 17 No. 65, Cileunyi<br>Kabupaten Bandung, Jawa Barat</small><br><em style="color: #ef4444;">📍 Lokasi Sekolah</em></div>');
    schoolMarker.addTo(map); // Add directly to map, not to cluster

    // Add pendaftar markers
    var pendaftarData = {!! json_encode($pendaftar) !!};
    var maxDistance = 0;
    var farthestLocation = '';

    pendaftarData.forEach(function(p, index) {
        if (p.lat && p.lng) {
            var colorIndex = Object.keys(jurusanColors).indexOf(p.jurusan_id.toString());
            var markerColor = colorPalette[colorIndex % colorPalette.length];
            
            var customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: ' + markerColor + '; width: 25px; height: 25px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                iconSize: [25, 25]
            });
            
            var marker = L.marker([p.lat, p.lng], {icon: customIcon});
            
            marker.bindPopup(`
                <div style="font-family: 'Inter', sans-serif;">
                    <strong style="color: ${markerColor};">${p.nama_lengkap}</strong><br>
                    <small><strong>No:</strong> ${p.no_pendaftaran}</small><br>
                    <small><strong>Jurusan:</strong> ${p.nama_jurusan}</small><br>
                    <small><strong>Alamat:</strong> ${p.alamat}</small><br>
                    <small><strong>Kecamatan:</strong> ${p.kecamatan}</small>
                </div>
            `);
            
            markers.addLayer(marker);
            
            // Calculate distance from school
            var distance = map.distance([schoolLat, schoolLng], [p.lat, p.lng]) / 1000; // in km
            if (distance > maxDistance) {
                maxDistance = distance;
                farthestLocation = p.kecamatan;
            }
        }
    });

    map.addLayer(markers);

    // Update farthest location
    document.getElementById('wilayahTerjauh').textContent = farthestLocation + ' (' + maxDistance.toFixed(1) + ' km)';

    // Fit bounds to show all markers
    if (pendaftarData.length > 0) {
        map.fitBounds(markers.getBounds().pad(0.1));
    }
</script>
@endsection
