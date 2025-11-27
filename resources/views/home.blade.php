@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <div class="hero-badge">
                    <i class="fas fa-circle-check me-2"></i>
                    Sistem PPDB Online Terpercaya
                </div>
                
                <!-- Card Gelombang Aktif -->
                @if($gelombangAktif)
                <div class="wave-main-container mt-4">
                    <div class="wave-card">
                        <div class="wave-header">
                            <div class="wave-icon">
                                <i class="fas fa-wave-square"></i>
                            </div>
                            <div class="wave-title">
                                <h4>{{ $gelombangAktif->nama }}</h4>
                                <p>Gelombang Pendaftaran Sedang Berlangsung</p>
                            </div>
                            <div class="wave-badge">
                                <span>Aktif</span>
                            </div>
                        </div>
                        <div class="wave-body">
                            <div class="wave-progress">
                                <div class="progress-bar-container">
                                    <div class="progress-bar" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <div class="progress-info">
                                    <span>Periode Pendaftaran</span>
                                    <span>{{ date('d M Y', strtotime($gelombangAktif->tgl_mulai)) }} - {{ date('d M Y', strtotime($gelombangAktif->tgl_selesai)) }}</span>
                                </div>
                            </div>
                            <div class="wave-countdown">
                                <div class="countdown-item">
                                    <span class="countdown-value" id="days">00</span>
                                    <span class="countdown-label">Hari</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" id="hours">00</span>
                                    <span class="countdown-label">Jam</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" id="minutes">00</span>
                                    <span class="countdown-label">Menit</span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value" id="seconds">00</span>
                                    <span class="countdown-label">Detik</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Informasi Total Kuota dengan Desain yang Sama -->
                <div class="wave-main-container mt-4">
                    <div class="wave-card">
                        <div class="wave-header">
                            <div class="wave-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="wave-title">
                                <h4>Kuota Pendaftaran</h4>
                                <p>Total Kuota Tersedia untuk Gelombang Ini</p>
                            </div>
                            <div class="wave-badge">
                                @if($totalKuotaTersisa > 0)
                                <span class="status-available">Tersedia</span>
                                @else
                                <span class="status-full">Penuh</span>
                                @endif
                            </div>
                        </div>
                        <div class="wave-body">
                            <div class="kuota-content">
                                <div class="kuota-stats">
                                    <div class="kuota-stat-item">
                                        <div class="kuota-label">Total Kuota</div>
                                        <div class="kuota-value">{{ $totalKuota }} kursi</div>
                                    </div>
                                    <div class="kuota-stat-item">
                                        <div class="kuota-label">Sudah Terisi</div>
                                        <div class="kuota-value">{{ $totalKuota - $totalKuotaTersisa }} kursi</div>
                                    </div>
                                    <div class="kuota-stat-item highlight">
                                        <div class="kuota-label">Tersisa</div>
                                        <div class="kuota-value">{{ $totalKuotaTersisa }} kursi</div>
                                    </div>
                                </div>
                                <div class="kuota-progress-container">
                                    <div class="kuota-progress-bar">
                                        <div class="kuota-progress-fill" style="width: {{ $totalKuota > 0 ? (($totalKuota - $totalKuotaTersisa) / $totalKuota * 100) : 0 }}%"></div>
                                    </div>
                                    <div class="kuota-progress-text">
                                        <span>{{ $totalKuota > 0 ? round((($totalKuota - $totalKuotaTersisa) / $totalKuota * 100), 1) : 0 }}% Terisi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-3 mt-4 justify-content-center flex-wrap">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-hero-primary">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-hero-primary">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('tracking.index') }}" class="btn btn-hero-secondary">
                            <i class="fas fa-search me-2"></i>Cek Status
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROFIL SEKOLAH SECTION -->
<section class="profile-section">
    <div class="container">
        <div class="section-header text-center">
            <div class="section-badge">
                <i class="fas fa-school me-2"></i>
                Profil Sekolah
            </div>
            <h2 class="section-title">SMK Unggulan</h2>
            <p class="section-subtitle">Mencetak generasi profesional yang kompeten dan berkarakter</p>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="profile-content">
                    <h3 class="profile-title">Visi & Misi Kami</h3>
                    <p class="profile-description">
                        SMK Unggulan berkomitmen untuk memberikan pendidikan berkualitas yang mengintegrasikan 
                        pengetahuan teoritis dengan keterampilan praktis, mempersiapkan siswa untuk menjadi 
                        tenaga kerja profesional di era digital.
                    </p>
                    <div class="profile-features">
                        <div class="profile-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Fasilitas lengkap dan modern</span>
                        </div>
                        <div class="profile-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pengajar berpengalaman dan bersertifikat</span>
                        </div>
                        <div class="profile-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Kurikulum berbasis industri</span>
                        </div>
                        <div class="profile-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Program magang di perusahaan ternama</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="profile-image">
                    <img src="{{ asset('assets/images/PK.jpg') }}" 
                         alt="SMK Unggulan" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JURUSAN SECTION -->
