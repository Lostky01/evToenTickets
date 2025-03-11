<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/mona-sans" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: #ebf3fc !important;
            font-family: 'Mona-Sans', sans-serif;
            color: #273A8B !important;
            padding: 10%;
        }

        .m-ticket {
            max-width: 600px;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Parent wrapper buat sobekan & garis */
        .ticket-divider {
            position: relative;
            width: 100%;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        /* Garis putus-putus */
        .dashed-line {
            width: 110%;
            height: 2px;
            background: repeating-linear-gradient(to right,
                    #C9D1DA,
                    #C9D1DA 8px,
                    transparent 8px,
                    transparent 16px);
            position: absolute;
            z-index: 5;
        }

        /* Sobekan tiket kiri & kanan */
        .ticket-divider::before,
        .ticket-divider::after {
            content: "";
            position: absolute;
            width: 25px;
            height: 25px;
            background: #ebf3fc;
            border-radius: 50%;
            z-index: 10;
        }

        .ticket-divider::before {
            left: -30px;
            /* Digeser lebih ke kiri */
        }

        .ticket-divider::after {
            right: -30px;
            /* Digeser lebih ke kanan */
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center p-5">

    <div class="m-ticket">
        {{-- <h4 class="text-start fw-bold">Detail Tiket</h4> --}}

        <div class="card" style="border: 0 !important">
            <div class="row g-0">
                <!-- Poster Event -->
                <div class="col-md-4">
                    <img src="{{ public_path('poster/' . $ticket->event->poster) }}" class="img-fluid rounded-start"
                        alt="Poster Event">
                </div>

                <!-- Detail Event -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $ticket->event->event_name }}</h5>
                        <div class="col-12 p-3" style="border: 0; border-radius: 5px;">
                            <div class="d-flex">
                                <img src="{{ public_path('images/date.png') }}"
                                    style="width: auto !important; height: 25px; margin-right:5px">
                                <p class="text-muted mb-1 fw-bold" style="color: #273A8B !important;">
                                    {{ \Carbon\Carbon::parse($ticket->event->event_date)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div class="d-flex">
                                <img src="{{ public_path('images/location.png') }}" alt=""
                                    style="width: auto !important; height: 23px; margin-right:8px">
                                <span class="text-muted mb-1 fw-bold" style="color: #273A8B !important;"> SMKN 2 KOTA
                                    BEKASI</span>
                            </div>
                            <div class="d-flex">
                                <img src="{{ public_path('images/clock.png') }}" alt=""
                                    style="width: auto !important; height: 23px;margin-right:7px">
                                <span class="text-muted mb-1 fw-bold" style="color: #273A8B !important;"> 09:00 s/d
                                    Selesai</span>
                            </div>
                        </div>
                        {{-- <p style="color: #273A8B">
                            <strong>Tanggal:</strong> {{
                            \Carbon\Carbon::parse($ticket->event->event_date)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="card-text">
                            <strong>Pemesan:</strong>
                            {{ $ticket->user->name ?? 'Admin' }}
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Garis Sobekan -->
        <div class="ticket-divider">
            <div class="dashed-line"></div>
        </div>

        <!-- QR Code & Info -->
        <div class="text-center mt-4">
            <center><h5 style="color: #273A8B; font-weight: bold;">Nama Lengkap</h5></center>
            <center><p style="color: #273A8B;">{{ $event->user->name ?? 'Admin' }}</p></center>
            <img src="{{ public_path('tickets-qr/' . $ticket->ticket_code . '.png') }}" class="img-fluid" width="400"
                height="400" alt="QR Code">
            <h5 class="mt-2 fw-bold">Kode Tiket: {{ $ticket->ticket_code }}</h5>
        </div>

        <!-- Notifikasi -->
        <div class="alert alert-warning d-flex align-items-center mt-3">
            <i class='bx bxs-error-alt bx-lg me-3' style="color: #AD943F;"></i>
            <span>
                Kode QR Hanya dapat digunakan 1x untuk satu orang
            </span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>