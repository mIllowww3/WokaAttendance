@extends('layout.app')

@section('content')

<div class="container mt-5">

    {{-- NOTIFIKASI BERHASIL / ERROR --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-message">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Absen Pegawai</h4>
        </div>

        <div class="card-body">

            {{-- FILTER PENCARIAN --}}
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="cari" class="form-control"
                            placeholder="Cari nama pegawai..."
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
                            <th width="5%">No</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                            <th>Jarak Masuk</th>
                            <th>Jarak Pulang</th>
                            <th width="10%">Aksi</th>
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
                                {{ $a->jam_masuk ?? '-' }}
                                <br>
                                <small class="text-muted">{{ $a->lokasi_masuk }}</small>
                            </td>
                            <td class="text-center">
                                {{ $a->jam_pulang ?? '-' }}
                                <br>
                                <small class="text-muted">{{ $a->lokasi_pulang }}</small>
                            </td>
                            <td class="text-center">
                                @php
                                $warna = [
                                'hadir' => 'success',
                                'izin' => 'warning',
                                'sakit' => 'info',
                                'alpha' => 'danger',
                                ];
                                @endphp

                                <span class="badge bg-{{ $warna[$a->status] }} px-3 py-2">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $a->jarak_masuk ? $a->jarak_masuk.' m' : '-' }}
                            </td>
                            <td class="text-center">
                                {{ $a->jarak_pulang ? $a->jarak_pulang.' m' : '-' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('absen.show', $a->id) }}" class="btn btn-info btn-sm text-white">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($absens) == 0)
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Belum ada data absen.
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>

            </div>

        </div>
    </div>

</div>

{{-- SCRIPT UNTUK ALERT OTOMATIS HILANG --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-message');
        if (alert) {
            // Menghilangkan alert setelah 5 detik
            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('hide');
            }, 5000);
        }
    });
</script>
@endsection

@endsection