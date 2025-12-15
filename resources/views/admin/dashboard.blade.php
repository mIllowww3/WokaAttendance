@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <!-- CARD 1: Pegawai Hadir Hari Ini -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">    
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Hadir Hari Ini</p>
                            <h5 class="font-weight-bolder">{{ $hadir }} Pegawai</h5>
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">{{ $hadirPersen }}%</span> dari kemarin
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-single-02 text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <!-- CARD 2: Pegawai Terlambat -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Terlambat</p>
                            <h5 class="font-weight-bolder">{{ $terlambat }} Pegawai</h5>
                            <p class="mb-0">
                                <span class="text-danger text-sm font-weight-bolder">{{ $terlambatPersen }}%</span> minggu ini
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                            <i class="ni ni-time-alarm text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD 3: Izin / Sakit / Alpha -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Izin / Sakit / Alpha</p>
                            <h5 class="font-weight-bolder">{{ $izinSakitAlpha }} Pegawai</h5>
                            <p class="mb-0">
                                <span class="text-warning text-sm font-weight-bolder">{{ $izinSakitAlphaPersen }}%</span> hari ini
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-user-run text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD 4: Total Scan QR -->
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Scan QR Hari Ini</p>
                            <h5 class="font-weight-bolder">{{ $scan }} Scan</h5>
                            <p class="mb-0">
                                <span class="text-success text-sm font-weight-bolder">{{ $scanPersen }}%</span> dari kemarin
                            </p>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-qr-code text-lg opacity-10"></i>
                        </div>
                    </div>
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
    </div>

    <!-- TABEL REKAP DEPARTEMEN + Tambahan Statistik -->
    <div class="row mt-4">
        <!-- REKAP DEPARTEMEN -->
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-2">Rekap Kehadiran Per Departemen</h6>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th class="text-sm">Departemen</th>
                                <th class="text-center text-sm">Hadir</th>
                                <th class="text-center text-sm">Terlambat</th>
                                <th class="text-center text-sm">Tidak Hadir</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="w-30">
                                    <div class="ms-4">
                                        <p class="text-xs font-weight-bold mb-0">Departemen:</p>
                                        <h6 class="text-sm mb-0">Administrasi</h6>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-sm mb-0">14</h6>
                                    <small class="text-success">(Pegawai hadir)</small>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-sm mb-0">3</h6>
                                    <small class="text-warning">(Pegawai terlambat)</small>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-sm mb-0">1</h6>
                                    <small class="text-danger">(Izin / Sakit / Alpha)</small>
                                </td>
                            </tr>

                            <!-- Baris departemen lain tetap sama -->
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- MENU CEPAT -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Menu Cepat</h6>
                </div>

                <div class="card-body p-3">
                    <ul class="list-group">

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="ni ni-badge text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Kartu Presensi Pegawai</h6>
                                    <span class="text-xs">Lihat atau unduh QR Card Pegawai</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </a>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="ni ni-pin-3 text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Pengaturan Lokasi Kantor</h6>
                                    <span class="text-xs">Radius titik presensi</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </a>
                        </li>

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="ni ni-calendar-grid-58 text-white opacity-10"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Laporan Absensi Pegawai</h6>
                                    <span class="text-xs">Harian, mingguan, bulanan</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.absen.index') }}" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- TOP 5 -->
    <div class="row mt-4">
        <!-- Pegawai Paling Rajin -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6>Pegawai Paling Rajin (Top 5)</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        @forelse($topRajin as $i => $row)
                        <li class="list-group-item">
                            {{ $i+1 }}.
                            {{ $row->user->name ?? 'Tidak diketahui' }}
                            — {{ $row->total_telat }}x terlambat
                        </li>
                        @empty
                        <li class="list-group-item">Belum ada data terlambat</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pegawai Sering Terlambat -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6>Pegawai Sering Terlambat (Top 5)</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        @forelse($topTerlambat as $i => $row)
                        <li class="list-group-item">
                            {{ $i+1 }}.
                            {{ $row->user->name ?? 'Tidak diketahui' }}
                            — {{ $row->total_telat }}x terlambat
                        </li>
                        @empty
                        <li class="list-group-item">Belum ada data terlambat</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- PROGRESS BULANAN -->
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