@extends('layouts.app-default')
@section('Title')
    Admin Dashboard
@endsection
@section('style')
@endsection

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Menu</h4>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="row mt-5 d-flex justify-content-center">
                            <div class="col-2 mx-2 d-flex align-items-center border rounded p-3" style="border: 2px solid #ccc;">
                                <img src="{{ asset('images/filepeople.png') }}" alt="Kelola User" style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
                                <div>
                                    <span style="display: block; font-weight: bold; font-size: 20px; color: #273A8B;">Kelola User</span>
                                    <span style="display: block; font-size: 14px; color: #666;">Kelola seluruh data pengguna</span>
                                </div>
                            </div>
                            <div class="col-2 mx-2 d-flex align-items-center border rounded p-3" style="border: 2px solid #ccc;">
                                <img src="{{ asset('images/mic-ai.png') }}" alt="Kelola User" style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
                                <div>
                                    <span style="display: block; font-weight: bold; font-size: 20px; color: #273A8B;">Kelola Event</span>
                                    <span style="display: block; font-size: 14px; color: #666;">Optimalkan pengelolaan event</span>
                                </div>
                            </div>
                            <div class="col-2 mx-2 d-flex align-items-center border rounded p-3" style="border: 2px solid #ccc;">
                                <img src="{{ asset('images/ticket.png') }}" alt="Kelola User" style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
                                <div>
                                    <span style="display: block; font-weight: bold; font-size: 20px; color: #273A8B;">Status Tiket</span>
                                    <span style="display: block; font-size: 14px; color: #666;">Kelola pembelian tiket</span>
                                </div>
                            </div> 
                            <div class="col-3 mx-2 d-flex align-items-center border rounded p-3" style="border: 2px solid #ccc;">
                                <img src="{{ asset('images/history.png') }}" alt="Kelola User" style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
                                <div>
                                    <span style="display: block; font-weight: bold; font-size: 20px; color: #273A8B;">Riwayat transaksi</span>
                                    <span style="display: block; font-size: 14px; color: #666;">Riwayat transaksi lengkap</span>
                                </div>
                            </div>                                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
