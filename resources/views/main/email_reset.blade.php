<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <div class="container mt-5">
            <center><img src="{{ asset('images/logo-header.png') }}" alt="" height="90"></center>
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <div class="card shadow p-4 text-center">
                        <div class="card-body">
                            <h3 style="color: #29366D; font-weight: 600;">Reset Password</h3>
                            <p class="mb-4">Masukkan email Anda untuk mengatur ulang password</p>
                            
                            <form action="{{ route('password.reset.otp') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background-color: #29366D;">Kirim OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>
</body>
</html>
