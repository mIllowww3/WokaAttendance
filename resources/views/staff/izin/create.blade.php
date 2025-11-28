@extends('layout.app')

@section('content')

<div class="container mt-4">
 @if ($errors->has('tanggal_mulai'))
<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
    <i class="ni ni-fat-remove me-2"></i>
    <div>
        <strong>Gagal!</strong> {{ $errors->first('tanggal_mulai') }}
    </div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Tambah Izin / Sakit
        </div>

        <div class="card-body">

            <form action="{{ route('staff.izin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Jenis Izin --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="jenis" class="form-control" required>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                        </select>
                    </div>

                    {{-- Pegawai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pegawai</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-control" required>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-control" required>
                    </div>

                    {{-- Alasan --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alasan</label>
                        <textarea name="alasan" class="form-control" rows="3" required>{{ old('alasan') }}</textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" name="lampiran" class="form-control" accept="image/*,pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF</small>
                    </div>

                </div>

                <button class="btn btn-success mt-3">Simpan</button>
                <a href="{{ route('staff.izin.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>
</div>

@endsection
