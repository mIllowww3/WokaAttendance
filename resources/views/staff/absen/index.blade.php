@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h4 class="mb-0">Scan QR Code untuk Absen</h4>
                </div>

                <div class="card-body">

                    <div class="text-center mb-3">
                        <p class="text-sm text-muted">
                            Arahkan kamera ke QR Code Absen Anda.
                        </p>
                    </div>

                    <!-- Kamera -->
                    <div id="reader" style="width:100%;"></div>

                    <form id="absenForm" action="{{ route('staff.absen.store') }}" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="qr" id="qrData">
                    </form>

                    <div id="scanResult" class="alert alert-info mt-3 d-none text-center">
                        QR Terdeteksi! Memproses absensi...
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


{{-- SCRIPT SCAN QR --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Tampilkan notifikasi
        document.getElementById('scanResult').classList.remove('d-none');
        document.getElementById('scanResult').innerHTML = "QR Terdeteksi: " + decodedText;

        // Masukkan ke input hidden
        document.getElementById('qrData').value = decodedText;

        // Submit otomatis
        setTimeout(function () {
            document.getElementById('absenForm').submit();
        }, 800);
    }

    function onScanError(errorMessage) {
        // Tidak perlu apa-apa, hanya untuk debug
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 280, height: 280 }
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>

@endsection
