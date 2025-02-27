@extends('layouts.app-default')
@section('Title')
    Edit Event
@endsection
@section('style')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css" />
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
                                @method('PUT') <!-- Untuk update data -->
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
                                        <label class="form-label" for="event_price">Harga Event:</label>
                                        <input type="number" class="form-control" id="event_price" name="event_price"
                                            value="{{ old('event_price', $data->event_price) }}" required>
                                    </div>

                                    <!-- Quota for Public -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="quota">Kuota Publik:</label>
                                        <input type="number" class="form-control" id="quota" name="quota"
                                            value="{{ old('quota', $data->quota_for_public) }}">
                                    </div>

                                    <!-- Event Description -->
                                    <div class="form-group col-md-12" style="margin-bottom:7%">
                                        <label class="form-label" for="event_desc">Deskripsi Event:</label>
                                        <input type="hidden" name="event_desc" id="event_desc" value="{{ old('event_description', $data->event_description) }}">
                                        <div id="quill-editor">{{ $data->event_description }}</div>
                                    </div>

                                    <!-- Social Media Links -->
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="ig_link">Instagram:</label>
                                        <input type="url" class="form-control" id="ig_link" name="ig_link"
                                            value="{{ old('ig_link', $data->ig_link) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="twitter_link">Twitter/X:</label>
                                        <input type="url" class="form-control" id="twitter_link" name="twitter_link"
                                            value="{{ old('twitter_link', $data->twitter_link) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="yt_link">YouTube:</label>
                                        <input type="url" class="form-control" id="yt_link" name="yt_link"
                                            value="{{ old('yt_link', $data->yt_link) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="tiktok_link">TikTok:</label>
                                        <input type="url" class="form-control" id="tiktok_link" name="tiktok_link"
                                            value="{{ old('tiktok_link', $data->tiktok_link) }}">
                                    </div>

                                     <!-- Poster Upload (Dropify) -->
                                     <div class="form-group col-md-12">
                                        <label class="form-label" for="poster">Poster (Optional):</label>
                                        <input type="file" class="dropify" id="poster" name="poster" accept="image/*"
                                            data-default-file="{{ $data->poster ? asset('poster/' . $data->poster) : '' }}">
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow'
    });
    $('.dropify').dropify();

    quill.on('text-change', function() {
        document.querySelector("input[name='event_desc']").value = quill.root.innerHTML;
    });

    // Load existing content
    document.addEventListener("DOMContentLoaded", function() {
        quill.root.innerHTML = document.querySelector("input[name='event_desc']").value;
    });
</script>
@endsection
