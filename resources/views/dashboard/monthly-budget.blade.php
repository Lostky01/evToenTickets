@extends('layouts.app-default')
@section('Title', 'Monthly Budget')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Monthly Budget</h4>
                            <a href="{{ route('budgets.create') }}" class="btn btn-primary">Add Budget</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($budgets as $index => $budget)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $budget->month }}</td>
                                            <td>{{ $budget->year }}</td>
                                            <td>Rp{{ number_format($budget->amount, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('budgets.edit', $budget->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
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