<section class="jurusan-section">
    <div class="container">
        <div class="section-header text-center">
            <div class="section-badge">
                <i class="fas fa-graduation-cap me-2"></i>
                Program Jurusan
            </div>
            <h2 class="section-title">Pilihan Jurusan Unggulan</h2>
            <p class="section-subtitle">Tersedia berbagai program keahlian yang sesuai dengan minat dan bakat siswa</p>
        </div>
        <div class="row g-4">
            <!-- RPL -->
            <div class="col-lg-4 col-md-6">
                <div class="jurusan-card">
                    <div class="jurusan-logo">
                        <img src="{{ asset('assets/images/PPLG.jpg') }}" alt="RPL Logo">
                    </div>
                    <div class="jurusan-content">
                        <h4 class="jurusan-title">Rekayasa Perangkat Lunak</h4>
                        <p class="jurusan-description">
                            Mempelajari pengembangan software, pemrograman web dan mobile, database, 
                            serta teknologi informasi terkini untuk menjadi programmer profesional.
                        </p>
                        <div class="jurusan-features">
                            <span class="jurusan-feature">Pemrograman</span>
                            <span class="jurusan-feature">Web Development</span>
                            <span class="jurusan-feature">Mobile App</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- AKT -->
            <div class="col-lg-4 col-md-6">
                <div class="jurusan-card">
                    <div class="jurusan-logo">
                        <img src="{{ asset('assets/images/AKT.jpg') }}" alt="AKT Logo">
                    </div>
                    <div class="jurusan-content">
                        <h4 class="jurusan-title">Akuntansi</h4>
                        <p class="jurusan-description">
                            Menguasai ilmu akuntansi, keuangan, perpajakan, dan sistem informasi akuntansi 
                            untuk menjadi tenaga akuntan yang kompeten di dunia bisnis.
                        </p>
                        <div class="jurusan-features">
                            <span class="jurusan-feature">Akuntansi</span>
                            <span class="jurusan-feature">Perpajakan</span>
                            <span class="jurusan-feature">Keuangan</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- AMS -->
            <div class="col-lg-4 col-md-6">
                <div class="jurusan-card">
                    <div class="jurusan-logo">
                        <img src="{{ asset('assets/images/AMS.jpg') }}" alt="AMS Logo">
                    </div>
                    <div class="jurusan-content">
                        <h4 class="jurusan-title">Animasi</h4>
                        <p class="jurusan-description">
                            Mengembangkan kreativitas dalam pembuatan animasi 2D dan 3D, visual effects, 
                            dan motion graphics untuk industri film, game, dan media digital.
                        </p>
                        <div class="jurusan-features">
                            <span class="jurusan-feature">Animasi 2D/3D</span>
                            <span class="jurusan-feature">Visual Effects</span>
                            <span class="jurusan-feature">Motion Graphics</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- DKV -->
            <div class="col-lg-4 col-md-6">
                <div class="jurusan-card">
                    <div class="jurusan-logo">
                        <img src="{{ asset('assets/images/DKV.jpg') }}" alt="DKV Logo">
                    </div>
                    <div class="jurusan-content">
                        <h4 class="jurusan-title">Desain Komunikasi Visual</h4>
                        <p class="jurusan-description">
                            Mengembangkan kreativitas dalam desain grafis, multimedia, animasi, dan 
                            visual branding untuk industri kreatif dan digital.
                        </p>
                        <div class="jurusan-features">
                            <span class="jurusan-feature">Desain Grafis</span>
                            <span class="jurusan-feature">Multimedia</span>
                            <span class="jurusan-feature">Animasi</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- BDP -->
            <div class="col-lg-4 col-md-6">
                <div class="jurusan-card">
                    <div class="jurusan-logo">
                        <img src="{{ asset('assets/images/BDP.jpg') }}" alt="BDP Logo">
                    </div>
                    <div class="jurusan-content">
                        <h4 class="jurusan-title">Bisnis Daring dan Pemasaran</h4>
                        <p class="jurusan-description">
                            Memahami strategi pemasaran digital, e-commerce, manajemen bisnis online, 
                            dan pengembangan produk untuk wirausaha di era digital.
                        </p>
                        <div class="jurusan-features">
                            <span class="jurusan-feature">Digital Marketing</span>
                            <span class="jurusan-feature">E-commerce</span>
                            <span class="jurusan-feature">Bisnis Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LOCATION SECTION -->
