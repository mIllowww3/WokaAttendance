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
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- CAROUSEL -->
        <div class="col-lg-5">
            <div class="card card-carousel overflow-hidden h-100 p-0">
                <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner border-radius-lg h-100">

                        <div class="carousel-item h-100 active" style="background-image: url('../assets/img/carousel-1.jpg'); background-size: cover;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-qr-code text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-white mb-1">Absensi QR-Code</h5>
                                <p>Presensi cepat dan akurat dengan scan QR Pegawai.</p>
                            </div>
                        </div>

                        <div class="carousel-item h-100" style="background-image: url('../assets/img/carousel-2.jpg'); background-size: cover;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-pin-3 text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-white mb-1">Presensi Lokasi (Radius)</h5>
                                <p>Validasi kehadiran berdasarkan titik kantor.</p>
                            </div>
                        </div>

                        <div class="carousel-item h-100" style="background-image: url('../assets/img/carousel-3.jpg'); background-size: cover;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-chart-bar-32 text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-white mb-1">Analitik Kehadiran</h5>
                                <p>Pantau performa kehadiran pegawai dengan grafik.</p>
                            </div>
                        </div>

                    </div>

                    <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>

                    <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>

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
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </button>
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
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </button>
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
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark">
                                <i class="ni ni-bold-right"></i>
                            </button>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>


    <!-- TAMBAHAN: TOP 5 -->
    <div class="row mt-4">
        <!-- Pegawai Paling Rajin -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6>Pegawai Paling Rajin (Top 5)</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        <li class="list-group-item">1. Wahyu Pratama — 0x terlambat</li>
                        <li class="list-group-item">2. Siti Aminah — 1x terlambat</li>
                        <li class="list-group-item">3. Rudi Hartono — 1x terlambat</li>
                        <li class="list-group-item">4. Budi Santoso — 2x terlambat</li>
                        <li class="list-group-item">5. Lina Kartika — 2x terlambat</li>
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
                        <li class="list-group-item">1. Doni Wibowo — 8x terlambat</li>
                        <li class="list-group-item">2. Arif Saputra — 7x terlambat</li>
                        <li class="list-group-item">3. Fajar Gunawan — 6x terlambat</li>
                        <li class="list-group-item">4. Eka Permata — 6x terlambat</li>
                        <li class="list-group-item">5. Sari Dewi — 5x terlambat</li>
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

                    <p class="text-sm mb-1">Hadir: 84%</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" style="width: 84%"></div>
                    </div>

                    <p class="text-sm mb-1">Terlambat: 12%</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-warning" style="width: 12%"></div>
                    </div>

                    <p class="text-sm mb-1">Tidak Hadir: 4%</p>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 4%"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @endsection