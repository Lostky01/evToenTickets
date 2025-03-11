<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/mona-sans-2" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-header-mini.png') }}">
    
    <style>
        body {
            background-color: #EFF2F5;
            font-family: 'Mona-Sans', sans-serif;
        }
        .otp-input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            margin: 0 10px;
            border: 2px solid #29366D;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <section class="main">
        <div class="container mt-5">
            <center><img src="{{ asset('images/logo-header.png') }}" alt="" height="90"></center>
            <div class="row justify-content-center mt-5 m-0 p-0">
                <div class="col-md-5 p-0">
                    <div class="card shadow p-4 text-center">
                        <div class="card-body">
                            <h3 style="color: #29366D; font-weight: 600;">Verifikasi OTP</h3>
                            <p class="mb-4">Masukkan kode OTP yang telah dikirim ke email Anda</p>
                            <form action="{{ route('otp.verifyreset') }}" method="post">
                                @csrf
                                <div class="d-flex justify-content-center">
                                    <input type="text" class="otp-input form-control" maxlength="1" id="otp1" name="otp[]" required>
                                    <input type="text" class="otp-input form-control" maxlength="1" id="otp2" name="otp[]" required>
                                    <input type="text" class="otp-input form-control" maxlength="1" id="otp3" name="otp[]" required>
                                    <input type="text" class="otp-input form-control" maxlength="1" id="otp4" name="otp[]" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-4" style="width: 100%; background-color: #29366D;">Verifikasi</button>
                            </form>
                            <p class="text-center mt-3">Tidak menerima kode? <a href="#" style="color: #29366D !important; text-decoration:none; font-weight: bold;">Kirim ulang</a></p>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll(".otp-input");
        inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && index > 0 && !e.target.value) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
</html>
