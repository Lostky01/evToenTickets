@extends('layouts.app-default')

@section('Title')
    QR SCANNER
@endsection

@section('style')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <style>
        #preview {
            width: 100%;
            max-width: 700px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Scan Tiket</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <center>
                            <video id="preview"></video>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">Hasil Scan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <!-- Hasil Scan Muncul di Sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        // Event saat QR Code terdeteksi
        scanner.addListener('scan', function (content) {
            console.log('✅ QR Code Terbaca:', content); // Debug data yang dikirim

            fetch('{{ route('scan-tiket') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ticket_code: content })
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ Response dari server:', data); // Debug response dari server

                if (data.message === 'Event belum dimulai') {
                    document.getElementById('modalMessage').innerHTML = "<strong>⚠️ Event ini belum dimulai. Silakan tunggu hingga event berlangsung.</strong>";
                } else if (data.message === 'Event sudah berakhir') {
                    document.getElementById('modalMessage').innerHTML = "<strong>❌ Event ini sudah berakhir. Tiket tidak dapat digunakan.</strong>";
                } else if (data.message === 'Tiket sudah digunakan') {
                    document.getElementById('modalMessage').innerHTML = "<strong>❌ Tiket ini sudah digunakan sebelumnya dan tidak dapat dipakai lagi.</strong>";
                } else if (data.status === 'success') {
                    // Buat tampilan informasi user
                    let userInfoHtml = '<ul>';
                    for (const [key, value] of Object.entries(data.user_info)) {
                        userInfoHtml += `<li><strong>${key}:</strong> ${value}</li>`;
                    }
                    userInfoHtml += '</ul>';

                    // Tampilkan di modal
                    document.getElementById('modalMessage').innerHTML = `
                    <strong>${data.message}</strong><br>
                    <strong>Tipe Pengguna:</strong> ${data.user_type}<br>
                    ${userInfoHtml}`;
                } else {
                    document.getElementById('modalMessage').innerHTML = "<strong>❌ Kesalahan: " + data.message + "</strong>";
                }
                let resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
                resultModal.show();
            })
            .catch(error => {
                console.error('❌ Error saat fetch:', error);
                document.getElementById('modalMessage').innerHTML = "<strong>Terjadi kesalahan saat memverifikasi tiket.</strong>";
                let resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
                resultModal.show();
            });
        });

        // Cek daftar kamera
        Instascan.Camera.getCameras().then(function (cameras) {
            console.log('📷 Daftar Kamera:', cameras); // Debug kamera yang tersedia

            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('❌ Kamera tidak ditemukan.');
            }
        }).catch(function (e) {
            console.error('❌ Error deteksi kamera:', e);
        });
    });
</script>
@endsection

