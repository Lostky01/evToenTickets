<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('Title') | EVToen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.cdnfonts.com/css/mona-sans" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-header-mini.png') }}">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

        :root {
            --header-height: 3rem;
            --nav-width: 93px;
            --first-color: #4723d9;
            --first-color-light: #afa5d9;
            --white-color: #f7f6fb;
            --body-font: "Nunito", sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100;
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box;
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: 0.5s;
            background-color: #EFF2F5 !important;
            font-family: 'Mona-Sans', sans-serif;                        
        }

        a {
            text-decoration: none;
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: 0.5s;
            background-color: #29366D !important;
        }

        .header_toggle {
            color: #fcfcfc;
            font-size: 2.1rem;
            cursor: pointer;
        }

        .header_img {
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .header_img img {
            width: 40px;
        }

        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: 0.5rem 1rem 0 0;
            transition: 0.5s;
            z-index: var(--z-fixed);
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .nav_logo,
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 2rem;
            padding: 0.5rem 0 0.5rem 1.6rem;
        }

        .nav_logo {
            margin-bottom: 2rem;
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color);
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700;
        }

        .nav_link {
            position: relative;
            color: #29366D;
            margin-bottom: 1.5rem;
            transition: 0.3s;
        }

        .nav_link:hover {
            color: var(--white-color);
        }

        .nav_icon {
            font-size: 1.25rem;
        }

        .show {
            left: 0;
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem);
        }

        .active {
            color: var(--white-color);
            background-color: #29366D !important;
            border-radius: 10px !important;
            width: 85%;
        }

        .active::before {
            content: "";
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color);
        }

        .height-100 {
            height: 100vh;
        }

        @media screen and (min-width: 768px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem);
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
            }

            .header_img {
                width: 40px;
                height: 40px;
            }

            .header_img img {
                width: 45px;
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0;
            }

            .show {
                width: calc(var(--nav-width) + 156px);
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px);
            }

            input.search {
                width: 100%;
                border: 0 !important;
                border-radius: 10px;
                font-size: 16px;
                background-color: white;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='25' height='25' viewBox='0 0 50 50'%3E%3Cpath fill='%2329366D' d='M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z'/%3E%3C/svg%3E");
                background-position: 98% 10px;
                background-repeat: no-repeat;
                padding: 12px 20px 12px 40px;
            }

            .l-navbar:has([style*="left: -30%"]) .menu_evtoen {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <header class="header" id="header">
        <div class="row w-100">
            <div class="col-1">
                <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            </div>
            <div class="col-9">
                <input type="text" class="search" name="search"
                    placeholder="Cari berdasarkan artis, acara, atau nama tempat" style="width:100% ">
            </div>
            @if(auth()->check() || auth('admin')->check())
            <div class="col-2 d-flex align-items-center gap-2">
                <a href=""><img src="{{ asset('images/header-notif.png') }}" alt=""></a>
                <a href=""><img src="{{ asset('images/header-man.png') }}" alt=""></a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary"
                        style="color: #29366D; background-color: #EEAE18; font-weight: bold; border: 0 !important; height: 85%;">
                        <i style="color: #29366D" class='bx bx-log-out bx-rotate-180'></i> Keluar
                    </button>
                </form>
            </div>            
            @else
                <div class="col-2">
                    <button class="btn btn-primary" onclick="{{ route('login-menu') }}"
                        style="color: #f7f6fb; background-color: #415090; font-weight: bold; border: 0 !important; height: 85%; width: 100% auto; margin-right: 2px;">Masuk</button>
                    <button class="btn btn-primary" onclick="window"
                        style="color: #29366D; background-color: #EEAE18; font-weight: bold; border: 0 !important; height: 85%; width: 100% auto;">Daftar</button>
                </div>
            @endif
        </div>
    </header>
    <div class="l-navbar" id="nav-bar" style="background: #f7f6fb !important">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo">
                    <img src="{{ asset('images/logo-header.png') }}" alt="" style="width: auto" height="45" /></a>
                <div class="nav_list">
                    <a href="#" class="nav_link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class='bx bx-home nav_icon'></i>
                        <span class="nav_name">Beranda</span>
                    </a>
                    <a href="{{ route('tiket-saya') }}" class="nav_link">
                        <i class='bx bxs-coupon nav_icon'></i> <span class="nav_name"> Tiket Saya</span>
                    </a>
                    <a href="#" class="nav_link">
                        <i class='bx bx-history nav_icon'></i>
                        <span class="nav_name">History</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="iq-navbar-header" style="height: 215px;">
            <div class="container-fluid iq-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-wrap d-flex justify-content-between align-items-center">
                            <div>
                              @if(request()->routeIs('index'))
                                <h1>Khusus Admin Kelola Event</h1>
                              @endif
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@yield('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("header-toggle");
        const nav = document.getElementById("nav-bar");
        const body = document.body;
        const header = document.getElementById("header");
        const navbar = document.getElementById("nav-bar");
        const menuText = document.querySelector(".menu_evtoen");

        function checkNavbar() {
            const navbarLeft = window.getComputedStyle(navbar).left;
            if (parseInt(navbarLeft) < 0) {
                menuText.style.display = "none";
            } else {
                menuText.style.display = "block";
            }
        }

        // Cek setiap 100ms apakah navbar berubah
        setInterval(checkNavbar, 100);

        if (toggle && nav) {
            toggle.addEventListener("click", () => {
                nav.classList.toggle("show");
                toggle.classList.toggle("bx-x");
                body.classList.toggle("body-pd");
                header.classList.toggle("body-pd");
            });
        } else {
            console.error("Toggle button atau navbar tidak ditemukan!");
        }
    });
</script>

</html>