@extends('layout.app')

@section('content')
<div class="container-fluid px-4">

    <h3 class="mt-4 mb-3">Edit Izin / Sakit</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- ERROR VALIDATION --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.izin.update', $izin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Jenis --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="jenis" class="form-control" required>
                            <option value="izin" {{ $izin->jenis == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ $izin->jenis == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                    </div>

                    {{-- Pegawai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pegawai</label>
                        <input type="text" class="form-control" 
                               value="{{ auth()->user()->name }}" readonly>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" 
                               value="{{ $izin->tanggal_mulai }}" 
                               class="form-control" required>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                               value="{{ $izin->tanggal_selesai }}"
                               class="form-control" required>
                    </div>

                    {{-- Alasan --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alasan</label>
                        <textarea name="alasan" class="form-control" rows="3" required>{{ $izin->alasan }}</textarea>
                    </div>

                    {{-- Lampiran --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" name="lampiran" class="form-control" accept="image/*,pdf">
                        <small class="text-muted">JPG, PNG, PDF</small>

                        @if ($izin->lampiran)
                            <p class="mt-2">
                                Lampiran saat ini: 
                                <a href="{{ asset('storage/'.$izin->lampiran) }}" target="_blank">Lihat Lampiran</a>
                            </p>
                        @endif
                    </div>

                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('staff.izin.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
