@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- NOTIFIKASI DARI BACKEND --}}
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
                            Tekan tombol di bawah ini untuk mengaktifkan kamera.
                        </p>
                    </div>

                    <!-- Tombol aktifkan kamera -->
                    <div class="text-center mb-3">
                        <button id="startCameraBtn" class="btn btn-primary">
                            Aktifkan Kamera
                        </button>
                        <button id="stopCameraBtn" class="btn btn-danger d-none">
                            Matikan Kamera
                        </button>
                    </div>

                    <!-- Kamera -->
                    <div id="reader" style="width:100%; display:none;"></div>

                    <!-- Notifikasi hasil scan -->
                    <div id="scanResult" class="alert alert-info mt-3 d-none text-center"></div>

                    <!-- Form Auto Submit -->
                    <form id="absenForm" action="{{ route('staff.absen.store') }}" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="qr" id="qrData">
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    // Auto hide alert dari backend
    setTimeout(() => {
        let alertBox = document.getElementById('alertMessage');
        if (alertBox) {
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);

    let scanner = null;
    let isCameraRunning = false;

    document.getElementById('startCameraBtn').addEventListener('click', function() {
        if (isCameraRunning) return;

        document.getElementById('reader').style.display = "block";
        document.getElementById('startCameraBtn').classList.add('d-none');
        document.getElementById('stopCameraBtn').classList.remove('d-none');

        scanner = new Html5Qrcode("reader");

        scanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 280, height: 280 }
            },
            onScanSuccess,
            onScanError
        ).catch(err => {
            alert("Gagal membuka kamera: " + err);
        });

        isCameraRunning = true;
    });

    document.getElementById('stopCameraBtn').addEventListener('click', function() {
        stopCamera();
    });

    function stopCamera() {
        if (!scanner || !isCameraRunning) return;

        scanner.stop().then(() => {
            scanner.clear();
            document.getElementById('reader').style.display = "none";

            document.getElementById('startCameraBtn').classList.remove('d-none');
            document.getElementById('stopCameraBtn').classList.add('d-none');

            isCameraRunning = false;
        })
        .catch(err => {
            console.log("Error menghentikan kamera:", err);
        });
    }

    function onScanSuccess(decodedText) {
        let resultBox = document.getElementById('scanResult');
        resultBox.classList.remove('d-none');
        resultBox.classList.add('alert-success');
        resultBox.innerHTML = "QR Terdeteksi: " + decodedText + "<br>Memproses absensi...";

        stopCamera();

        document.getElementById('qrData').value = decodedText;

        setTimeout(() => {
            document.getElementById('absenForm').submit();
        }, 900);
    }

    function onScanError(error) {
        // Tidak perlu apa-apa
    }
</script>

@endsection
