<!DOCTYPE html>
<html>

<head>
    <title>Edit Perusahaan</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            max-width: 700px;
            margin: auto;
            border-radius: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        #map {
            width: 100%;
            height: 280px;
            border-radius: 8px;
            margin-top: 15px;
        }

        button {
            padding: 10px 15px;
            background: #ffc107;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Edit Perusahaan</h2>

        <form method="POST" action="{{ route('perusahaan.update', $perusahaan->id) }}">
            @csrf

            <label>Nama Kantor</label>
            <input type="text" name="nama_kantor" value="{{ $perusahaan->nama_kantor }}" required>

            <label>Latitude</label>
            <input type="text" id="lat" name="latitude" value="{{ $perusahaan->latitude }}" required>

            <label>Longitude</label>
            <input type="text" id="lng" name="longitude" value="{{ $perusahaan->longitude }}" required>

            <label>Radius (meter)</label>
            <input type="number" name="radius" value="{{ $perusahaan->radius }}" required>

            <label>Alamat</label>
            <textarea name="alamat" rows="3">{{ $perusahaan->alamat }}</textarea>

            <label>Status</label>
            <select name="status">
                <option value="aktif" {{ $perusahaan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $perusahaan->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <h4>Preview Lokasi</h4>
            <div id="map"></div>

            <br>
            <button type="submit">Update</button>
            <a href="{{ route('perusahaan.index') }}">Kembali</a>

        </form>
    </div>

    <script>
        var lat = parseFloat("{{ $perusahaan->latitude }}");
        var lng = parseFloat("{{ $perusahaan->longitude }}");


        var map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        var marker = L.marker([lat, lng]).addTo(map);

        function updateMarker() {
            var newLat = parseFloat(document.getElementById('lat').value);
            var newLng = parseFloat(document.getElementById('lng').value);

            if (!isNaN(newLat) && !isNaN(newLng)) {
                map.removeLayer(marker);
                marker = L.marker([newLat, newLng]).addTo(map);
                map.setView([newLat, newLng], 16);
            }
        }

        document.getElementById('lat').addEventListener('keyup', updateMarker);
        document.getElementById('lng').addEventListener('keyup', updateMarker);

        map.on('click', function(e) {
            var newLat = e.latlng.lat;
            var newLng = e.latlng.lng;

            document.getElementById('lat').value = newLat;
            document.getElementById('lng').value = newLng;

            updateMarker();
        });
    </script>

</body>

</html>