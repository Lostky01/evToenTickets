@extends('layouts.app-default')
@section('Title')
Add Event        
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
                                                <option value="Umum">Umum</option>
                                                <option value="Tidak Umum">Tidak Umum</option>
                                            </select>
                                        </div>

                                        <!-- Event Price -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="event_price">Event Price:</label>
                                            <input type="number" class="form-control" id="event_price" name="event_price"
                                                placeholder="Event Price" required>
                                        </div>

                                        <!-- Quota for Public (optional) -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="quota_for_public">Quota for Public:</label>
                                            <input type="number" class="form-control" id="quota_for_public" name="quota_for_public"
                                                placeholder="Quota for Public (optional)">
                                        </div>

                                        <!-- Event Date -->
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="event_date">Tanggal</label>
                                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                                        </div>

                                        <!-- Event Description (Quill Editor) -->
                                        <div class="form-group col-md-12">
                                            <label class="form-label" for="description">Deskripsi</label>
                                            <div id="editor"></div>
                                            <input type="hidden" name="event_description" id="event_description">
                                        </div>

                                        <!-- Poster (Optional) -->
                                        <div class="form-group col-md-12" style="margin-top:7%">
                                            <label class="form-label" for="poster">Poster (Optional):</label>
                                            <input type="file" class="dropify" id="poster" name="poster" accept="image/*">
                                        </div>

                                        <!-- Social Media Links (Optional) -->
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="ig_link">Instagram Link (optional):</label>
                                            <input type="url" class="form-control" id="ig_link" name="ig_link" placeholder="Instagram URL">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="twitter_link">Twitter Link (optional):</label>
                                            <input type="url" class="form-control" id="twitter_link" name="twitter_link" placeholder="Twitter URL">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="yt_link">YouTube Link (optional):</label>
                                            <input type="url" class="form-control" id="yt_link" name="yt_link" placeholder="YouTube URL">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="tiktok_link">TikTok Link (optional):</label>
                                            <input type="url" class="form-control" id="tiktok_link" name="tiktok_link" placeholder="TikTok URL">
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
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
<!-- Initialize Quill editor -->
<script>
  const quill = new Quill('#editor', {
    theme: 'snow'
  });
  $('.dropify').dropify();
  
  document.querySelector('form').addEventListener('submit', function() {
    document.querySelector('#event_description').value = quill.root.innerHTML;
    
  });
</script>
@endsection