<section class="location-section">
    <div class="container">
        <div class="section-header text-center">
            <div class="section-badge">
                <i class="fas fa-map-marker-alt me-2"></i>
                Lokasi Sekolah
            </div>
            <h2 class="section-title">Temukan Kami</h2>
            <p class="section-subtitle">SMK Bakti Nusantara 666 berlokasi strategis di Cileunyi, Kabupaten Bandung</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="map-container">
                    <div id="schoolMap"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="location-info">
                    <div class="location-card">
                        <div class="location-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="location-details">
                            <h5>SMK Bakti Nusantara 666</h5>
                            <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat</p>
                            <p><i class="fas fa-phone me-2"></i>(022) 1234-5678</p>
                            <div class="location-actions">
                                <a href="https://maps.google.com/?q=-6.941325425128331,107.74031323187455" target="_blank" class="btn btn-location-primary">
                                    <i class="fas fa-directions me-2"></i>Petunjuk Arah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="cta-title">Siap Bergabung Dengan Kami?</h3>
                    <p class="cta-description">Jangan lewatkan kesempatan untuk menjadi bagian dari keluarga besar SMK Unggulan. Daftar sekarang dan raih masa depan gemilang!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-cta">
                        <i class="fas fa-rocket me-2"></i>Mulai Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current).toLocaleString();
        }
    }, 16);
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            });
        }
    });
}, { threshold: 0.3 });

document.addEventListener('DOMContentLoaded', () => {
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) observer.observe(statsSection);
    
    // Countdown Timer untuk Gelombang Aktif
    @if($gelombangAktif)
    const countDownDate = new Date("{{ $gelombangAktif->tgl_selesai }}").getTime();
    
    const countdownFunction = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;
        
        if (distance < 0) {
            clearInterval(countdownFunction);
            document.querySelector('.wave-countdown').innerHTML = "<div class='countdown-expired'>Pendaftaran Telah Berakhir</div>";
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
        document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
        document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');
    }, 1000);
    @endif
    
    // Initialize school location map
    var schoolMap = L.map('schoolMap').setView([-6.941325425128331, 107.74031323187455], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(schoolMap);
    
    var schoolIcon = L.divIcon({
        className: 'school-marker-home',
        html: '<div style="background: var(--accent-red); width: 40px; height: 40px; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4); display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;"><i class="fas fa-building" style="color: white; font-size: 18px;"></i></div>',
        iconSize: [40, 40]
    });
    
    L.marker([-6.941325425128331, 107.74031323187455], {icon: schoolIcon})
        .addTo(schoolMap)
        .bindPopup('<div style="text-align: center; font-family: Inter, sans-serif;"><strong style="color: var(--accent-red); font-size: 16px;">SMK Bakti Nusantara 666</strong><br><small>Jl. Percobaan Km. 17 No. 65<br>Cileunyi, Kabupaten Bandung</small></div>');
});
</script>
@endpush

