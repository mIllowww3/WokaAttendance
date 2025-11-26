@extends('layout.app')


@section('content')


    <div class="container mt-5">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-gray d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Perusahaan</h4>

                <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-light text-primary fw-bold btn-sm">
                    + Tambah Perusahaan
                </a>
            </div>

            <div class="card-body">

                <!-- Table -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Kantor</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Radius (m)</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($perusahaan as $index => $p)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $p->nama_kantor }}</td>
                                <td>{{ $p->latitude }}</td>
                                <td>{{ $p->longitude }}</td>
                                <td>{{ $p->radius }} m</td>
                                <td>{{ $p->alamat }}</td>

                                <td class="text-center">
                                    @if ($p->status == 'aktif')
                                    <span class="badge-status badge-aktif">Aktif</span>
                                    @else
                                    <span class="badge-status badge-nonaktif">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    <!-- Edit -->
                                    <a href="{{ route('admin.perusahaan.edit', $p->id) }}" class="btn btn-warning btn-sm text-white fw-bold">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.perusahaan.destroy', $p->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Tidak ada data perusahaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection