@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Pegawai
        </div>

        <div class="card-body">
            <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Pegawai -->
                <label class="mt-3">Nama Pegawai</label>
                <input type="text" name="name" class="form-control" value="{{ $pegawai->user->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Email Pegawai -->
                <label class="mt-3">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $pegawai->user->email }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <!-- Departemen -->
                <label class="mt-3">Departemen</label>
                <select name="departemen_id" class="form-control" required>
                    @foreach ($departemen as $d)
                        <option value="{{ $d->id }}" {{ $pegawai->departemen_id == $d->id ? 'selected' : '' }}>
                            {{ $d->nama_departemen }}
                        </option>
                    @endforeach
                </select>

                <!-- Kantor -->
                <label class="mt-3">Kantor</label>
                <select name="kantor_id" class="form-control" required>
                    @foreach ($kantor as $k)
                        <option value="{{ $k->id }}" {{ $pegawai->kantor_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kantor }}
                        </option>
                    @endforeach
                </select>

                <!-- No HP -->
                <label class="mt-3">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $pegawai->no_hp }}" required>

                <!-- Alamat -->
                <label class="mt-3">Alamat</label>
                <textarea name="alamat" class="form-control" required>{{ $pegawai->alamat }}</textarea>

                <!-- Status -->
                <label class="mt-3">Status</label>
                <select name="status" class="form-control" required>
                    <option value="aktif" {{ $pegawai->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $pegawai->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <!-- Foto -->
                <label class="mt-3">Foto Pegawai</label>
                <input type="file" name="foto" class="form-control">
                @if($pegawai->foto)
                    <img src="{{ asset('storage/'.$pegawai->foto) }}" class="mt-2 rounded" width="90">
                @endif

                <button type="submit" class="btn btn-warning mt-4">Update</button>
                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary mt-4">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
