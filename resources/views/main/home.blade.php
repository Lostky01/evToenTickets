@extends('layouts.app-home')
@section('Title')
    Home
@endsection
@section('style')
<style>
    .card-title {
        color: #273A8B;
    }
    .card-text {
        color: #7D829B;
    }
    .active {
        background-color: rgba(red, green, blue, 0) !important;
    }
</style>
@endsection
@section('content')
    <section class="p-5">
        <div class="container p-5" style="background-color:white; border-radius: 10px;">
           
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" style="background-color: rgba(red, green, blue, 0) !important;">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ asset('images/baneratas.png') }}" alt="" style="width: 1200px; height:auto">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('images/baneratas2.png') }}" alt="" style="width: 1200px; height:auto">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            <span class="activee mt-5">
                <h5 class="fw-bold mt-5" href="" style="color: #273A8B;">Konser Tersedia</h5>
            </span>
            <div class="row mt-4">
                @foreach($event as $e)
                    <div class="col-3">
                        <div class="card" style="width: 15rem; border: 0 !important;">
                            <img src="{{ asset('poster/' . $e->poster) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title">{{ $e->event_name }}</h6>
                                <p class="card-text" style="font-size:0.8rem">SMKN 2 KOTA BEKASI</p>
                                <p class="card-text fw-bold" style="color: #273A8B !important;">Rp {{ number_format($e->event_price, 0, ',', '.') }}</p>
                                <a href="{{ route('detail-event', $e->id) }}" class="btn btn-primary" style="background-color: #273A8B; border: 0 !important; width: 100%;">Detail Event</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>-
        <div class="container" style="margin-top:10%">
            <center><span style="color: #7D829B">Evtoen ©
                    <script>document.write(new Date().getFullYear())</script>. All copyrights belong to 3R gen 19
                </span></center>
            <div class="col-12 mt-3 d-flex justify-content-center mx-auto">
                    <a class="mx-2" href=""><img src="{{ asset('images/ig_white.png') }}" alt=""></a>
                    <a class="mx-2" href=""><img src="{{ asset('images/x_white.png') }}" alt=""></a>
                    <a class="mx-2" href=""><img src="{{ asset('images/tiktok_white.png') }}" alt=""></a>
                    <a class="mx-2" href=""><img src="{{ asset('images/youtube_white.png') }}" alt=""></a>
            </div>
        </div>
    </section>
    
@endsection
@section('script')

@endsection
