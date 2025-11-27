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

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-gray d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Perusahaan</h4>
            <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-light text-primary fw-bold btn-sm">
                + Tambah Perusahaan
            </a>
        </div>

        <div class="card-body">

            <!-- Search -->
            <form method="GET" class="mb-4">
                <div class="d-flex">
                    <input type="text" name="cari" class="form-control me-3" placeholder="Cari Perusahaan..."
                        value="{{ request('cari') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

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
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.perusahaan.edit', $p->id) }}"
                                        class="btn btn-warning btn-sm text-white fw-bold">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.perusahaan.destroy', $p->id) }}"
                                        method="POST"
                                        class="m-0 p-0"
                                        style="display: inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT UNTUK ALERT OTOMATIS HILANG DENGAN FADE OUT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-message');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah fade
            }, 5000); // 5 detik tampil
        }
    });
</script>

@endsection