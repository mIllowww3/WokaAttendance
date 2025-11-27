@extends('layout.app')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mt-4">Data Izin & Sakit</h3>

        {{-- TOMBOL TAMBAH --}}
        <a href="{{ route('staff.izin.create') }}" class="btn btn-primary">
            + Tambah Data
        </a>
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
                            <th>#</th>
                            <th>Pegawai</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th width="150px">Aksi</th>
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
                                {{ $izin->tanggal_mulai }} <br>
                                s/d {{ $izin->tanggal_selesai }}
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
                                <span class="badge 
                                    @if ($izin->status == 'pending') bg-secondary
                                    @elseif ($izin->status == 'disetujui') bg-success
                                    @else bg-danger @endif">
                                    {{ ucfirst($izin->status) }}
                                </span>
                            </td>

                            <td>{{ $izin->approver->name ?? '-' }}</td>

                            <td>

    {{-- Jika pending → tampilkan Edit + Hapus --}}
    @if ($izin->status == 'pending')

        <a href="{{ route('staff.izin.edit', $izin->id) }}" 
           class="btn btn-sm btn-warning mb-1">
            Edit
        </a>

        <form action="{{ route('staff.izin.destroy', $izin->id) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('Hapus data ini?')">
            @csrf 
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
                Hapus
            </button>
        </form>

    @else
        {{-- Jika disetujui atau ditolak → tombol jadi Selesai / disabled --}}
        <button class="btn btn-sm btn-secondary" disabled>
            Selesai
        </button>
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
