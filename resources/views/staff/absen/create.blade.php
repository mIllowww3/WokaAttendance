@extends('layouts.admin')

@section('content')

@section('title', 'Tambah Absen')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4>Tambah Absen</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.absen.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Pegawai</label>
                    <select name="pegawai_id" class="form-control" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name ?? $p->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Lokasi Masuk</label>
                    <input type="text" name="lokasi_masuk" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Lokasi Pulang</label>
                    <input type="text" name="lokasi_pulang" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jarak Masuk (m)</label>
                    <input type="number" step="0.01" name="jarak_masuk" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jarak Pulang (m)</label>
                    <input type="number" step="0.01" name="jarak_pulang" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.absen.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
