@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Tambah Pegawai
        </div>

        <div class="card-body">

            <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>User (Nama Akun)</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>

                <label class="mt-3">Departemen</label>
                <select name="departemen_id" class="form-control" required>
                    <option value="">-- Pilih Departemen --</option>
                    @foreach ($departemen as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                    @endforeach
                </select>

                <label class="mt-3">Kantor</label>
                <select name="kantor_id" class="form-control" required>
                    <option value="">-- Pilih Kantor --</option>
                    @foreach ($kantor as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kantor }}</option>
                    @endforeach
                </select>

                <label class="mt-3">No HP</label>
                <input type="text" name="no_hp" class="form-control">

                <label class="mt-3">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"></textarea>

                <label class="mt-3">Status</label>
                <select name="status" class="form-control">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>

                <label class="mt-3">Foto Pegawai</label>
                <input type="file" name="foto" class="form-control">

                <button class="btn btn-success mt-4">Simpan</button>
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </form>

        </div>
    </div>
</div>
@endsection
