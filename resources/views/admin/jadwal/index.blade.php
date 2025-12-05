@extends('layout.app')

@section('content')

@section('title', 'Jadwal Pegawai')


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
            <h4 class="mb-0 fw-bold">Jadwal Kerja</h4>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-light btn-sm text-primary fw-bold shadow-sm">
                + Tambah Jadwal
            </a>
        </div>

        <div class="card-body">

            <!-- Search -->
            <form method="GET" class="mb-4">
                <div class="d-flex">
                    <input type="text" name="cari" class="form-control me-3" placeholder="Cari Jadwal..."
                        value="{{ request('cari') }}">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-primary ms-2"><i class="fa fa-refresh"></i></a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center" style="background: #f8f9fa; font-weight: bold;">
                        <tr>
                            <th width="5%">No</th>
                            <th>Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jadwal as $i => $j)
                        <tr>
                            <td class="text-center fw-bold">{{ $jadwal->firstItem() + $i }}</td>
                            <td class="text-center">{{ $j->hari }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($j->jam_pulang)->format('H:i') }}</td>

                            <td class="text-center">

                                <a href="{{ route('admin.jadwal.edit', $j->id) }}"
                                    class="btn btn-warning btn-sm text-white me-1 shadow-sm m-0">
                                    Edit
                                </a>

                                <form action="{{ route('admin.jadwal.destroy', $j->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm shadow-sm m-0">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada data jadwal kerja.
                            </td>
                        </tr>
                        @endforelse
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
            <div class="mt-3">
                {{ $jadwal->links() }}
            </div>

        </div>
    </div>

</div>

@endsection