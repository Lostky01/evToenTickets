@extends('layouts.app-default')
@section('Title')
    Edit Siswa
@endsection
@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Siswa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update-siswa', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- NIS -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="nis">NIS:</label>
                                    <input type="text" class="form-control" id="nis" name="nis" value="{{ $siswa->nis }}" required>
                                </div>

                                <!-- Nama -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="name">Nama:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $siswa->name }}" required>
                                </div>

                                <!-- Kelas -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="kelas">Kelas:</label>
                                    <select class="form-control" id="kelas" name="kelas" required>
                                        <option value="X" {{ $siswa->kelas == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ $siswa->kelas == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ $siswa->kelas == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                </div>

                                <!-- Jurusan -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="jurusan">Jurusan:</label>
                                    <select class="form-control" id="jurusan" name="jurusan" required>
                                        <option value="Akuntansi" {{ $siswa->jurusan == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                        <option value="Teknik Komputer Jaringan" {{ $siswa->jurusan == 'Teknik Komputer Jaringan' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                        <option value="Rekayasa Perangkat Lunak" {{ $siswa->jurusan == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                        <option value="Teknik Elektronika Industri" {{ $siswa->jurusan == 'Teknik Elektronika Industri' ? 'selected' : '' }}>Teknik Elektronika Industri</option>
                                        <option value="Teknik Energi Terbarukan" {{ $siswa->jurusan == 'Teknik Energi Terbarukan' ? 'selected' : '' }}>Teknik Energi Terbarukan</option>
                                        <option value="Teknik Bisnis Sepeda Motor" {{ $siswa->jurusan == 'Teknik Bisnis Sepeda Motor' ? 'selected' : '' }}>Teknik Bisnis Sepeda Motor</option>
                                    </select>
                                </div>

                                <!-- No Kelas -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="no_kelas">No Kelas:</label>
                                    <select class="form-control" id="no_kelas" name="no_kelas" required>
                                        <option value="1" {{ $siswa->no_kelas == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $siswa->no_kelas == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $siswa->no_kelas == '3' ? 'selected' : '' }}>3</option>
                                        <option value="Industri" {{ $siswa->no_kelas == 'Industri' ? 'selected' : '' }}>Industri</option>
                                    </select>
                                </div>

                                <!-- Password (Opsional, bisa dikosongin) -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="password">Password (min. 6 huruf atau angka / Kosongkan jika tidak ingin mengubah):</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Siswa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
