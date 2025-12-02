@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
    <div class="alert alert-success text-white text-center" id="alertMessage">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">

            <!-- PROFILE CARD -->
            <div class="card card-profile">
                <img src="{{ asset('assets/img/bg-profile.jpg') }}" class="card-img-top" alt="bg">


                <div class="card-body text-center">
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="mb-3 text-sm text-muted">Administrator</p>
                    <p class="text-sm">Email: {{ Auth::user()->email }}</p>
                </div>
            </div>

        </div>

        <!-- EDIT FORM -->
        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="font-weight-bold mb-3">Edit Profile Admin</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                        </div>

                    </div>

                    <button type="submit" class="btn bg-gradient-primary w-100 mt-3">
                        Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    setTimeout(() => {
        let alert = document.getElementById('alertMessage');
        if (alert) alert.style.display = 'none';
    }, 3000);
</script>
@endsection