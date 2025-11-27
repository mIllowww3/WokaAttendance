@extends('layout.app')

@section('content')
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
                            <a href="" class="text-primary small">Lihat Absen</a>
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
    <div class="row mt-4">
    </div>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>2025,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection