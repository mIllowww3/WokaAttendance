@extends('layout.app')

@section('content')

@section('title', 'Absen')


<div class="container mt-5">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="alert-message">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" id="alert-message">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Absen Pegawai</h4>
        </div>

        <div class="card-body">

            {{-- FILTER --}}
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="cari" class="form-control" placeholder="Cari nama pegawai..."
                            value="{{ request('cari') }}">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                            <th>Jarak Masuk</th>
                            <th>Jarak Pulang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 1; @endphp

                        @foreach ($absens as $a)
                        <tr>
                            <td class="text-center fw-bold">{{ $no++ }}</td>
                            <td>{{ $a->pegawai->user->name ?? '-' }}</td>
                            <td class="text-center">{{ $a->tanggal }}</td>
                            <td class="text-center">
                                {{ $a->jam_masuk ?? '-' }} <br>
                                <small class="text-muted">{{ $a->lokasi_masuk }}</small>
                            </td>
                            <td class="text-center">
                                {{ $a->jam_pulang ?? '-' }} <br>
                                <small class="text-muted">{{ $a->lokasi_pulang }}</small>
                            </td>

                            <td class="text-center">
                                @php
                                $warna = [
                                'hadir' => 'success',
                                'telat' => 'danger',
                                'izin' => 'warning',
                                'sakit' => 'info',
                                'alpha' => 'danger',
                                ];
                                @endphp

                                <span class="badge bg-{{ $warna[$a->status] ?? 'secondary' }}">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>

                            <td class="text-center">{{ $a->jarak_masuk ? $a->jarak_masuk.' m' : '-' }}</td>
                            <td class="text-center">{{ $a->jarak_pulang ? $a->jarak_pulang.' m' : '-' }}</td>

                            <td class="text-center">
                                {{-- BUKA MODAL --}}
                                <button class="btn btn-info btn-sm text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $a->id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @foreach ($absens as $a)
                <div class="modal fade" id="detailModal{{ $a->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Detail Absen Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Nama Pegawai</th>
                                        <td>{{ $a->pegawai->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>{{ $a->tanggal }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jam Masuk</th>
                                        <td>
                                            {{ $a->jam_masuk ?? '-' }} <br>
                                            <small class="text-muted">{{ $a->lokasi_masuk }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jam Pulang</th>
                                        <td>
                                            {{ $a->jam_pulang ?? '-' }} <br>
                                            <small class="text-muted">{{ $a->lokasi_pulang }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-{{ $warna[$a->status] ?? 'secondary' }}">
                                                {{ ucfirst($a->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jarak Masuk</th>
                                        <td>{{ $a->jarak_masuk ? $a->jarak_masuk.' m' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jarak Pulang</th>
                                        <td>{{ $a->jarak_pulang ? $a->jarak_pulang.' m' : '-' }}</td>
                                    </tr>
                                </table>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>

</div>

{{-- ALERT AUTO CLOSE --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-message');
        if (alert) {
            setTimeout(() => {
                alert.classList.remove('show');
            }, 5000);
        }
    });
</script>
@endsection

@endsection