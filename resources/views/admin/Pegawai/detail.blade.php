@extends('layout.app')

@section('content')

@section('title', 'Detail Pegawai')

<div class="container-fluid py-4">

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-lg border-0">

                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h4 class="mb-0">Detail Pegawai</h4>
                </div>

                <div class="card-body">

                    <h5 class="text-center mb-3">{{ $pegawai->nama }}</h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>Departemen</th>
                            <td>{{ $pegawai->departemen->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>UID</th>
                            <td>{{ $pegawai->uid }}</td>
                        </tr>
                    </table>

                    <hr>

                    <h5 class="text-center mt-3">QR Code Absen</h5>

                    <div class="text-center mt-3">
                        @if(isset($qrBase64))
                            <img src="data:image/png;base64,{{ $qrBase64 }}" width="250">
                        @else
                            <p class="text-danger">QR Code tidak tersedia.</p>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
