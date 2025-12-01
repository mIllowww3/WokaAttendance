@extends('layout.app')

@section('content')

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
            <h4 class="mb-0 fw-bold">Data Pegawai</h4>
            <a href="{{ route('admin.pegawai.create') }}" class="btn btn-light btn-sm text-primary fw-bold shadow-sm">
                + Tambah Pegawai
            </a>
        </div>

        <div class="card-body">

            <!-- Search -->
            <form method="GET" class="mb-4">
                <div class="d-flex">
                    <input type="text" name="cari" class="form-control me-3" placeholder="Cari departemen..."
                        value="{{ request('cari') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center" style="background: #f8f9fa; font-weight: bold;">
                        <tr>
                            <th width="5%">No</th>
                            <th>QR</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Departemen</th>
                            <th>Perusahaan</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pegawai as $i => $p)
                        <tr>
                            <td class="text-center fw-bold">{{ $pegawai->firstItem() + $i }}</td>
                            <td class="text-center">
                                @if($p->qr_image)
                                <img src="{{ asset('storage/' . $p->qr_image) }}"
                                    width="60"
                                    class="img-thumbnail">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->user->email ?? '-' }}</td>
                            <td>{{ $p->departemen->nama_departemen ?? '-' }}</td>
                            <td>{{ $p->kantor->nama_kantor ?? '-' }}</td>
                            <td>{{ $p->no_hp ?? '-' }}</td>

                            <td class="text-center">
                                <span class="badge px-3 py-2 {{ $p->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.pegawai.detail', $p->id) }}" class="btn btn-info btn-sm">
                                    Detail & QR
                                </a>

                                <a href="{{ route('admin.pegawai.edit', $p->id) }}"
                                    class="btn btn-warning btn-sm text-white me-1 shadow-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.pegawai.delete', $p->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
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
                            <td colspan="7" class="text-center text-muted py-3">
                                Belum ada data pegawai.
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

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $pegawai->links() }}
            </div>

        </div>
    </div>

</div>

@endsection