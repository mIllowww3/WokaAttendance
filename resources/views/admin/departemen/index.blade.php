@extends('layout.app')

@section('content')

@section('title', 'Departemen')

<body class="bg-light">

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
                <h4 class="mb-0">Data Departemen</h4>
                <a href="{{ route('admin.departemen.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    + Tambah Departemen
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


                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Nama Departemen</th>
                                <th>Deskripsi</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($departemen as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $item->nama_departemen }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('admin.departemen.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm text-white">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.departemen.destroy', $item->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            class="m-0 p-0"
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
                                <td colspan="4" class="text-center text-muted">Tidak ada data departemen.</td>
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
        setTimeout(() => {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);
    </script>

</body>
@endsection