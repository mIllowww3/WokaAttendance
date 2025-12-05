<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Woka Attendance - @yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-woka.png') }}">


    <!-- Fonts and icon -->
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
        /* --- MAP --- */
        #map {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* --- SIDEBAR --- */
        .sidenav {
            font-size: 14px;
            padding-top: 10px;
        }

        /* --- NORMAL STATE (PUTIH) --- */
        .sidenav .navbar-nav .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            padding: 12px 18px !important;
            margin: 5px 0 !important;
            border-radius: 12px !important;
            transition: all 0.25s ease-in-out !important;
            font-weight: 600 !important;
            color: #444 !important;
            background: #ffffff;
            /* default tetap putih */
            backdrop-filter: blur(4px);
            box-shadow:
                inset 1px 1px 2px rgba(255, 255, 255, 0.6),
                0 1px 3px rgba(0, 0, 0, 0.04);
        }

        /* --- ICON NORMAL --- */
        .sidenav .nav-link .icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #f5f5f5, #dedede);
            border-radius: 12px;
            font-size: 22px;
            transition: 0.3s ease;
            color: #ffffff;
            box-shadow:
                inset 1px 1px 3px rgba(255, 255, 255, 0.7),
                inset -2px -2px 6px rgba(0, 0, 0, 0.05);
        }

        /* --- HOVER --- */
        .sidenav .navbar-nav .nav-link:hover {
            background: #f7f7f7 !important;
            transform: translateX(4px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        /* --- ACTIVE: lebih gelap lagi --- */
        .sidenav .nav-link.active {
            background: linear-gradient(135deg, #acacac, #c8c8c8) !important;
            /* lebih gelap */
            color: #1f1f1f !important;
            transform: translateX(4px);
            box-shadow:
                0 4px 14px rgba(0, 0, 0, 0.22),
                inset 1px 1px 6px rgba(255, 255, 255, 0.62),
                inset -2px -2px 9px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .sidenav .nav-link.active .icon {
            background: linear-gradient(135deg, #ffffff, #f7f7f7);
            color: #333 !important;
            box-shadow:
                inset 1px 1px 4px rgba(255, 255, 255, 0.85),
                inset -2px -2px 6px rgba(0, 0, 0, 0.04);
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

        <!-- <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main"> -->
        <div>
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
            
                <!-- <li class="nav-item d-flex align-items-center">
                    <a href="{{ auth()->user()->role=='admin' ? route('admin.profile.index') : route('staff.profile.index') }}"
                        class="nav-link text-white font-weight-bold px-0">
                        <i class="ni ni-single-02 me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                    </a>
                </li> -->


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
                    <a class="nav-link {{ request()->routeIs('staff.izin.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('staff.izin.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Izin</span>
                    </a>
                </li>

                @endif

                <!-- LOGOUT -->
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <button type="submit"
                                class="btn w-80 px-3 py-2 bg-gradient-danger text-white border-0"
                                onclick="return confirm('apakah anda ingin logout?')">
                                <i class="ni ni-button-power me-3"></i> Logout
                            </button>
                        </div>
                    </form>
                </li>

            </ul>
        </div>
    </aside>
    <!-- END SIDEBAR -->

    <!-- MAIN CONTENT -->
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('title')</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">@yield('title')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ auth()->user()->role == 'admin' ? route('admin.profile.index') : route('staff.profile.index') }}"
                                class="nav-link text-white font-weight-bold px-0">
                                <i class="ni ni-single-02 me-sm-1"></i>
                                <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">

            @yield('content')
            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Batanghari Pride</a>
                                for a better web.
                            </div>
                        </div>
                         
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <!-- JS -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>

    @yield('scripts')

</body>

</html>