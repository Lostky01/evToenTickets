@extends('layouts.app-default')
@section('Title')
    Kelola Event
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
                            <h4 class="card-title">List Event</h4>
                        </div>
                        <div class="d-flex justify-items-end"><a href="{{ route('create') }}" class="btn btn-primary" style="background-color: #273A8B">+ Tambah Event</a></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Poster</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal Event</th>
                                        <th>Harga</th>
                                        <th>Kuota Untuk Publik</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @if($item->poster)
                                            <td><img src="{{ asset('poster/' . $item->poster) }}" width="100" height="100"></td>
                                            @else
                                            <td>No Poster</td>
                                            @endif
                                            <td>{{ $item->event_name }}</td>
                                            <td>{{ $item->event_date }}</td>
                                            <td>Rp{{ number_format($item->event_price, 0, ',', '.') }}</td>
                                            <td>{{ $item->quota_for_public }}</td>
                                            <td>
                                                <a href="{{ route('edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Poster</th>
                                        <th>Event Name</th>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Kuota Untuk Publik</th>
                                        <th>Action</th>
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
