@extends('layout.app')

@section('content')

<div class="container mt-4">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white fw-bold">
                Tambah Departement
            </div>

            <div class="card-body">
                <form action="{{ route('admin.departemen.store') }}" method="POST">
                    @csrf

                    <!-- Nama Departemen -->
                    <div class="mb-3">
                        <label class="form-label">Nama Departemen</label>
                        <input type="text" class="form-control" name="nama_departemen">
                        @error('nama_departemen')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="4"></textarea>
                    </div>
                    @error('deskripsi')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <!-- Tombol -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.departemen.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

</div>
@endsection