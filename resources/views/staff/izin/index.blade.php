@extends('layout.app')

@section('title', 'Data Izin')

@section('content')

<style>
    .table-bordered> :not(caption)>*>* {
        border-width: 1px !important;
    }
</style>

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
            <h4 class="mb-0">Data Izin & Sakit</h4>

            <a href="{{ route('staff.izin.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                + Tambah Data
            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $izin)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $izin->pegawai->user->name ?? '-' }}</td>

                            <td class="text-center">
                                <span class="badge {{ $izin->jenis == 'izin' ? 'bg-info' : 'bg-warning' }}">
                                    {{ ucfirst($izin->jenis) }}
                                </span>
                            </td>

                            <td class="text-center">
                                {{ $izin->tanggal_mulai }} <br>
                                s/d {{ $izin->tanggal_selesai }}
                            </td>

                            <td>{{ Str::limit($izin->alasan, 40) }}</td>

                            <td class="text-center">
                                @if ($izin->lampiran)
                                <a href="{{ asset('storage/'.$izin->lampiran) }}"
                                    class="btn btn-sm btn-secondary"
                                    target="_blank">
                                    Lihat
                                </a>
                                @else
                                -
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge 
                                    @if ($izin->status == 'pending') bg-secondary
                                    @elseif ($izin->status == 'disetujui') bg-success
                                    @else bg-danger @endif">
                                    {{ ucfirst($izin->status) }}
                                </span>
                            </td>

                            <td class="text-center">{{ $izin->approver->name ?? '-' }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    @if ($izin->status == 'pending')

                                    <a href="{{ route('staff.izin.edit', $izin->id) }}"
                                        class="btn btn-warning btn-sm text-white m-0">
                                        Edit
                                    </a>

                                    <form action="{{ route('staff.izin.destroy', $izin->id) }}"
                                        method="POST"
                                        class="m-0 p-0 d-inline"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm m-0">
                                            Hapus
                                        </button>
                                    </form>

                                    @else
                                    <button class="btn btn-secondary btn-sm m-0" disabled>
                                        Selesai
                                    </button>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>

                <script>
                    setTimeout(() => {
                        let alert = document.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 3000);
                </script>

            </div>

        </div>
    </div>

</div>

@endsection