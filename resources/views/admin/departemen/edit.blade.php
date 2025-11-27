@extends('layout.app')

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card shadow-lg border-0">
                    <div class="card-header text-white bg-primary">
                        <h4 class="mb-0">Edit Departemen</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.departemen.update', $departemen->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Departemen -->
                            <div class="mb-3">
                                <label class="form-label">Nama Departemen</label>
                                <input type="text" 
                                    class="form-control" 
                                    name="nama_departemen" 
                                    value="{{ $departemen->nama_departemen }}" 
                                    required>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="4">{{ $departemen->deskripsi }}</textarea>
                            </div>

                            <!-- Tombol -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.departemen.index') }}" class="btn btn-secondary">
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-warning text-white">
                                    Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection