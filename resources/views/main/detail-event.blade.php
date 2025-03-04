@extends('layouts.app-home')
@section('Title')
    Home
@endsection
@section('style')
<style>
</style>
@endsection
@section('content')
    <div style="margin-top: 5%;">
        <span>Beranda ></span> 
        <span style="color: #273A8B; font-weight: bold;">{{ $event->event_name }}</span>
    </div>
    <section class="p-5">
        <div class="row align-items-stretch"> <!-- Tambahin align-items-stretch -->
            <!-- Container utama (lebar) -->
            <div class="col-9">
                <div class="container p-4 h-100" style="background-color:white; border-radius: 10px;">
                    <div class="row g-0">
                        <div class="col-3 p-3">
                            <img src="{{ asset('poster/' . $event->poster) }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-9 p-3">
                            <h5 style="color: #273A8B">{{ $event->event_name }}</h5>
                            <p class="text-muted mb-1"
                                style="border-radius: 5px; padding: 0.7%; width: 20%; font-weight: bold; font-style:italic; font-size: 1.3rem; color: #273A8B !important;
                                                    background-image: linear-gradient(to right, #FCBB22, rgba(255, 99, 71, 0));">
                                Batch 1
                            </p>
                            <p style="font-weight: bold; color: #273A8B; margin-top:5%">Tentang Konser ini</p>
                            <p style="color: #273A8B; margin-top:5%">{{ $event->event_description }}</p>
                            <div class="col-6 p-3" style="border: 1px solid #C9D1DA; border-radius: 5px;">
                                <div class="d-flex">
                                    <img src="{{ asset('images/date.png') }}"
                                        style="width: auto !important; height: 25px; margin-right:5px">
                                    <p class="text-muted mb-1 fw-bold" style="color: #273A8B !important;">
                                        {{ date('d M Y', strtotime($event->event_date)) }}</p>
                                </div>
                                <div class="d-flex">
                                    <img src="{{ asset('images/location.png') }}" alt=""
                                        style="width: auto !important; height: 23px; margin-right:8px">
                                    <span class="text-muted mb-1 fw-bold" style="color: #273A8B !important;"> SMKN 2 KOTA BEKASI</span>
                                </div>
                                <div class="d-flex">
                                    <img src="{{ asset('images/clock.png') }}" alt=""
                                        style="width: auto !important; height: 23px;margin-right:7px">
                                    <span class="text-muted mb-1 fw-bold" style="color: #273A8B !important;"> 09:00 s/d Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Container menu (thin) -->
            <div class="col-3">
                <div class="container p-4 h-100" style="background-color:white; border-radius: 10px;">
                    <img src="{{ asset('images/pics.png') }}" alt="">
                    <div class="mt-5 p-3" style="border: 1px solid #C9D1DA; border-radius: 5px;">
                        <p style="font-weight: bold; color: #273A8B;">Harga Event ini</p>
                        
                        <p class="text-muted mb-1"
                            style="border-radius: 5px; padding: 2%; width: 90%; font-weight: bold; font-style: italic; font-size: 0.9rem; 
                                   color: #273A8B !important; background-image: linear-gradient(to right, #FCBB22, rgba(255, 99, 71, 0));">
                            {{ $event->quota_for_public }} Tiket Tersisa
                        </p>
                    
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <p style="color: #C9D1DA; margin-bottom: 0;">Total</p>
                            <span style="color: #273A8B; font-weight: bold;">Rp {{ number_format($event->event_price, 0, ',', '.') }}</span>
                        </div>
                    
                        <a href="{{ route('checkout-menu', $event->id) }}" class="btn btn-primary mt-3" 
                           style="background-color: #273A8B; border: 0 !important; width: 100%;">
                            Beli Sekarang
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </section>        
@endsection
@section('script')

@endsection
