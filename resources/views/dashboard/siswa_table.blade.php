@extends('layouts.app-default')
@section('Title')
    Tabel Siswa
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
                            <h4 class="card-title">List Siswa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Password</th>
                                        <th>Tipe User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>{{ $item->kelas . ' ' . $item->jurusan . ' ' . $item->no_kelas }}</td>
                                            <td>{{ $item->password }}</td>
                                            <td>{{ $item->user_type }}</td>
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
                                        <th>Event Name</th>
                                        <th>Price</th>
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
