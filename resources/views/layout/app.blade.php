<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Woka Attendance</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- CSS -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet">
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet">

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        #map {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            margin-top: 15px;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">

    <div class="min-height-300 bg-dark position-absolute w-100"></div>

    <!-- SIDEBAR -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main">

        <div class="sidenav-header">
            <a class="navbar-brand m-0" href="#">
                <img src="{{ asset('assets/img/logo-woka.png') }}" width="45" class="navbar-brand-img h-100">
                <span class="ms-1 font-weight-bold">Woka Attendance</span>
            </a>
        </div>

        <hr class="horizontal dark mt-0">

        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">

                <!-- ===================================================================== -->
                <!-- ========================== MENU ADMIN =============================== -->
                <!-- ===================================================================== -->

                @if(auth()->user()->role == 'admin')

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.dashboard') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-tv-2 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.departemen.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.departemen.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-building text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Departemen</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.perusahaan.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.perusahaan.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-briefcase-24 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Perusahaan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.pegawai.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-single-02 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.jadwal.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-calendar-grid-58 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Jadwal</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.izin.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.izin.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-single-copy-04 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Izin</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.absen.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.absen.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-check-bold text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Absen</span>
                    </a>
                </li>

                @endif

                <!-- ===================================================================== -->
                <!-- ========================== MENU STAFF =============================== -->
                <!-- ===================================================================== -->

                @if(auth()->user()->role == 'staff')

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : 'text-dark' }}"
                        href="{{ route('staff.dashboard') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-tv-2 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.absen.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('staff.absen.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-calendar-grid-58 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Absen</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.izin.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Izin</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.profile.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-app text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>

                @endif

                <!-- LOGOUT -->
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="btn w-100 px-3 py-2 bg-gradient-danger text-white border-0">
                            <i class="ni ni-button-power me-3"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </aside>
    <!-- END SIDEBAR -->

    <!-- MAIN CONTENT -->
    <main class="main-content position-relative border-radius-lg">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>

</body>
</html>
