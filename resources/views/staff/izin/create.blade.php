@extends('layout.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Izin / Sakit</h4>

    <form action="{{ route('admin.izin.store') }}" method="POST" enctype="multipart/form-data">
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

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="{{ route('admin.izin.index') }}" class="btn btn-secondary mt-3">Kembali</a>

    </form>
</div>
@endsection
