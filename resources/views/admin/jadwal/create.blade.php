@extends('layout.app')

@section('content')

@section('title', 'Tambah Jadwal')


<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Tambah Jadwal Kerja
        </div>

        <div class="card-body">

            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Hari</label>
                    <select name="hari" class="form-select">
                        <option value="">-- Pilih Hari --</option>
                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                        <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control">
                                    @error('jam_masuk')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control">
                                    @error('jam_pulang')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>

@endsection