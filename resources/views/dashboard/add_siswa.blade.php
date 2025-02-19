@extends('layouts.app-default')
@section('Title')
    Add Siswa
@endsection
@section('content')
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Add New Siswa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create-siswa') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- NIS -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="nis">NIS:</label>
                                    <input type="text" class="form-control" id="nis" name="nis" required>
                                </div>

                                <!-- Nama -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="name">Nama:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <!-- Kelas -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="kelas">Kelas:</label>
                                    <select class="form-control" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                </div>

                                <!-- Jurusan -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="jurusan">Jurusan:</label>
                                    <select class="form-control" id="jurusan" name="jurusan" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="Akuntansi">Akuntansi</option>
                                        <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                        <option value="Teknik Elektronika Industri">Teknik Elektronika Industri</option>
                                        <option value="Teknik Energi Terbarukan">Teknik Energi Terbarukan</option>
                                        <option value="Teknik Bisnis Sepeda Motor">Teknik Bisnis Sepeda Motor</option>
                                    </select>
                                </div>

                                <!-- No Kelas -->
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="no_kelas">No Kelas:</label>
                                    <select class="form-control" id="no_kelas" name="no_kelas" required>
                                        <option value="">Pilih No Kelas</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="Industri">Industri</option>
                                    </select>
                                </div>

                                <!-- Password -->
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Save Siswa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
