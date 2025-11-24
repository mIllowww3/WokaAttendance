<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Woka Dashboard - Login</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 ">
              Woka Attendance
            </a>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>

  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">

            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">

                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>

                <div class="card-body">
                  <form method="POST" action="{{ url('/login') }}" role="form" class="text-start">
                    @csrf
                    <div class="input-group input-group-outline my-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control">
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign in</button>
                    </div>
                    <p class="mt-4 text-sm text-center">
                      Don't have an account?
                      <a href="" class="text-primary text-gradient font-weight-bold">Sign up</a>
                    </p>
                  </form>
                </div>

              </div>
            </div>

            <!-- RIGHT SIDE IMAGE -->
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute 
                top-0 end-0 text-center justify-content-center flex-column">

              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg 
                  d-flex flex-column justify-content-center overflow-hidden"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
                background-size: cover;">

                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                  "Attendance Made Simple"
                </h4>
                <p class="text-white position-relative">
                  Woka Attendance — Smart, Accurate, Real-time Attendance Tracking.
                </p>
              </div>

            </div>

          </div>
        </div>
      </div>
    </section>
  </main>


  <!-- Core JS -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

</body>

</html>