@extends('layouts.app-default')
@section('Title')
    Edit Event
@endsection

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Edit Event</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('edit-store', $data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Penting untuk update -->
                                <div class="row">
                                    <!-- Event Name -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="event_name">Nama Event:</label>
                                        <input type="text" class="form-control" id="event_name" name="event_name"
                                            value="{{ old('event_name', $data->event_name) }}" required>
                                    </div>

                                    <!-- Event Type -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="event_type">Tipe Event:</label>
                                        <select class="form-control" id="event_type" name="event_type" required>
                                            <option value="Umum" {{ $data->event_type == 'Umum' ? 'selected' : '' }}>Umum</option>
                                            <option value="Tidak Umum" {{ $data->event_type == 'Tidak Umum' ? 'selected' : '' }}>Tidak Umum</option>
                                        </select>
                                    </div>

                                    <!-- Event Price -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="event_price">Event Price:</label>
                                        <input type="number" class="form-control" id="event_price" name="event_price"
                                            value="{{ old('event_price', $data->event_price) }}" required>
                                    </div>

                                    <!-- Quota for Public -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="quota">Quota Untuk Publik:</label>
                                        <input type="number" class="form-control" id="quota" name="quota"
                                            value="{{ old('quota', $data->quota_for_public) }}">
                                    </div>

                                    <!-- Poster -->
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="poster">Poster (Optional):</label>
                                        <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
                                        @if ($data->poster)
                                            <p class="mt-2">Current Poster:</p>
                                            <img src="{{ asset('poster/' . $data->poster) }}" alt="Poster" style="max-width: 200px;">
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update Event</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
