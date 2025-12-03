@extends('layout.app')

@section('content')

@section('title', 'Data Izin')


<div class="container mt-5">

    <div class="card shadow border-0">

        {{-- HEADER SAMA TEMANYA --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Data Izin & Sakit</h4>
        </div>

        <div class="card-body">

            @if (session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-3">
                {{ session('success') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center" style="background: #f8f9fa; font-weight: bold;">
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
                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>

                            <td class="text-center">{{ $izin->pegawai->user->name ?? '-' }}</td>

                            <td class="text-center">
                                <span class="badge 
                                    {{ $izin->jenis == 'izin' ? 'bg-info' : 'bg-warning' }}">
                                    {{ ucfirst($izin->jenis) }}
                                </span>
                            </td>

                            <td class="text-center">
                                {{ $izin->tanggal_mulai }} s/d <br>
                                {{ $izin->tanggal_selesai }}
                            </td>

                            <td>{{ Str::limit($izin->alasan, 40) }}</td>

                            <td class="text-center">
                                @if ($izin->lampiran)
                                <a href="{{ asset('storage/'.$izin->lampiran) }}"
                                    class="btn btn-sm btn-secondary shadow-sm" target="_blank">
                                    Lihat
                                </a>
                                @else
                                -
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($izin->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>

                                @elseif ($izin->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>

                                @else
                                <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td class="text-center">{{ $izin->approver->name ?? '-' }}</td>

                            <td class="text-center">

                                @if ($izin->status == 'pending')

                                <form action="{{ route('admin.izin.approve', $izin->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success shadow-sm mb-1">
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.izin.reject', $izin->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger shadow-sm mb-1">
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