@push('styles')
<style>
:root {
    --cream: #FFFFFF;
    --cream-dark: #F5F5F5;
    --cream-darker: #E5E5E5;
    --primary: #1E40AF;
    --primary-light: #3B82F6;
    --primary-dark: #1E3A8A;
    --accent-red: #DC2626;
    --accent-red-light: #EF4444;
    --accent-red-dark: #B91C1C;
    --accent-yellow: #F59E0B;
    --accent-yellow-light: #FBBF24;
    --accent-yellow-dark: #D97706;
    --accent-green: #10B981;
    --accent-green-light: #34D399;
    --accent-green-dark: #059669;
    --accent-turquoise: #06B6D4;
    --accent-turquoise-light: #22D3EE;
    --accent-turquoise-dark: #0891B2;
    --text-dark: #1F2937;
    --text-medium: #4B5563;
    --text-light: #6B7280;
    --white: #FFFFFF;
}

/* HERO SECTION - White */
.hero-section {
    background: var(--white);
    color: var(--text-dark);
    padding: 120px 0 60px;
    margin-top: 0;
    position: relative;
    overflow: hidden;
}

.hero-section .container { 
    position: relative; 
    z-index: 2; 
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: var(--accent-red);
    color: var(--white);
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.95rem;
    margin-bottom: 2rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
}

/* Gelombang Aktif dan Kuota dengan Desain yang Sama */
.wave-main-container {
    max-width: 1000px;
    margin: 0 auto;
}

.wave-card {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
    color: white;
    position: relative;
    z-index: 1;
}

.wave-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='20' viewBox='0 0 100 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21.184 20c.357-.13.72-.264 1.088-.402l1.768-.661C33.64 15.347 39.647 14 50 14c10.271 0 15.362 1.222 24.629 4.928.955.383 1.869.74 2.75 1.072h6.225c-2.51-.73-5.139-1.691-8.233-2.928C65.888 13.278 60.562 12 50 12c-10.626 0-16.855 1.397-26.66 5.063l-1.767.662c-2.475.923-4.66 1.674-6.724 2.275h6.335zm0-20C13.258 2.892 8.077 4 0 4V2c5.744 0 9.951-.574 14.85-2h6.334zM77.38 0C85.239 2.966 90.502 4 100 4V2c-6.842 0-11.386-.542-16.396-2h-6.225zM0 14c8.44 0 13.718-1.21 22.272-4.402l1.768-.661C33.64 5.347 39.647 4 50 4c10.271 0 15.362 1.222 24.629 4.928C84.112 12.722 89.438 14 100 14v-2c-10.271 0-15.362-1.222-24.629-4.928C65.888 3.278 60.562 2 50 2 39.374 2 33.145 3.397 23.34 7.063l-1.767.662C13.223 10.84 8.163 12 0 12v2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    z-index: -1;
    opacity: 0.3;
}

.wave-header {
    display: flex;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.wave-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.8rem;
}

.wave-title {
    flex: 1;
}

