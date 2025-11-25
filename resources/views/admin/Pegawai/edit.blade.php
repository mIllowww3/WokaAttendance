@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning text-white fw-bold">
            Edit Pegawai
        </div>

        <div class="card-body">

            <form action="{{ route('pegawai.update', $pegawai->id) }}" 
                  method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <label>User</label>
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ $pegawai->user_id == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>

                <label class="mt-3">Departemen</label>
                <select name="departemen_id" class="form-control" required>
                    @foreach ($departemen as $d)
                        <option value="{{ $d->id }}" {{ $pegawai->departemen_id == $d->id ? 'selected' : '' }}>
                            {{ $d->nama_departemen }}
                        </option>
                    @endforeach
                </select>

                <label class="mt-3">Kantor</label>
                <select name="kantor_id" class="form-control" required>
                    @foreach ($kantor as $k)
                        <option value="{{ $k->id }}" {{ $pegawai->kantor_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kantor }}
                        </option>
                    @endforeach
                </select>

                <label class="mt-3">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $pegawai->no_hp }}">

                <label class="mt-3">Alamat</label>
                <textarea name="alamat" class="form-control">{{ $pegawai->alamat }}</textarea>

                <label class="mt-3">Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ $pegawai->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $pegawai->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <label class="mt-3">Foto Pegawai</label>
                <input type="file" name="foto" class="form-control">

                @if($pegawai->foto)
                    <img src="/uploads/pegawai/{{ $pegawai->foto }}" class="mt-2 rounded" width="90">
                @endif

                <button class="btn btn-warning mt-4">Update</button>
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mt-4">Kembali</a>

            </form>

        </div>
    </div>
</div>
@endsection
