@extends('layouts.app-home')
@section('Title')
    Checkout
@endsection
@section('style')
    <style>
        body {
            background-color: #EFF2F5;
            color: #273A8B !important;
        }
    </style>
@endsection
@section('content')
    <div style="margin-top: 4%;">
        <span>Beranda > {{ $event->event_name }} > </span> 
        <span style="color: #273A8B; font-weight: bold;">Pemesanan Tiket Konser</span>
    </div>
    <section style="padding: 3%">
        <div class="container p-5" style="background-color: white; border-radius: 15px; margin-top: 4%; width: 70% !important;">
            <center>
                <h3 style="font-weight: bold; color:#273A8B;">Pemesanan Tiket Konser</h3>
                <div class="alert alert-warning d-flex mt-3" style="width: 70%">
                    <i class='bx bxs-error-alt mt-3 mx-3' style="font-size: 2rem; color: #AD943F;"></i>
                    <span class="fw-bold" style="text-align: left; color: #AD943F;;">
                        Validasi data-data mu
                        <br> 
                        <span class="fw-normal">
                            Stok tiket di pesanan mu terbatas, segera periksa ulang data agar tidak salah dan segera bayar biar nggak kehabisan tiketnya! 
                        </span> 
                    </span>
                </div>
                <form action="{{ route('checkout', $event->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Status</label>
                        <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                            placeholder="{{ optional(auth('admin')->user())->user_type == 'Admin' ? 'Khusus' : optional(auth()->user())->user_type }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="status" class="fw-bold" style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Nama</label>
                        <input readonly type="text" style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                            placeholder="{{ auth('admin')->check() ? 'Admin' : optional(auth()->user())->name  }}">
                    </div>
                    @if(optional(auth()->user())->user_type == 'External' || optional(auth('admin')->user()))
                        <div class="form-group mt-4">
                            <label for="status" class="fw-bold"
                                style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Email</label>
                            <input readonly type="text"
                                style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                                placeholder="{{ optional(auth()->user())->email ?? optional(auth('admin')->user())->email }}">
                        </div>
                    @endif
                    @if(optional(auth()->user())->user_type == 'Siswa')
                        <div class="form-group mt-4">
                            <label for="status" class="fw-bold"
                                style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">NIS</label>
                            <input readonly type="text"
                                style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                                placeholder="{{ optional(auth()->user())->nis }}">
                        </div>
                    @endif
                    @if(optional(auth()->user())->user_type == 'Siswa')
                        <div class="form-group mt-4">
                            <label for="status" class="fw-bold"
                                style="display: block; text-align: left; margin-bottom: 5px; color: #273A8B;">Kelas</label>
                            <input readonly type="text"
                                style="width: 100%; border-radius: 10px; border: 0; background-color: #EFF2F5; padding: 1rem;"
                                placeholder="{{ optional(auth()->user())->kelas . ' ' . optional(auth()->user())->jurusan . ' ' . optional(auth()->user())->no_kelas }}">
                        </div>
                    @endif
                    <h4 style="color: #273A8B; text-align: start;" class="fw-bold mt-5">Detail Tiket</h4>

                    <div class="row mt-3 align-items-center">
                        <!-- Kolom Kiri: Poster Event -->
                        <div class="col-md-2 text-start">
                            <img src="{{ asset('poster/' . $event->poster) }}" alt="Poster Event"
                                style="width: 100%; max-width: 200px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                        </div>
                    
                        <!-- Kolom Kanan: Detail Tiket -->
                        <div class="col-md-10" style="text-align: start !important">
                            <h5 class="fw-bold" style="color: #273A8B;">{{ $event->event_name }}</h5>
                            <p class="text-muted mb-1"><i class='bx bx-calendar'></i> {{ date('d M Y', strtotime($event->event_date)) }}</p>
                            <p class="text-muted mb-1"><i class='bx bx-map'></i>SMKN 2 KOTA BEKASI</p>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <span>Harga Tiket</span>
                                <span class="fw-bold" style="color: #273A8B;">Rp {{ number_format($event->event_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <span>Qty</span>
                                <span>1</span>
                            </div>
                            <div class="d-flex justify-content-between mt-5">
                                <span class="fw-bold">Subtotal</span>
                                <span class="fw-bold" style="color: #273A8B;">Rp {{ number_format($event->event_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4" style="width: 100%; border-radius: 10px; background-color: #273A8B; padding: 1rem; font-weight: bold;">Pesan Tiket</button>
                </form>            
            </center>
        </div>
    </section>
@endsection
@section('script')
@endsection
