@extends('layout.app')

@section('content')

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Jadwal Kerja
        </div>

        <div class="card-body">

            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Hari</label>
                    <select name="hari" class="form-select">
                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                        <option value="{{ $h }}" {{ $jadwal->hari == $h ? 'selected' : '' }}>
                            {{ $h }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control"
                           value="{{ $jadwal->jam_masuk }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control"
                           value="{{ $jadwal->jam_pulang }}">
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>

@endsection
