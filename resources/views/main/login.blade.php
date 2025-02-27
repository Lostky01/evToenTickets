<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evtoen Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/mona-sans" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-header-mini.png') }}">

    <style>
        body {
            background-color: #EFF2F5;
            font-family: 'Mona-Sans', sans-serif !important;
        }
    </style>
</head>

<body>
    <section class="main">
        <div class="container mt-5">
            <center><img src="{{ asset('images/logo-header.png') }}" alt="" style="width: auto" height="90">
            </center>
            <div class="row justify-content-center mt-5 m-0 p-0">
                <div class="col-md-4 p-0">
                    <div class="bg-primary h-100 rounded-0" {{-- background-image: linear-gradient(#29366D, #3A53BE); --}}
                        style="border-radius: 10px !important; background-image: url({{ asset('images/loginbg.png') }}); background-repeat: no-repeat;">
                    </div>
                </div>
                <div class="col-md-4 p-0">
                    <div class="card shadow p-4">
                        <div class="card-body">
                            <h4 class="" style="color: #29366D; font-weight: 600; font-family: 'Mona-Sans', sans-serif !important;">Selamat Datang di Evtoen</h3>
                            <p class="mb-4" style="font-family: 'Mona-Sans', sans-serif !important; font-size: 14px;">Silahkan login atau daftar untuk melanjutkan</p>

                            <!-- Form Login -->
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nisEmail" class="mb-2"
                                        style="font-weight: 500; color: #29366D">NIS/Email</label>
                                    <input type="text" class="form-control @error('nis_email') is-invalid @enderror"
                                        id="nisEmail" name="nis_email" placeholder="NIS/Email"
                                        value="{{ old('nis_email') }}">
                                    @error('nis_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password" class="mb-2" style="font-weight: 500; color: #29366D">Kata
                                        Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Kata sandi">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check mb-3 mt-2 d-flex justify-content-between">
                                    <div>
                                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                        <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                                    </div>
                                    <a href="#" class="btn btn-link text-center"
                                        style="color: #29366D !important; text-decoration:none; font-weight: bold;">Lupa
                                        sandi?</a>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block"
                                    style="width: 100%; background-color: #29366D;">Masuk</button>
                            </form>
                            <p class="text-center mt-3">Tidak punya akun? <a href="{{ route('register-menu') }}"
                                    style="color: #29366D !important; text-decoration:none; font-weight: bold;">Daftar
                                    disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top:10%">
                <center><span style="color: #7D829B">Evtoen ©
                        <script>document.write(new Date().getFullYear())</script>. All copyrights belong to 3R gen 19
                    </span></center>
                <div class="col-12 mt-3 d-flex justify-content-center mx-auto">
                        <a class="mx-2" href=""><img src="{{ asset('images/ig_white.png') }}" alt=""></a>
                        <a class="mx-2" href=""><img src="{{ asset('images/x_white.png') }}" alt=""></a>
                        <a class="mx-2" href=""><img src="{{ asset('images/tiktok_white.png') }}" alt=""></a>
                        <a class="mx-2" href=""><img src="{{ asset('images/youtube_white.png') }}" alt=""></a>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
