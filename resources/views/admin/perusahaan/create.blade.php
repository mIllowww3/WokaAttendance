@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Tambah Perusahaan
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.perusahaan.store') }}">
                @csrf

                <label>Nama Kantor</label>
                <input type="text" name="nama_kantor" class="form-control" required>

                <label>Latitude</label>
                <input type="text" id="lat" name="latitude" class="form-control" required>

                <label>Longitude</label>
                <input type="text" id="lng" name="longitude" class="form-control" required>

                <label>Radius (meter)</label>
                <input type="number" name="radius" class="form-control" required>

                <label>Alamat</label>
                <textarea name="alamat" rows="3" class="form-control"></textarea>

                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>

                <h4>Preview Lokasi</h4>
                <div id="map"></div>

                <br>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        @endsection