<div class="main-panel">

    <!-- =========================
         NAVBAR
    ========================== -->
    <nav class="navbar navbar-expand-lg sticky-top gt-navbar">

        <div class="container">

            <!-- =========================
                 BRAND / 3 LOGO
            ========================== -->
            <a class="navbar-brand gt-navbar-brand" href="{{ route('home') }}">

                <div class="gt-logo-group">

                    <!-- Logo 1 -->
                    <div class="gt-logo-box">
                        <img src="{{ asset('penjamu/images/logo.png') }}" alt="Logo 1" class="gt-logo gt-logo-1">
                    </div>

                    <!-- Divider -->
                    <span class="gt-logo-divider"></span>

                    <!-- Logo 2 -->
                    <div class="gt-logo-box">
                        <img src="{{ asset('penjamu/images/logo2.png') }}" alt="Logo 2" class="gt-logo gt-logo-2">
                    </div>

                    <!-- Divider -->
                    <span class="gt-logo-divider"></span>

                    <!-- Logo 3 -->
                    <div class="gt-logo-box">
                        <img src="{{ asset('penjamu/images/logo3.png') }}" alt="Logo 3" class="gt-logo gt-logo-3">
                    </div>

                </div>

                <!-- Brand Text -->
                <div class="gt-brand-text">

                    <div class="gt-brand-name">
                        Go Tube
                    </div>

                    <div class="gt-brand-subtitle">
                        Monitoring System
                    </div>

                </div>

            </a>


            <!-- =========================
                 MOBILE TOGGLE
            ========================== -->
            <button class="navbar-toggler gt-navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- =========================
                 NAVIGATION
            ========================== -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <!-- Profil -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle gt-profile-toggle" href="#" id="auditDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <span class="gt-profile-text">

                                Selamat Datang,

                                @auth
                                    {{ auth()->user()->name }}
                                @else
                                    User
                                @endauth

                            </span>

                            <span class="gt-profile-icon">
                                <i class="fas fa-user"></i>
                            </span>

                        </a>


                        <!-- Dropdown -->
                        <div class="dropdown-menu dropdown-menu-end gt-profile-dropdown">

                            <a class="dropdown-item" href="{{ route('home') }}">

                                <i class="fas fa-home"></i>
                                Halaman Utama

                            </a>


                            <a class="dropdown-item" href="{{ route('profile.edit') }}">

                                <i class="fas fa-user-edit"></i>
                                Edit Profil

                            </a>


                            @auth

                                @if (auth()->user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('users.index') }}">

                                        <i class="fas fa-users-cog"></i>
                                        Kelola User

                                    </a>
                                @endif

                            @endauth


                            <div class="dropdown-divider"></div>


                            <a class="dropdown-item gt-logout" href="{{ route('logout') }}">

                                <i class="fas fa-sign-out-alt"></i>
                                Logout

                            </a>

                        </div>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- =========================
         NAVBAR STYLE
    ========================== -->
    <style>
        /* =========================================
           NAVBAR UTAMA
        ========================================= */

        .gt-navbar {
            background: rgba(255, 255, 255, 0.97) !important;
            border-bottom: 1px solid rgba(2, 78, 127, 0.08);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);

            min-height: 76px;

            z-index: 1050;

            transition:
                background 0.3s ease,
                box-shadow 0.3s ease;
        }


        /* =========================================
           BRAND
        ========================================== */

        .gt-navbar-brand {

            display: flex !important;

            align-items: center;

            gap: 14px;

            padding-top: 5px;
            padding-bottom: 5px;

            text-decoration: none;

            margin-right: 20px;
        }


        /* =========================================
           GROUP 3 LOGO
        ========================================== */

        .gt-logo-group {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            flex-shrink: 0;
        }


        /* =========================================
           BOX LOGO
        ========================================== */

        .gt-logo-box {

            width: 100px;
            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;
        }


        /* =========================================
           LOGO
        ========================================== */

        .gt-logo {

            display: block;

            width: auto;
            height: auto;

            max-width: 58px;
            max-height: 48px;

            object-fit: contain;

            transition:
                transform 0.25s ease,
                opacity 0.25s ease;
        }


        .gt-logo:hover {

            transform: scale(1.05);

            opacity: 0.92;
        }


        /* Logo individual
           Bisa disesuaikan kalau ukuran file berbeda */

        .gt-logo-1 {
            max-width: 100px;
            max-height: 84px;
        }

        .gt-logo-2 {
            max-width: 100px;
            max-height: 84px;
        }

        .gt-logo-3 {
            max-width: 152px;
            max-height: 136px;
        }


        /* =========================================
           PEMISAH ANTAR LOGO
        ========================================== */

        .gt-logo-divider {

            width: 1px;

            height: 34px;

            background: rgba(2, 78, 127, 0.18);

            flex-shrink: 0;
        }


        /* =========================================
           BRAND TEXT
        ========================================== */

        .gt-brand-text {

            display: flex;

            flex-direction: column;

            justify-content: center;

            line-height: 1.1;

            white-space: nowrap;
        }


        .gt-brand-name {

            font-size: 19px;

            font-weight: 800;

            color: #024E7F;

            letter-spacing: -0.3px;
        }


        .gt-brand-subtitle {

            margin-top: 4px;

            font-size: 11px;

            font-weight: 500;

            color: #3BA484;

            letter-spacing: 0.7px;

            text-transform: uppercase;
        }


        /* =========================================
           PROFILE
        ========================================== */

        .gt-profile-toggle {

            display: flex !important;

            align-items: center;

            gap: 9px;

            color: #024E7F !important;

            font-size: 14px;

            font-weight: 600;

            padding: 10px 12px !important;

            border-radius: 10px;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }


        .gt-profile-toggle:hover {

            background: rgba(2, 78, 127, 0.06);

            color: #024E7F !important;
        }


        .gt-profile-icon {

            width: 34px;

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: rgba(59, 164, 132, 0.12);

            color: #3BA484;

            flex-shrink: 0;
        }


        /* =========================================
           DROPDOWN
        ========================================== */

        .gt-profile-dropdown {

            min-width: 220px;

            margin-top: 8px !important;

            padding: 8px;

            border: 1px solid rgba(2, 78, 127, 0.08);

            border-radius: 12px;

            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);

            background: #ffffff;
        }


        .gt-profile-dropdown .dropdown-item {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px 12px;

            border-radius: 8px;

            color: #334155;

            font-size: 14px;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }


        .gt-profile-dropdown .dropdown-item i {

            width: 18px;

            text-align: center;

            color: #024E7F;
        }


        .gt-profile-dropdown .dropdown-item:hover {

            background: rgba(2, 78, 127, 0.07);

            color: #024E7F;
        }


        .gt-profile-dropdown .dropdown-item:hover i {

            color: #3BA484;
        }


        /* =========================================
           LOGOUT
        ========================================== */

        .gt-profile-dropdown .gt-logout {

            background: #dc3545;

            color: #ffffff !important;

            margin-top: 4px;
        }


        .gt-profile-dropdown .gt-logout i {

            color: #ffffff !important;
        }


        .gt-profile-dropdown .gt-logout:hover {

            background: #bb2d3b;

            color: #ffffff !important;
        }


        /* =========================================
           NAVBAR TOGGLER
        ========================================== */

        .gt-navbar-toggler {

            border: 1px solid rgba(2, 78, 127, 0.15);

            border-radius: 9px;

            padding: 7px 9px;

            box-shadow: none !important;
        }


        .gt-navbar-toggler:focus {

            box-shadow: 0 0 0 3px rgba(59, 164, 132, 0.15) !important;
        }


        /* =========================================
           TABLET
           max-width 991px
        ========================================== */

        @media (max-width: 991.98px) {

            .gt-navbar {

                min-height: 70px;
            }


            .gt-navbar-brand {

                gap: 11px;

                margin-right: 10px;
            }


            .gt-logo-group {

                gap: 6px;
            }


            .gt-logo-box {
                width: 105px;
                height: 48px;
            }

            .gt-logo {
                max-width: 85px;
                max-height: 44px;
            }


            .gt-logo-1 {
                max-width: 105px;
                max-height: 64px;
            }

            .gt-logo-2 {
                max-width: 105px;
                max-height: 64px;
            }

            .gt-logo-3 {
                max-width: 160px;
                max-height: 105px;
            }

            .gt-logo-divider {

                height: 30px;
            }


            .gt-brand-name {

                font-size: 17px;
            }


            .gt-brand-subtitle {

                font-size: 10px;
            }


            .gt-profile-toggle {

                margin-top: 8px;

                padding: 10px 12px !important;
            }


            .gt-profile-dropdown {

                margin-top: 4px !important;
            }


        }


        /* =========================================
           MOBILE
           max-width 767px
        ========================================== */

        @media (max-width: 767.98px) {

            .gt-navbar {

                min-height: 64px;
            }


            .gt-navbar-brand {

                gap: 0;

                margin-right: 8px;

                max-width: calc(100% - 55px);
            }


            /* 3 logo tetap tampil */

            .gt-logo-group {

                gap: 4px;
            }


            .gt-logo-box {
                width: 78px;
                height: 42px;
            }

            .gt-logo {
                max-width: 58px;
                max-height: 40px;
            }

            .gt-logo-1 {
                max-width: 78px;
                max-height: 60px;
            }

            .gt-logo-2 {
                max-width: 78px;
                max-height: 60px;
            }

            .gt-logo-3 {
                max-width: 135px;
                max-height: 105px;
            }


            .gt-logo-divider {

                height: 25px;

                background: rgba(2, 78, 127, 0.14);
            }


            /* Teks disembunyikan di HP */

            .gt-brand-text {

                display: none;
            }


            /* Navbar menu */

            .navbar-collapse {

                margin-top: 8px;

                padding-top: 8px;

                border-top: 1px solid rgba(2, 78, 127, 0.08);
            }


            .gt-profile-toggle {

                justify-content: flex-start;

                width: 100%;

                margin-top: 0;
            }


            .gt-profile-text {

                font-size: 13px;
            }


            .gt-profile-icon {

                width: 32px;

                height: 32px;
            }


            .gt-profile-dropdown {

                width: 100%;

                box-shadow: none;

                border-radius: 10px;

                margin-top: 3px !important;
            }

        }


        /* =========================================
           HP KECIL
           max-width 480px
        ========================================== */

        @media (max-width: 480px) {

            .gt-navbar {

                min-height: 60px;
            }


            .gt-navbar .container {

                padding-left: 12px;

                padding-right: 12px;
            }


            .gt-logo-group {

                gap: 2px;
            }


            .gt-logo-box {
                width: 72px;
                height: 38px;
            }

            .gt-logo {
                max-width: 52px;
                max-height: 36px;
            }

            .gt-logo-1 {
                max-width: 72px;
                max-height: 56px;
            }

            .gt-logo-2 {
                max-width: 72px;
                max-height: 56px;
            }

            .gt-logo-3 {
                max-width: 108px;
                max-height: 82px;
            }


            .gt-logo-divider {

                height: 22px;

                margin: 0 1px;
            }


            .gt-navbar-toggler {

                padding: 6px 8px;
            }

        }


        /* =========================================
           HP SANGAT KECIL
           max-width 360px
        ========================================== */

        @media (max-width: 360px) {

            .gt-logo-box {
                width: 66px;
                height: 35px;
            }

            .gt-logo {
                max-width: 46px;
                max-height: 33px;
            }

            .gt-logo-1 {
                max-width: 76px;
                max-height: 53px;
            }

            .gt-logo-2 {
                max-width: 66px;
                max-height: 53px;
            }

            .gt-logo-3 {
                max-width: 100px;
                max-height: 78px;
            }


            .gt-logo-divider {

                height: 20px;
            }

        }
    </style>


    <!-- =========================
         NAVBAR SCROLL
    ========================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let navbar = document.querySelector(".gt-navbar");

            function updateNavbar() {

                if (!navbar) return;

                if (window.scrollY > 50) {

                    navbar.classList.add("scrolled");

                    navbar.classList.remove("transparent");

                } else {

                    navbar.classList.add("transparent");

                    navbar.classList.remove("scrolled");

                }

            }

            window.addEventListener("scroll", updateNavbar);

            updateNavbar();

        });
    </script>

</div>
