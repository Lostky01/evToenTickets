@extends('layouts.app-default')

@section('Title')
    Riwayat Transaksi
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
                            <h4 class="card-title">Riwayat Transaksi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Tipe User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                @if ($item->admin_id)
                                                    Admin melakukan validasi tiket untuk event {{ $item->event->name }}
                                                @else
                                                    {{ $item->user->name }} melakukan pembelian tiket untuk event {{ $item->event->event_name }} pada {{ $item->created_at->format('d-m-Y H:i') }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->admin_id ? 'Admin' : $item->user->user_type }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Tipe User</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
