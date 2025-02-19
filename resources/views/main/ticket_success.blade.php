@extends('layouts.app-home')
@section('Title')
    Tiket Saya
@endsection
@section('style')
    <style>
        .ticket-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .qr-code {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
<section class="p-5">
    <center><img src="{{ asset('images/logo-header.png') }}" alt="" style="width: auto" height="60">
    </center>
    <div class="container p-5 mt-5" style="background: white; border-radius: 10px;">
        <h2 style="color: #273A8B">Sukses! Tiket Berhasil Dibeli</h2>
        <div class="mt-5">
            <center><img src="{{ asset($qrPath) }}" alt="QR Code"></center>
            <center>
                <h1 class="fw-bold mt-3">{{ $ticket->ticket_code }}</h1>
            </center>
        </div>
        <center>
            <div class="alert alert-warning d-flex mt-3" style="width: 70%">
                <i class='bx bxs-error-alt mt-3 mx-3' style="font-size: 2rem; color: #AD943F;"></i>
                <span class="fw-bold" style="text-align: left; color: #AD943F;;">
                    Screenshot Atau Unduh Tiketmu
                    <br> 
                    <span class="fw-normal">
                        Satu tiket hanya berlaku untuk sekali pakai, tunjukkan screenshot atau unduh gambar untuk ditunjukkan ke panitia
                    </span> 
                </span>
        </div></center>
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Nama Event</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ $event->event_name }}">
        </div>
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Nama</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'Admin' : optional(auth()->user())->name }}">
        </div>
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Status User</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'Khusus' : optional(auth()->user())->user_type }}">
        </div>
        @if(optional(auth()->user())->user_type == 'Siswa')
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">NIS</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'Khusus' : optional(auth()->user())->nis }}">
        </div>
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Kelas</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'Khusus' : optional(auth()->user())->kelas . ' ' . optional(auth()->user())->jurusan . ' ' . optional(auth()->user())->no_kelas  }}">
        </div>
        @endif
        @if(optional(auth('admin')->user())->user_type == 'Admin' || optional(auth()->user())->user_type == 'External')
        <div class="form-group mt-3">
            <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Email</label>
            <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'admin@gmail.com' : optional(auth()->user())->email  }}">
        </div>
        @endif
        <a href="{{ asset($qrPath) }}" download="tiket-qr.png" class="btn btn-primary mt-5" style="background: #273A8B; width:100%;">
            Unduh Tiket
        </a>            
    </div>
</section>

@endsection
@section('script')

@endsection


{{-- <div class="container mt-5 ticket-container">
    <h3 class="fw-bold">Tiket Berhasil Dipesan!</h3>
    @if(auth()->check())
    <p>Nama: {{ auth()->user()->name }}</p>
    @elseif(auth('admin')->check())
    <p>Nama: Admin SMKN 2</p>
    @endif
    <p>Event: {{ $event->event_name }}</p>
    <div class="qr-code">
        <img src="{{ asset($qrPath) }}" alt="QR Code">
    </div>
    <p class="fw-bold mt-3">Kode Tiket: {{ $ticket->ticket_code }}</p>
</div> --}}