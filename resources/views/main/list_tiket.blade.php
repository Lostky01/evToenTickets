@extends('layouts.app-home')
@section('Title')
    Tiket Saya
@endsection

@section('style')
    <style>
        .ticket-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .ticket-img {
            width: 100%;
            border-radius: 10px;
        }

        .ticket-info {
            margin-top: 1rem;
        }
    </style>
@endsection

@section('content')
    <section class="p-5">
        <div class="container p-5" style="background-color:white; border-radius: 10px;">
            <span class="activee">
                <h2 class="fw-bold" href="" style="color: #273A8B;">Tiket Saya</h2>
            </span>
            @if($tickets->isEmpty())
                <center>
                    <h1 style="color: #C9D1DA">Anda Belum Memiliki Tiket</h1>
                </center>
            @else
                    @foreach ($tickets as $ticket)
                            <div class="col-12 p-4 mt-5" style="border-radius: 10px; border: 1px solid #C9D1DA !important; width: 100%;">
                                <div class="row mt-3 align-items-center">
                                    <!-- Kolom Kiri: Poster Event -->
                                    <div class="col-md-2 text-start">
                                        <img src="{{ asset(('poster/' . $ticket->event->poster)) }}" alt="Poster Event"
                                            style="width: 100%; max-width: 200px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                                    </div>

                                    <!-- Kolom Tengah: Info Event -->
                                    <div class="col-md-7" style="text-align: start !important">
                                        <h5 class="fw-bold" style="color: #273A8B;">{{ $ticket->event->event_name }}</h5>
                                        <p class="text-muted mb-1"
                                            style="border-radius: 5px; padding: 0.7%; width: 20%; font-weight: bold; font-style:italic; font-size: 0.9rem;
                        background-image: linear-gradient(to right, {{ $ticket->event->event_date > date('Y-m-d') ? '#EEAE18' : ($ticket->event->event_date < date('Y-m-d') ? '#FF4C4C' : '#32CD32') }} , rgba(255, 99, 71, 0));">
                                            {{ $ticket->event->event_date > date('Y-m-d') ? 'Mendatang' : ($ticket->event->event_date < date('Y-m-d') ? 'Selesai' : 'Berlangsung') }}
                                        </p>

                                        <div class="d-flex mt-4">
                                            <img src="{{ asset('images/date.png') }}"
                                                style="width: auto !important; height: 25px; margin-right:5px">
                                            <p class="text-muted mb-1 " style="color: #273A8B !important;">
                                                {{ date('d M Y', strtotime($ticket->event->event_date)) }}</p>
                                        </div>
                                        <div class="d-flex">
                                            <img src="{{ asset('images/location.png') }}" alt=""
                                                style="width: auto !important; height: 23px; margin-right:8px">
                                            <span class="text-muted mb-1 " style="color: #273A8B !important;"> SMKN 2 KOTA BEKASI</span>
                                        </div>
                                        <div class="d-flex">
                                            <img src="{{ asset('images/clock.png') }}" alt=""
                                                style="width: auto !important; height: 23px;margin-right:7px">
                                            <span class="text-muted mb-1 " style="color: #273A8B !important;"> 09:00 s/d Selesai</span>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan: Jumlah Tiket & Tombol -->
                                    <div class="col-md-3 text-end d-flex flex-column align-items-end">
                                        <!-- Jumlah Tiket -->
                                        <div class="fw-bold text-muted" style="color: #273A8B !important;">
                                            <span style="font-size: 1.2rem;">Jumlah:</span> <br>
                                            <span style="font-size: 1rem;">1 Tiket</span>
                                        </div>

                                        <!-- Tombol Lihat E-Tiket -->
                                        <a href="{{ route('ticket-detail', $ticket->id) }}" class="btn btn-primary mt-3"
                                            style="background-color: #273A8B; border-radius: 8px; padding: 8px 15px; border: 0 !important;">
                                            Lihat E-Tiket
                                        </a>
                                    </div>
                                </div>
                            </div>
                    @endforeach
            @endif
        </div>
    </section>
@endsection

@section('script')
@endsection

{{-- <div class="container">
    <h2 style="color: #273A8B">Tiket Saya</h2>

    @if($tickets->isEmpty())
    <p class="text-muted">Kamu belum punya tiket.</p>
    @else
    @foreach ($tickets as $ticket)
    <div class="ticket-card">
        <img src="{{ asset(( 'poster/' . $ticket->event->poster)) }}" alt="Poster Event" class="ticket-img">
        <div class="ticket-info">
            <h3>{{ $ticket->event->event_name }}</h3>
            <p><strong>Jumlah Tiket:</strong> {{ $ticket->quantity }}</p>
            <p><strong>Status:</strong> {{ $ticket->status }}</p>
            <a href="{{ route('tiket-detail', ['id' => $ticket->id]) }}" class="btn btn-primary mt-2"
                style="background: #273A8B;">Lihat Tiket</a>
        </div>
    </div>
    @endforeach
    @endif
</div> --}}