<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Woka Attendance - @yield('title')</title>

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
<<<<<<< HEAD
        #map {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            margin-top: 15px;
        }
        /* --- Sidebar Layout Fix --- */
        .sidenav .navbar-nav .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 10px 18px !important;
            border-radius: 10px !important;
            margin: 4px 0 !important;
            transition: 0.25s ease-in-out !important;
=======
        .sidenav .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            font-size: 17px;
>>>>>>> 5de1f576461aaf584ac43a90a9d7d2859c2e7c54
        }


        .sidenav .nav-link .icon {
            width: 45px;
            height: 42px;
            min-width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            border-radius: 10px;
            font-size: 25px;
        }


        .sidenav .nav-link .nav-link-text {
            font-size: 15px;
            font-weight: 600;
            margin-left: 14px;
        }

        /* --- Active Menu --- */
        .sidenav .nav-link.active {
            background: linear-gradient(135deg, #5e72e4, #825ee4) !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(250, 250, 253, 1);
        }

        .sidenav .nav-link.active i {
            color: white !important;
        }

        /* Optional: Smooth font for sidebar */
        .sidenav {
            font-size: 14px;
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
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('admin.profile.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-single-02 me-sm-1 text-dark opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
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

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('staff.profile.*') ? 'active' : 'text-dark' }}"
                        href="{{ route('staff.profile.index') }}">
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
                        <div class="row justify-content-center">
                            <button type="submit"
                                class="btn w-80 px-3 py-2 bg-gradient-danger text-white border-0">
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
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ auth()->user()->role == 'admin' ? route('admin.profile.index') : route('staff.profile.index') }}"
                                class="nav-link text-white font-weight-bold px-0">
                                <i class="ni ni-single-02 me-sm-1"></i>
                                <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                            </a>
                        </li>

                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')
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