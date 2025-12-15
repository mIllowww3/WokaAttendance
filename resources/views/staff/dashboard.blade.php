@extends('layout.app')

@section('content')

@section('title', 'Dashboard')

<div class="container-fluid py-4">
    <div class="row">
        <div class="row g-3 mt-4">
            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="card shadow border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <!-- Teks -->
                        <div>
                            <p class="text-sm mb-1 text-uppercase font-weight-bold">Total Absen</p>
                            <h4 class="font-weight-bolder mb-1">{{ $totalAbsen ?? 0 }}</h4>
                            <a href="{{ route('staff.absen.index') }}" class="text-primary small">Lihat Absen</a>
                        </div>

                        <!-- Icon -->
                        <div class="icon bg-gradient-primary shadow text-white rounded-circle d-flex align-items-center justify-content-center" style="width:60px; height:60px;">
                            <i class="ni ni-calendar-grid-58 fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="card shadow border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <!-- Teks -->
                        <div>
                            <p class="text-sm mb-1 text-uppercase font-weight-bold">Total Izin</p>
                            <h4 class="font-weight-bolder mb-1">{{ $totalIzin ?? 0 }}</h4>
                            <a href="{{ route('staff.izin.index') }}" class="text-danger small">Lihat Izin</a>
                        </div>

                        <!-- Icon -->
                        <div class="icon bg-gradient-danger shadow text-white rounded-circle d-flex align-items-center justify-content-center" style="width:60px; height:60px;">
                            <i class="ni ni-badge fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="ni ni-time-alarm me-2"></i>
                            Jadwal Kerja Mingguan
                        </h5>
                    </div>

                    <div class="card-body">
                        @if($jadwal->count() > 0)

                        <div class="row g-4">
                            @php
                            $colors = [
                            'Senin' => 'bg-gradient-primary',
                            'Selasa' => 'bg-gradient-success',
                            'Rabu' => 'bg-gradient-info',
                            'Kamis' => 'bg-gradient-warning',
                            'Jumat' => 'bg-gradient-danger',
                            'Sabtu' => 'bg-gradient-secondary',
                            'Minggu' => 'bg-gradient-dark'
                            ];

                            $icons = [
                            'Senin' => 'ni ni-calendar-grid-58',
                            'Selasa' => 'ni ni-watch-time',
                            'Rabu' => 'ni ni-time-alarm',
                            'Kamis' => 'ni ni-check-bold',
                            'Jumat' => 'ni ni-calendar-grid-58',
                            'Sabtu' => 'ni ni-calendar-grid-58',
                            'Minggu' => 'ni ni-calendar-grid-58'
                            ];
                            @endphp

                            @foreach($jadwal as $j)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card shadow-sm border-0 h-100 p-3 rounded-4 jadwal-card"
                                    style="border-top: 5px solid {{ str_replace('bg-gradient-', '', $colors[$j->hari]) }}">

                                    <div class="text-center mb-3">
                                        <div class="icon {{ $colors[$j->hari] }} shadow text-white rounded-circle"
                                            style="width:55px; height:55px; display:flex; align-items:center; justify-content:center;">
                                            <i class="{{ $icons[$j->hari] }} text-lg"></i>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold text-center mb-2">{{ $j->hari }}</h4>

                                    <div class="text-center">
                                        <p class="mb-1">
                                            <i class="ni ni-watch-time text-primary"></i>
                                            <strong>Masuk:</strong>
                                            {{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }}
                                        </p>

                                        <p>
                                            <i class="ni ni-time-alarm text-danger"></i>
                                            <strong>Pulang:</strong>
                                            {{ \Carbon\Carbon::parse($j->jam_pulang)->format('H:i') }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>

                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="ni ni-calendar-grid-58 text-lg"></i>
                            <p class="mt-2">Belum ada jadwal kerja.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

            <!-- GRAFIK & CAROUSEL -->
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Grafik Kehadiran Mingguan</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">4% peningkatan</span> 7 hari terakhir
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

               <!-- CAROUSEL -->
        <div class="col-lg-5">
            <div class="card card-carousel overflow-hidden h-100 p-0">
                <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner border-radius-lg h-100">

                        <div class="carousel-item h-100 active"
                            style="background-image: url('https://i.pinimg.com/1200x/6d/3a/fa/6d3afade5e8d56d285ab77c80360508b.jpg'); background-size: cover; background-position: center;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-qr-code text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-black mb-1">Absensi QR-Code</h5>
                                <p style="color: black;">Presensi cepat dan akurat dengan scan QR Pegawai.</p>
                            </div>
                        </div>

                        <div class="carousel-item h-100"
                            style="background-image: url('https://i.pinimg.com/736x/a4/21/50/a4215086ddb86c8975dfcbc61aaf8048.jpg'); background-size: cover; background-position: center;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-pin-3 text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-black mb-1">Presensi Lokasi (Radius)</h5>
                                <p style="color: black;">Validasi kehadiran berdasarkan titik kantor.</p>
                            </div>
                        </div>

                        <div class="carousel-item h-100"
                            style="background-image: url('https://i.pinimg.com/1200x/da/0b/7e/da0b7e3102fb0fcf1791b495c8834130.jpg'); background-size: cover; background-position: center;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-chart-bar-32 text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-black mb-1">Analitik Kehadiran</h5>
                                <p style="color: black;">Pantau performa kehadiran pegawai dengan grafik.</p>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev dark-btn"
                        type="button"
                        data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <button class="carousel-control-next dark-btn"
                        type="button"
                        data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <style>
                        .dark-btn {
                            margin-top: 50%;
                            width: 38px;
                            /* lebih kecil */
                            height: 38px;
                            background: rgba(0, 0, 0, 0.4);
                            /* lebih gelap */
                            border-radius: 50%;
                            border: none;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            color: white;
                            font-size: 1.1rem;
                            /* ikon diperkecil */
                            position: absolute;
                            top: 50%;
                            transform: translateY(-50%);
                            z-index: 10;
                            transition: 0.2s ease;
                        }

                        /* tambah jarak, biar makin tidak menyatu */
                        .carousel-control-prev.dark-btn {
                            left: 10px !important;
                        }

                        .carousel-control-next.dark-btn {
                            right: 10px !important;
                        }

                        /* efek hover */
                        .dark-btn:hover {
                            background: rgba(0, 0, 0, 0.95);
                        }
                    </style>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card">
        <div class="card-header pb-0 p-3">
            <h6 class="mb-2">Rekap Kehadiran Anda</h6>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                    <tr>
                        <th class="text-sm">Keterangan</th>
                        <th class="text-center text-sm">Jumlah</th>
                        <th class="text-center text-sm">Keterangan Tambahan</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="w-30">
                            <div class="ms-4">
                                <p class="text-xs font-weight-bold mb-0">Status:</p>
                                <h6 class="text-sm mb-0">Hadir</h6>
                            </div>
                        </td>
                        <td class="text-center">
                            <h6 class="text-sm mb-0">{{ $hadir }}</h6>
                        </td>
                        <td class="text-center">
                            <small class="text-success">(Termasuk hadir & telat)</small>
                        </td>
                    </tr>

                    <tr>
                        <td class="w-30">
                            <div class="ms-4">
                                <p class="text-xs font-weight-bold mb-0">Status:</p>
                                <h6 class="text-sm mb-0">Terlambat</h6>
                            </div>
                        </td>
                        <td class="text-center">
                            <h6 class="text-sm mb-0">{{ $terlambat }}</h6>
                        </td>
                        <td class="text-center">
                            <small class="text-warning">(Total keterlambatan)</small>
                        </td>
                    </tr>

                    <tr>
                        <td class="w-30">
                            <div class="ms-4">
                                <p class="text-xs font-weight-bold mb-0">Status:</p>
                                <h6 class="text-sm mb-0">Tidak Hadir</h6>
                            </div>
                        </td>
                        <td class="text-center">
                            <h6 class="text-sm mb-0">{{ $tidakHadir }}</h6>
                        </td>
                        <td class="text-center">
                            <small class="text-danger">(Alpha + Izin/Sakit)</small>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6>Rekap Kehadiran Bulanan (Progress)</h6>
                </div>
                <div class="card-body p-4">

                    <p class="text-sm mb-1">Hadir: {{ $persenHadirBulanan }}%</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" style="width: {{ $persenHadirBulanan }}%"></div>
                    </div>

                    <p class="text-sm mb-1">Terlambat: {{ $persenTelatBulanan }}%</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-warning" style="width: {{ $persenTelatBulanan }}%"></div>
                    </div>

                    <p class="text-sm mb-1">Tidak Hadir: {{ $persenTidakHadirBulanan }}%</p>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: {{ $persenTidakHadirBulanan }}%"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    </div>

        <style>
            .jadwal-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .jadwal-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
            }
        </style>
    </div>
   
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart-line').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates), // tanggal 7 hari terakhir dari controller
                datasets: [{
                    label: 'Jumlah Hadir',
                    data: @json($hadirMingguan), // data hadir + telat per hari
                    borderWidth: 3,
                    tension: 0.3,
                    borderColor: '#3A416F',
                    backgroundColor: 'rgba(58, 65, 111, 0.15)',
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#3A416F',
                    pointBorderColor: '#fff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection