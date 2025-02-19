@extends('layouts.app-home')
@section('Title')
Home
@endsection
@section('content')
<div class="container-fluid">
    @if(auth('admin')->check() && auth('admin')->user()->user_type == 'Admin')
        <h1>Anda Login Sebagai Admin</h1>
        
    @elseif(auth()->check())
        <h1>Anda login sebagai:</h1>
        <ul>
            <li><strong>NIS / Email:</strong> {{ auth()->user()->nis ?? auth()->user()->email }}</li>
            <li><strong>User ID:</strong> {{ auth()->user()->id }}</li>
            <li><strong>Username:</strong> {{ auth()->user()->name }}</li>
            <li><strong>Apakah sudah verified:</strong>
                {{ auth()->user()->is_verified == '1' ? 'Sudah verified' : 'Belum verified' }}</li>
            <li><strong>Tipe User:</strong> {{ auth()->user()->user_type }}</li>
        </ul>
    @else
        <h1>Anda belum login</h1>
    @endif

    <h2>Daftar Event</h2>
    <ul>
        @foreach($event as $e)
            <li>
                <strong>{{ $e->event_name }}</strong> <br>
                <small>Tanggal: {{ $e->event_date }}</small> <br>
                <small>Tipe Event: {{ $e->event_type }}</small> <br>
                <small>Kuota Untuk Publik: {{ $e->quota_for_public }}</small> <br>
                <small>Harga: Rp{{ number_format($e->event_price, 0, ',', '.') }}</small> <br>
                <a href="{{ route('checkout', ['id' => $e->id]) }}">
                    <button>Beli Tiket</button>
                </a>
            </li>
            <hr>
        @endforeach
    </ul>
    
    @if(auth()->user())
        @if(auth()->user()->tickets)
            <h2>Daftar Tiket Saya</h2>
            <ul>
                @foreach(auth()->user()->tickets as $ticket)
                    <li>
                        <strong>Event:</strong> {{ $ticket->event->event_name }} <br>
                        <strong>Kode Tiket:</strong> {{ $ticket->ticket_code }} <br>
                        <img src="{{ route('ticket.qr', ['ticket_code' => $ticket->ticket_code]) }}" alt="QR Code">
                    </li>
                    <hr>
                @endforeach
            </ul>
        @endif
    @endif
</div>
@endsection