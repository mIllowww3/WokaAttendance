@extends('layout.app')

@section('content')

@section('title', 'Data Absen')

<div class="container-fluid py-4">

    {{-- NOTIFIKASI BACKEND --}}
    @if(session('success'))
    <div class="alert alert-success text-center" id="alertMessage">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger text-center" id="alertMessage">
        {{ session('error') }}
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info text-center" id="alertMessage">
        {{ session('info') }}
    </div>
    @endif


    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h4 class="mb-0">Scan QR Code untuk Absen</h4>
                </div>

                <div class="card-body">

                    <div class="text-center mb-3">
                        <p class="text-sm text-muted">
                            Anda dapat scan melalui kamera atau memilih gambar QR dari file.
                        </p>
                    </div>

                    <!-- Tombol kamera -->
                    <div class="text-center mb-3">
                        <button id="startCameraBtn" class="btn btn-primary me-2">Aktifkan Kamera</button>
                        <button id="stopCameraBtn" class="btn btn-danger d-none">Matikan Kamera</button>
                    </div>

                    <!-- Tombol pilih file -->
                    <div class="text-center mb-3">
                        <button id="chooseFileBtn" class="btn btn-secondary">Pilih QR dari File</button>
                        <input type="file" id="qrFileInput" accept="image/*" class="d-none">
                    </div>

                    <!-- Area kamera -->
                    <div id="reader" style="width:100%; display:none;"></div>

                    <!-- Hasil scan -->
                    <div id="scanResult" class="alert alert-info mt-3 d-none text-center"></div>

                    <!-- FORM AUTO SUBMIT -->
                    <form id="absenForm" method="POST" action="{{ route('staff.absen.store') }}" style="display:none;">
                        @csrf
                        <input type="hidden" id="qrData" name="qr">

                        <!-- LOKASI -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>

    let scanner = null;
    let isCameraRunning = false;

    // ==========================================================
    // KAMERA
    // ==========================================================
    document.getElementById('startCameraBtn').addEventListener('click', function() {
        if (isCameraRunning) return;

        document.getElementById('reader').style.display = "block";
        document.getElementById('startCameraBtn').classList.add('d-none');
        document.getElementById('stopCameraBtn').classList.remove('d-none');

        scanner = new Html5Qrcode("reader");

        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 280, height: 280 } },
            onScanSuccess,
            onScanError
        ).catch(err => {
            alert("Gagal membuka kamera: " + err);
        });

        isCameraRunning = true;
    });

    document.getElementById('stopCameraBtn').addEventListener('click', stopCamera);

    function stopCamera() {
        if (!scanner || !isCameraRunning) return;

        scanner.stop().then(() => {
            scanner.clear();
            document.getElementById('reader').style.display = "none";
            document.getElementById('startCameraBtn').classList.remove('d-none');
            document.getElementById('stopCameraBtn').classList.add('d-none');
            isCameraRunning = false;
        });
    }

    // ==========================================================
    // UPLOAD FILE QR
    // ==========================================================
    document.getElementById('chooseFileBtn').addEventListener('click', () => {
        document.getElementById('qrFileInput').click();
    });

    document.getElementById('qrFileInput').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (!file) return;

        stopCamera();

        const html5Qr = new Html5Qrcode("reader");
        document.getElementById('reader').style.display = "block";

        html5Qr.scanFile(file, true)
            .then(decodedText => onScanSuccess(decodedText))
            .catch(err => alert("Gagal membaca gambar QR: " + err));
    });

    // ==========================================================
    // LOKASI + SUBMIT
    // ==========================================================
    function getLocationAndSubmit() {
        if (!navigator.geolocation) {
            alert("Perangkat Anda tidak mendukung GPS!");
            return;
        }

        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;

            document.getElementById('absenForm').submit();

        }, function() {
            alert("GPS tidak diizinkan. Tidak dapat absen.");
        });
    }

    // ==========================================================
    // QR Terdeteksi
    // ==========================================================
    function onScanSuccess(decodedText) {
        let resultBox = document.getElementById('scanResult');
        resultBox.classList.remove('d-none');
        resultBox.classList.add('alert-success');
        resultBox.innerHTML = "QR Terdeteksi: " + decodedText + "<br>Memproses absensi...";

        stopCamera();

        document.getElementById('qrData').value = decodedText;

        // Ambil lokasi lalu submit
        setTimeout(() => {
            getLocationAndSubmit();
        }, 800);
    }

    function onScanError(error) {
        // Tidak perlu apa-apa
    }
</script>

@endsection
