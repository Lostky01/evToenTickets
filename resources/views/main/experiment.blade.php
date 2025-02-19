@extends('layouts.app-home')
@section('Title')
    Buat eksperimen frontend
@endsection
@section('style')
    <style>
        .ticket-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .nav-item {
            color: #273A8B;
        }

        .activee a { 
            text-decoration: underline !important;
        }

        .qr-code {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <section class="p-5">
        <div class="container p-5" style="background-color:white; border-radius: 10px;">
            <span class="activee">
                <a class="fw-bold" href="" style="color: #273A8B; text-decoration: underline !important;">Konser Mendatang</a>
            </span>
            <div class="col-12 p-4 mt-5" style="border-radius: 10px; border: 1px solid #C9D1DA !important; width: 100%;">
                <div class="row mt-3 align-items-center">
                    <!-- Kolom Kiri: Poster Event -->
                    <div class="col-md-2 text-start">
                        <img src="{{ asset('poster/1737930880_MbxTmzgAII.png') }}" alt="Poster Event"
                            style="width: 100%; max-width: 200px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                    </div>
                
                    <!-- Kolom Tengah: Info Event -->
                    <div class="col-md-7" style="text-align: start !important">
                        <h5 class="fw-bold" style="color: #273A8B;">EUFESTUN - Euphoria Festival Butun</h5>
                        <p class="text-muted mb-1" style="background-image: linear-gradient(to right, #EEAE18 , rgba(255, 99, 71, 0)); border-radius: 5px; padding: 0.7%; width: 20%; font-weight: bold; color: #273A8B !important; font-style:italic; font-size: 0.9rem;">
                            Berlangsung
                        </p>
                
                        <div class="d-flex mt-4">
                            <img src="{{ asset('images/date.png') }}" style="width: auto !important; height: 25px; margin-right:5px">
                            <p class="text-muted mb-1 " style="color: #273A8B !important;"> 23 Desember 2023</p>
                        </div>
                        <div class="d-flex">
                            <img src="{{ asset('images/location.png') }}" alt="" style="width: auto !important; height: 23px; margin-right:8px"> 
                            <span class="text-muted mb-1 " style="color: #273A8B !important;"> SMKN 2 KOTA BEKASI</span>
                        </div>
                        <div class="d-flex">
                            <img src="{{ asset('images/clock.png') }}" alt="" style="width: auto !important; height: 23px;margin-right:7px"> 
                            <span class="text-muted mb-1 " style="color: #273A8B !important;"> 09:00 - 17:00 WIB</span>
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
                        <a href="#" class="btn btn-primary mt-3" style="background-color: #273A8B; border-radius: 8px; padding: 8px 15px; border: 0 !important;">
                            Lihat E-Tiket
                        </a>
                    </div>
                </div>                
            </div>
        </div>
    </section>
@endsection
@section('script')

@endsection