.wave-title h4 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.wave-title p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.wave-badge {
    background: var(--accent-green);
    color: white;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.wave-body {
    padding: 1.5rem 2rem;
}

.wave-progress {
    margin-bottom: 1.5rem;
}

.progress-bar-container {
    height: 10px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-bar {
    height: 100%;
    background: var(--accent-green);
    border-radius: 5px;
    transition: width 1s ease-in-out;
    position: relative;
    overflow: hidden;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: linear-gradient(
        -45deg,
        rgba(255, 255, 255, 0.2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.2) 75%,
        transparent 75%,
        transparent
    );
    background-size: 50px 50px;
    animation: move 2s linear infinite;
    border-radius: 5px;
}

@keyframes move {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 50px 50px;
    }
}

.progress-info {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    opacity: 0.9;
}

.wave-countdown {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.countdown-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.15);
    padding: 0.8rem 1rem;
    border-radius: 10px;
    min-width: 70px;
    backdrop-filter: blur(10px);
}

.countdown-value {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
}

.countdown-label {
    display: block;
    font-size: 0.75rem;
    opacity: 0.9;
    margin-top: 0.3rem;
}

.countdown-expired {
    text-align: center;
    font-weight: 600;
    font-size: 1.2rem;
    padding: 1rem;
}

/* Styling untuk Konten Kuota */
.kuota-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.kuota-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.kuota-stat-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.kuota-stat-item.highlight {
    background: rgba(251, 191, 36, 0.2);
    border-color: rgba(251, 191, 36, 0.3);
}

.kuota-label {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.kuota-value {
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
}

.kuota-stat-item.highlight .kuota-value {
    color: #FBBF24;
}

.kuota-progress-container {
    margin-top: 0.5rem;
}

.kuota-progress-bar {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.kuota-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #FBBF24, #F59E0B);
    border-radius: 4px;
    transition: width 1s ease-in-out;
    position: relative;
}

.kuota-progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: linear-gradient(
        -45deg,
        rgba(255, 255, 255, 0.3) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.3) 50%,
        rgba(255, 255, 255, 0.3) 75%,
        transparent 75%,
        transparent
    );
    background-size: 30px 30px;
    animation: move 1.5s linear infinite;
    border-radius: 4px;
}

.kuota-progress-text {
    text-align: center;
    font-size: 0.85rem;
    opacity: 0.9;
}

.status-available {
    color: #34D399;
    background: rgba(52, 211, 153, 0.2);
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-block;
}

.status-full {
    color: #EF4444;
    background: rgba(239, 68, 68, 0.2);
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-block;
}

.btn-hero-primary {
    background: var(--accent-red);
    color: var(--white);
    border: none;
    font-weight: 600;
    padding: 16px 36px;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-hero-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.btn-hero-primary:hover::before {
    left: 100%;
}

.btn-hero-primary:hover {
    background: var(--accent-red-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    color: var(--white);
}

.btn-hero-secondary {
    background: transparent;
    color: var(--accent-red);
    border: 2px solid var(--accent-red);
    font-weight: 600;
    padding: 14px 36px;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-hero-secondary:hover {
    background: var(--accent-red);
    border-color: var(--accent-red);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
}

/* PROFIL SEKOLAH SECTION */
.profile-section {
    padding: 80px 0;
    background: var(--cream-dark);
    position: relative;
}

.profile-content {
    padding-right: 2rem;
}

.profile-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.2rem;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
}

.profile-description {
    font-size: 1.1rem;
    color: var(--text-medium);
    line-height: 1.7;
    margin-bottom: 2rem;
}

.profile-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.profile-feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 1rem;
    color: var(--text-dark);
}

.profile-feature-item i {
    color: var(--accent-green);
    font-size: 1.2rem;
}

.profile-image {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.profile-image img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.profile-image:hover img {
    transform: scale(1.05);
}

/* JURUSAN SECTION */
.jurusan-section {
    padding: 80px 0;
    background: var(--white);
    position: relative;
}

.jurusan-card {
    background: var(--white);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    border: 1px solid var(--cream-darker);
    height: 100%;
    text-align: center;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.jurusan-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--accent-red);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.jurusan-card:hover::before {
    opacity: 1;
}

.jurusan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border-color: var(--accent-red);
}

.jurusan-logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.jurusan-logo img {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

.jurusan-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.4rem;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.jurusan-description {
    font-size: 0.95rem;
    color: var(--text-medium);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.jurusan-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
}

.jurusan-feature {
    background: var(--cream-dark);
    color: var(--text-dark);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.jurusan-card:hover .jurusan-feature {
    background: var(--accent-red);
    color: var(--white);
}

/* SECTION HEADER */
.section-header { 
    margin-bottom: 3rem;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    background: var(--accent-red);
    color: var(--white);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
}

.section-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.8rem;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-light);
    line-height: 1.6;
}

/* LOCATION SECTION - White */
.location-section {
    padding: 80px 0;
    background: var(--white);
    position: relative;
    overflow: hidden;
}

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: 1px solid var(--cream-darker);
}

