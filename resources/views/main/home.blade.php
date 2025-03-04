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
</style>
@endsection
@section('content')
    <section class="p-5">
        <div class="container-fluid p-5" style="background-color:white; border-radius: 10px;">
            <img src="{{ asset('images/baneratas.png') }}" alt="" style="width: auto; height:auto">
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
            
        </div>
    </section>

@endsection
@section('script')

@endsection
