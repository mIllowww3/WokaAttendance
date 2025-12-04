<!DOCTYPE html>
<html lang="en">

<style>
  body {
    background: linear-gradient(135deg, #353A5F 0%, #9EBAF3 100%);
    min-height: 100vh;
  }

  .login-box {
    margin-top: 120px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(4px);
    border-radius: 20px;
    padding: 25px;
  }

  .custom-input input {
    background: rgba(255,255,255,0.15);
    border-radius: 30px;
    color: white;
  }

  .custom-input input::placeholder {
    color: #dcdcdc;
  }

  .icon-left, .icon-right {
    color: white;
  }

  .btn-login {
    background: white;
    color: #2f2f2f;
    border-radius: 30px;
  }

  .title-login h4,
  .title-login p {
    color: white !important;
  }
  /* Hapus pengaruh layout Argon */
.main-content, 
.page-header {
  padding: 0 !important;
  margin: 0 !important;
  min-height: 0 !important;
  background: none !important;
}

/* Wrapper baru untuk center login */
.login-wrapper {
  min-height: 100vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #353A5F 0%, #9EBAF3 100%);
  padding: 0;
  margin: 0;
}

/* Card login glass */
.login-box {
  width: 380px;
  padding: 35px 30px;
  border-radius: 28px;
  background: linear-gradient(135deg,
      rgba(255, 255, 255, 0.38) 0%,
      rgba(255, 255, 255, 0.18) 100%);
  backdrop-filter: blur(12px);
  box-shadow: 0 18px 40px rgba(0,0,0,0.25);
  color: white;
}

</style>

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
          <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-5 col-md-7 flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">

<div class="card login-box shadow-none border-0">

  <div class="card-body text-center title-login">
    <h4 class="font-weight-bolder mb-1">USER LOGIN</h4>
  </div>

  <div class="card-body mt-4">

    @if($errors->any())
      <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <!-- Username / Email -->
      <div class="custom-input mb-3">
        <i class="fa fa-user icon-left"></i>
        <input type="email" name="email" value="{{ old('email') }}"
          placeholder="Username" class="form-control">
      </div>
      @error('email')
      <div class="text-danger small">{{ $message }}</div>
      @enderror

      <!-- Password -->
      <div class="custom-input mb-4">
        <i class="fa fa-lock icon-left"></i>
        <i class="fa fa-eye-slash icon-right"></i>
        <input type="password" name="password"
          placeholder="Password" class="form-control">
      </div>
      @error('password')
      <div class="text-danger small">{{ $message }}</div>
      @enderror

      <button type="submit" class="btn btn-login w-100">LOGIN</button>
    </form>

  </div>
</div>

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