#schoolMap {
    height: 400px;
    width: 100%;
}

.location-info {
    padding-left: 2rem;
}

.location-card {
    background: var(--white);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    border: 1px solid var(--cream-darker);
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.location-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--accent-red);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.location-icon {
    width: 80px;
    height: 80px;
    background: var(--accent-red);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: var(--white);
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
}

.location-details h5 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.location-details p {
    color: var(--text-medium);
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
}

.location-details p i {
    color: var(--accent-red);
    width: 20px;
}

.location-actions {
    margin-top: 1.5rem;
}

.btn-location-primary {
    background: var(--accent-red);
    color: var(--white);
    border: none;
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}

.btn-location-primary:hover {
    background: var(--accent-red-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    color: var(--white);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* CTA SECTION - White */
.cta-section {
    padding: 80px 0;
    background: var(--white);
    position: relative;
    overflow: hidden;
}

.cta-card {
    background: var(--accent-red);
    color: var(--white);
    padding: 4rem 3rem;
    border-radius: 30px;
    box-shadow: 0 20px 60px rgba(220, 38, 38, 0.2);
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: rgba(245, 158, 11, 0.15);
    border-radius: 50%;
    animation: rotate 20s infinite linear;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.cta-card .row {
    position: relative;
    z-index: 1;
}

.cta-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    line-height: 1.6;
}

.btn-cta {
    background: var(--white);
    color: var(--accent-red);
    border: none;
    font-weight: 700;
    padding: 16px 40px;
    border-radius: 50px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.btn-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.btn-cta:hover::before {
    left: 100%;
}

.btn-cta:hover {
    background: var(--cream);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    color: var(--accent-red);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .hero-section { padding: 80px 0 40px; }
    .section-title { font-size: 2.2rem; }
    .jurusan-card, .location-card { padding: 2rem 1.5rem; }
    .cta-card { padding: 2.5rem 1.5rem; text-align: center; }
    .jurusan-section, .location-section, .profile-section, .cta-section { padding: 60px 0; }
    .location-info { padding-left: 0; margin-top: 2rem; }
    #schoolMap { height: 300px; }
    .wave-header { flex-direction: column; text-align: center; gap: 1rem; }
    .wave-icon { margin-right: 0; }
    .wave-countdown { gap: 0.8rem; }
    .countdown-item { min-width: 60px; padding: 0.6rem 0.8rem; }
    .countdown-value { font-size: 1.4rem; }
    .kuota-stats { grid-template-columns: 1fr; gap: 0.8rem; }
    .profile-content { padding-right: 0; margin-bottom: 2rem; }
    .jurusan-logo { width: 80px; height: 80px; padding: 1rem; }
    .jurusan-logo img { width: 50px; height: 50px; }
}

@media (max-width: 576px) {
    .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
    .jurusan-section, .location-section, .profile-section, .cta-section { padding: 50px 0; }
    .wave-countdown { flex-wrap: wrap; }
    .countdown-item { flex: 1; min-width: auto; }
    .kuota-stats { grid-template-columns: 1fr; }
    .jurusan-card { padding: 1.5rem; }
    .jurusan-title { font-size: 1.2rem; }
    .jurusan-description { font-size: 0.9rem; }
}
</style>
@endpush