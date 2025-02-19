@extends('layouts.app-default')
@section('Title', 'Add Budget')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Add Budget</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('budgets.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="month">Month</label>
                                <input type="text" class="form-control" id="month" name="month" required>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" id="year" name="year" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Budget</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
