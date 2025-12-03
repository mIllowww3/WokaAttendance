@extends('layout.app')

@section('content')

@section('title', 'Edit Izin')

<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
            <i class="ni ni-fat-remove me-2"></i>
            <div>
                <strong>Gagal!</strong> Periksa kembali form.
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Surat Izin
        </div>

        <div class="card-body">

            <form action="{{ route('staff.izin.update', $izin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Jenis Izin --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="jenis" class="form-control" required>
                            <option value="izin" {{ old('jenis', $izin->jenis) == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('jenis', $izin->jenis) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                        @error('jenis')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pegawai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pegawai</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $izin->tanggal_mulai) }}" class="form-control">
                        @error('tanggal_mulai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $izin->tanggal_selesai) }}" class="form-control">
                        @error('tanggal_selesai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alasan --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alasan</label>
                        <textarea name="alasan" class="form-control" rows="3">{{ old('alasan', $izin->alasan) }}</textarea>
                        @error('alasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lampiran --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" name="lampiran" class="form-control" accept="image/*,pdf">
                        @if($izin->lampiran)
                            <small class="text-muted">Lampiran saat ini: <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank">Lihat file</a></small>
                        @endif
                        <small class="text-muted d-block">Format: JPG, PNG, PDF</small>
                        @error('lampiran')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button class="btn btn-success mt-3">Perbarui</button>
                <a href="{{ route('staff.izin.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>
</div>

@endsection
