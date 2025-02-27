<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evtoen Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/mona-sans-2" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-header-mini.png') }}">
    <style>
        body {
            background-color: #EFF2F5;
            font-family: 'Mona-Sans', sans-serif;
        }
    </style>
</head>
<body>
    <section class="main">
        <div class="container mt-5" style="border-radius: 15px; padding: 2%;">
            <center><img src="{{ asset('images/logo-header.png') }}" alt="Evtoen Logo" height="60"></center>
            <div class="container p-4 mt-5" style="background: white; border-radius: 10px;">
                <h4 class="fw-bold" style="color: #29366D;">Registrasi Akun</h4>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="email" class="mb-2" style="font-weight: 500; color: #29366D">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="password" class="mb-2" style="font-weight: 500; color: #29366D">Kata Sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan kata sandi">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-4" style="width: 100%; background-color: #29366D;">Daftar</button>
                </form>
                <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login-menu') }}" style="color: #29366D; font-weight: bold; text-decoration: none;">Masuk di sini</a></p>
            </div>            
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
