@extends('layout.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Jadwal Kerja</h4>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-light btn-sm text-primary fw-bold shadow-sm">
                + Tambah Jadwal
            </a>
        </div>

        <div class="card-body">

            <form method="GET" class="mb-4">
                <div class="d-flex">
                    <input type="text" name="cari" class="form-control me-3" placeholder="Cari departemen..."
                        value="{{ request('cari') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
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
                                    class="btn btn-warning btn-sm text-white me-1 shadow-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.jadwal.destroy', $j->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm shadow-sm">
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
            </div>

            <div class="mt-3">
                {{ $jadwal->links() }}
            </div>

        </div>
    </div>

</div>

@endsection