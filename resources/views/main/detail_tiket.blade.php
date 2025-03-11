@extends('layouts.app-home')
@section('Title')
    Detail Tiket
@endsection
@section('style')
    <style>
        .ticket-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            /* background-image: linear-gradient(to right , rgba(255,255,255,0),  rgb(50, 69, 248)); /* url('{{ asset('poster/' . $ticket->event->poster) }}') */ */
            background-size: cover;
            background-repeat: no-repeat;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
        }
        .download-btn {
            background-color: #273A8B;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }
    </style>
@endsection
@section('content')
<section class="p-5">
    <div class="container ticket-container">
        <h2 class="fw-bold" style="color: #273A8B;">Detail Tiket</h2>
        <div class="row align-items-center">
            <!-- Poster & Info Ticket -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama:</label>
                    <input type="text" value="{{ $ticket->user->name ?? 'Admin' }}" readonly>
                </div>
                <div class="form-group">
                    <label>Kode Tiket:</label>
                    <input type="text" value="{{ $ticket->ticket_code }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Event:</label>
                    <input type="text" value="{{ $ticket->event->event_name }}" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Event:</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($ticket->event->event_date)->translatedFormat('l, d F Y') }}" readonly>
                </div>
            </div>
            
            <!-- QR Code -->
            <div class="col-md-6 text-center">
                <div class="alert alert-warning d-flex mt-3" style="width: 100%">
                    <i class='bx bxs-error-alt mt-3 mx-3' style="font-size: 2rem; color: #AD943F;"></i>
                    <span class="fw-bold" style="text-align: left; color: #AD943F;;">
                        Jangan lupa simpan QR Code ini
                        <br> 
                        <span class="fw-normal">
                            Kamu juga bisa Screnshoot atau langsung tunjukan QR Code ini saat penukaran tiket 
                        </span> 
                    </span>
                </div>
                <img src="{{ asset('tickets-qr/' . $ticket->ticket_code . '.png') }}" alt="QR Code Tiket">
                <button class="download-btn mb-4" style="width:100%" onclick="window.open('{{ asset('tickets-qr/' . $ticket->ticket_code . '.png') }}', '_blank')">Unduh QR Code</button>
                <a href="{{ route('download.ticket', ['id' => $ticket->id]) }}" class="btn w-100" style="background-color: #273A8B; color: white;">
                    Unduh Bentuk PDF
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@endsection