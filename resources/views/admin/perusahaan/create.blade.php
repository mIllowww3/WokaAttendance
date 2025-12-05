@extends('layout.app')

@section('content')

@section('title', 'Tambah Perusahaan')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Tambah Perusahaan
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.perusahaan.store') }}">
                @csrf

                <label>Nama Kantor</label>
                <input type="text" name="nama_kantor" class="form-control">
                @error('nama_kantor')       
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label>Latitude</label>
                <input type="text" id="lat" name="latitude" class="form-control">
                @error('latitude')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label>Longitude</label>
                <input type="text" id="lng" name="longitude" class="form-control">
                @error('longitude')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label>Radius (meter)</label>
                <input type="number" name="radius" class="form-control">
                @error('radius')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label>Alamat</label>
                <textarea name="alamat" rows="3" class="form-control"></textarea>
                @error('alamat')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                @error('status')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <h4 class="mt-3">Preview Lokasi</h4>
                <div id="map"></div>

                <br>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var defaultLocation = [-6.2, 106.8];

    var map = L.map('map').setView(defaultLocation, 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker = L.marker(defaultLocation, {
        draggable: true
    }).addTo(map);

    marker.on('dragend', function(e) {
        var latlng = e.target.getLatLng();
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
    });
        L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        marker.setLatLng(latlng);
        map.setView(latlng, 15);
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;
    })
    .addTo(map);
</script>
@endsection