@extends('layouts.app-default')
@section('Title')
    Status Tiket
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
                            <h4 class="card-title">Status Transaksi Tiket</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Nama User</th>
                                        <th>Tipe User</th>
                                        <th>Bukti Transaksi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $index => $transaction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $transaction->transaction_number }}</td>
                                            <td>{{ $transaction->user->name ?? 'Admin' }}</td>
                                            <td>{{ $transaction->user->user_type }}</td>
                                            <td>
                                                <a href="{{ asset('bukti-tf/' . $transaction->bukti_tf) }}" target="_blank">
                                                    <img src="{{ asset('bukti-tf/' . $transaction->bukti_tf) }}" width="50" height="50" alt="Bukti Transfer">
                                                </a>
                                            </td>
                                            <td>
                                                @if ($transaction->is_confirmed)
                                                    <span class="badge bg-success">Terkonfirmasi</span>
                                                @else
                                                    <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$transaction->is_confirmed)
                                                    <form action="{{ route('transaction.confirm', $transaction->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                                    </form>
                                                    <form action="{{ route('transaction.reject', $transaction->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                                    </form>
                                                @else
                                                Sudah di konfirmasi    
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
