@extends('layout.app')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mt-4">Data Izin & Sakit</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $izin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $izin->pegawai->user->name ?? '-' }}</td>

                            <td>
                                <span class="badge 
                                    {{ $izin->jenis == 'izin' ? 'bg-info' : 'bg-warning' }}">
                                    {{ ucfirst($izin->jenis) }}
                                </span>
                            </td>

                            <td>
                                {{ $izin->tanggal_mulai }} s/d <br>
                                {{ $izin->tanggal_selesai }}
                            </td>

                            <td>{{ Str::limit($izin->alasan, 40) }}</td>

                            <td>
                                @if ($izin->lampiran)
                                <a href="{{ asset('storage/'.$izin->lampiran) }}"
                                    class="btn btn-sm btn-secondary" target="_blank">
                                    Lihat
                                </a>
                                @else
                                -
                                @endif
                            </td>

                            <td>
                                @if ($izin->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>

                                @elseif ($izin->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>

                                @else
                                <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>{{ $izin->approver->name ?? '-' }}</td>

                            <td>

                                {{-- Hanya tampil jika status masih pending --}}
                                @if ($izin->status == 'pending')

                                {{-- SETUJUI --}}
                                <form action="{{ route('admin.izin.approve', $izin->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success mb-1">
                                        Setujui
                                    </button>
                                </form>

                                {{-- TOLAK --}}
                                <form action="{{ route('admin.izin.reject', $izin->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger mb-1">
                                        Tolak
                                    </button>
                                </form>

                                @endif

                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection