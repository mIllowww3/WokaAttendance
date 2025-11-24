<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Departemen</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table thead th {
            background: #0e0b0bff;
            color: #fff;
            text-transform: uppercase;
        }
        .card-header h4 {
            font-weight: bold;
        }
    </style>

</head>
<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Departemen</h4>
                <a href="{{ route('departemen.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    + Tambah Departemen
                </a>
            </div>

            <div class="card-body">

                <!-- Search -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control" placeholder="Cari departemen..."
                               value="{{ request('cari') }}">
                        <button class="btn btn-primary">Cari</button>
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
                                        <a href="{{ route('departemen.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm text-white">
                                            Edit
                                        </a>

                                        <form action="{{ route('departemen.destroy', $item->id) }}" 
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

</body>
</html>
