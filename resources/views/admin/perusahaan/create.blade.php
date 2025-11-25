<!DOCTYPE html>
<html>
<head>
    <title>Tambah Perusahaan</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Geocoder (Search Box) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        .card { background: white; padding: 20px; max-width: 700px; margin: auto; border-radius: 8px; }
        input, textarea, select {
            width: 100%; padding: 10px; margin-top: 8px; border: 1px solid #ccc; border-radius: 6px;
        }
        #map { width: 100%; height: 300px; border-radius: 8px; margin-top: 15px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>

<div class="card">
    <h2>Tambah Perusahaan</h2>

    <form method="POST" action="{{ route('admin.perusahaan.store') }}">
        @csrf

        <label>Nama Kantor</label>
        <input type="text" name="nama_kantor" required>

        <label>Latitude</label>
        <input type="text" id="lat" name="latitude" required>

        <label>Longitude</label>
        <input type="text" id="lng" name="longitude" required>

        <label>Radius (meter)</label>
        <input type="number" name="radius" required>

        <label>Alamat</label>
        <textarea name="alamat" rows="3"></textarea>

        <label>Status</label>
        <select name="status">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>

        <h4>Preview Lokasi</h4>
        <div id="map"></div>

        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('admin.perusahaan.index') }}">Kembali</a>
    </form>
</div>

<script>
    // Default posisi (Jakarta)
    var map = L.map('map').setView([-6.200000, 106.816666], 12);

    // Layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    var marker = null;

    // Tambah Search Box
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var center = e.geocode.center;

        // Update marker
        if (marker) map.removeLayer(marker);
        marker = L.marker(center).addTo(map);

        map.setView(center, 16);

        // Set ke input
        document.getElementById('lat').value = center.lat;
        document.getElementById('lng').value = center.lng;
    })
    .addTo(map);

    function updateMarker() {
        var lat = parseFloat(document.getElementById('lat').value);
        var lng = parseFloat(document.getElementById('lng').value);

        if (!isNaN(lat) && !isNaN(lng)) {
            if (marker) map.removeLayer(marker);

            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 16);
        }
    }

    // Input manual update marker
    document.getElementById('lat').addEventListener('keyup', updateMarker);
    document.getElementById('lng').addEventListener('keyup', updateMarker);

    // Klik pada map -> pindahkan marker & isi input
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;

        updateMarker();
    });
</script>

</body>
</html>
