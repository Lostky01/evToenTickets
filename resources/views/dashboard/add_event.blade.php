@extends('layouts.app-default')
@section('Title')
Add Event        
@endsection
@section('style')
@endsection

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Add New Event</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="new-event-info">
                                <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Event Name -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="event_name">Event Name:</label>
                                            <input type="text" class="form-control" id="event_name" name="event_name"
                                                placeholder="Event Name" required>
                                        </div>

                                        <!-- Event Type (Umum/Tidak Umum) -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="event_type">Event Type:</label>
                                            <select class="form-control" id="event_type" name="event_type" required>
                                                <option value="">Select Event Type</option>
                                                <option value="umum">Umum</option>
                                                <option value="tidak umum">Tidak Umum</option>
                                            </select>
                                        </div>

                                        <!-- Event Price -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="event_price">Event Price:</label>
                                            <input type="number" class="form-control" id="event_price" name="event_price"
                                                placeholder="Event Price" required>
                                        </div>

                                        <!-- Quota for Public -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="quota">Quota for Public:</label>
                                            <input type="number" class="form-control" id="quota" name="quota"
                                                placeholder="Quota for Public (optional)">
                                        </div>

                                        <!-- Poster (Optional) -->
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="poster">Poster (optional):</label>
                                            <input type="file" class="form-control" id="poster" name="poster"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Event</button>
                                </form>
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
