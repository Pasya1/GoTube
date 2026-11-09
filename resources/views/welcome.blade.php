@extends('layouts.master')

@section('title', 'Beranda | Go Tube')

@section('content')

    <style>
        /* =========================================================
                                                                                           GO TUBE - RESPONSIVE UI
                                                                                           HANYA TAMPILAN / CSS YANG DISESUAIKAN.
                                                                                           ROUTE, BACKEND, MENU, MODAL, FORM, CAMERA SCANNER,
                                                                                           CAROUSEL, JAVASCRIPT, DAN FITUR UTAMA TETAP.
                                                                                           ========================================================= */

        :root {
            --gt-primary: #024E7F;
            --gt-primary-dark: #013957;
            --gt-primary-light: #0879b5;
            --gt-green: #3BA484;
            --gt-green-dark: #27876b;
            --gt-dark: #102f42;
            --gt-text: #29495b;
            --gt-muted: #718391;
            --gt-soft: #f4f9fb;
            --gt-border: #e4edf2;
            --gt-shadow: 0 20px 55px rgba(1, 57, 87, .10);
            --gt-shadow-hover: 0 25px 65px rgba(1, 57, 87, .16);
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            overflow-x: hidden;
        }

        .content,
        .gt-page {
            width: 100%;
            min-height: 100vh;
            overflow-x: clip;
        }

        .gt-container {
            width: min(1180px, calc(100% - 40px));
            margin-inline: auto;
        }

        img {
            max-width: 100%;
        }

        /* =========================================================
                                                                                           SECTION TITLE
                                                                                           ========================================================= */

        .gt-section {
            position: relative;
            padding: 95px 0;
        }

        .gt-section-title {
            max-width: 700px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .gt-section-title .eyebrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 7px 14px;
            margin-bottom: 14px;
            border-radius: 50px;
            background: #eaf6f3;
            color: var(--gt-green-dark);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .gt-section-title h2 {
            margin: 0;
            color: var(--gt-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.8px;
        }

        .gt-section-title p {
            max-width: 600px;
            margin: 14px auto 0;
            color: var(--gt-muted);
            font-size: .95rem;
            line-height: 1.8;
        }

        /* =========================================================
                                                                                           HERO
                                                                                           ========================================================= */

        #hero {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 8% 10%, rgba(59, 164, 132, .17), transparent 28%),
                radial-gradient(circle at 90% 20%, rgba(255, 255, 255, .12), transparent 30%),
                linear-gradient(135deg, #012f49 0%, #024E7F 48%, #0879b5 100%);
        }

        #hero::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            right: -180px;
            top: -260px;
            pointer-events: none;
        }

        #hero::after {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 50%;
            left: -250px;
            bottom: -300px;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 5;
            padding: clamp(55px, 7vw, 85px) 0 clamp(65px, 8vw, 90px);
        }

        .hero-row {
            display: flex;
            align-items: center;
            gap: clamp(35px, 5vw, 65px);
        }

        .hero-left {
            flex: 1 1 55%;
            min-width: 0;
            margin-top: 5%;
        }

        .hero-right {
            flex: 0 1 440px;
            width: min(440px, 100%);
            min-width: 0;
        }

        .hero-brand {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            max-width: 100%;
            padding: 8px 16px;
            margin-bottom: 22px;
            border: 1px solid rgba(255, 255, 255, .20);
            border-radius: 50px;
            background: rgba(255, 255, 255, .09);
            color: #fff;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .7px;
            backdrop-filter: blur(12px);
        }

        .hero-brand i {
            color: #7de0be;
            flex: 0 0 auto;
        }

        .judul-utama {
            max-width: 650px;
            margin: 0;
            color: #fff;
            font-size: clamp(2.25rem, 5vw, 4.2rem) !important;
            line-height: 1.08;
            font-weight: 800 !important;
            letter-spacing: -1.8px;
            overflow-wrap: anywhere;
        }

        .judul-utama span {
            color: #7de0be;
        }

        .hero-subtitle {
            max-width: 560px;
            margin: 24px 0 0;
            color: rgba(255, 255, 255, .82);
            font-size: 1rem;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 0 21px;
            border-radius: 13px;
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            transition: .25s ease;
        }

        .hero-btn-primary {
            color: var(--gt-primary);
            background: #fff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
        }

        .hero-btn-primary:hover {
            color: var(--gt-primary);
            transform: translateY(-3px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
        }

        .hero-btn-outline {
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .25);
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
        }

        .hero-btn-outline:hover {
            color: #fff;
            background: rgba(255, 255, 255, .16);
            transform: translateY(-3px);
        }

        /* =========================================================
                                                                                           HERO IMAGE
                                                                                           ========================================================= */

        .hero-visual {
            position: relative;
            width: 100%;
            min-width: 0;
        }

        .hero-image-frame {
            position: relative;
            padding: 11px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 30px;
            background: rgba(255, 255, 255, .08);
            box-shadow: 0 35px 80px rgba(0, 0, 0, .22);
            backdrop-filter: blur(12px);
        }

        .hero-image {
            display: block;
            width: 100%;
            height: clamp(280px, 34vw, 390px);
            object-fit: cover;
            border-radius: 21px;
        }

        .hero-image-overlay {
            position: absolute;
            left: clamp(18px, 3vw, 26px);
            right: clamp(18px, 3vw, 26px);
            bottom: clamp(18px, 3vw, 26px);
            padding: 15px 17px;
            border: 1px solid rgba(255, 255, 255, .20);
            border-radius: 16px;
            background: rgba(1, 39, 60, .78);
            color: #fff;
            backdrop-filter: blur(14px);
        }

        .hero-image-overlay strong {
            display: block;
            font-size: .88rem;
        }

        .hero-image-overlay small {
            display: block;
            color: rgba(255, 255, 255, .68);
            font-size: .7rem;
            line-height: 1.5;
        }

        .hero-floating-card {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: min(210px, 48%);
            padding: 11px 14px;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .18);
        }

        .hero-floating-card i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border-radius: 11px;
            background: #e8f7f1;
            color: var(--gt-green-dark);
        }

        .hero-floating-card span {
            display: block;
            color: var(--gt-dark);
            font-size: .7rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .hero-floating-card small {
            display: block;
            color: var(--gt-muted);
            font-size: .65rem;
            white-space: nowrap;
        }

        .hero-floating-one {
            left: -28px;
            top: 48px;
        }

        .hero-floating-two {
            right: -22px;
            bottom: 60px;
        }

        /* =========================================================
       GO TUBE - MENU ONLY
       HANYA TAMPILAN MENU
       BACKEND / ROUTE / HTML / JS TIDAK DIUBAH
       ========================================================= */

        #menu {
            position: relative;
            z-index: 20;
            width: 100%;
            margin-top: -25px;
        }

        #menu .menu-wrapper {
            width: 100%;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, .9);
            border-radius: 25px;
            background: rgba(255, 255, 255, .97);
            box-shadow:
                0 25px 65px rgba(0, 48, 75, .17),
                0 5px 15px rgba(0, 0, 0, .05);
            backdrop-filter: blur(18px);
        }

        /* MENU UTAMA */
        #menu .menu-nav {
            display: flex !important;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            gap: 8px;
            width: 100%;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        /* ITEM MENU */
        #menu .menu-nav .nav-item {
            flex: 1 1 145px;
            min-width: 125px;
            max-width: 180px;
            display: flex;
        }

        /* LINK */
        #menu .menu-link {
            position: relative;
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            width: 100%;
            min-height: 95px;

            padding: 12px 8px !important;

            border: 1px solid transparent;
            border-radius: 17px;

            color: var(--gt-text) !important;

            font-size: .73rem;
            font-weight: 700;
            line-height: 1.3;

            text-align: center;
            text-decoration: none;

            transition:
                transform .25s ease,
                background .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        /* ICON */
        #menu .menu-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 45px;
            height: 45px;
            flex: 0 0 45px;

            margin-bottom: 8px !important;

            border-radius: 13px;

            background: #eaf5fb;
            color: var(--gt-primary);

            font-size: 18px;

            transition:
                transform .25s ease,
                background .25s ease,
                color .25s ease;
        }

        /* HOVER */
        #menu .menu-link:hover {
            color: #fff !important;

            background:
                linear-gradient(135deg,
                    var(--gt-primary),
                    var(--gt-primary-light));

            border-color: rgba(255, 255, 255, .18);

            transform: translateY(-4px);

            box-shadow:
                0 13px 28px rgba(2, 78, 127, .20);
        }

        #menu .menu-link:hover .menu-icon {
            background: rgba(255, 255, 255, .18);
            color: #fff;
            transform: scale(1.08);
        }


        /* =========================================================
       TABLET
       ========================================================= */

        @media (max-width: 991.98px) {

            #menu {
                margin-top: -20px;
            }

            #menu .menu-wrapper {
                padding: 8px;
                border-radius: 22px;
            }

            #menu .menu-nav {
                gap: 7px;
            }

            #menu .menu-nav .nav-item {
                flex: 1 1 130px;
                min-width: 120px;
                max-width: 170px;
            }

            #menu .menu-link {
                min-height: 88px;
                padding: 10px 6px !important;
                border-radius: 15px;
                font-size: .68rem;
            }

            #menu .menu-icon {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
                margin-bottom: 7px !important;
                border-radius: 12px;
                font-size: 17px;
            }
        }


        /* =========================================================
       MOBILE
       ========================================================= */

        @media (max-width: 575.98px) {

            #menu {
                margin-top: -10px;
            }

            #menu .menu-wrapper {
                padding: 6px;
                border-radius: 18px;
            }

            #menu .menu-nav {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 5px;
            }

            #menu .menu-nav .nav-item {
                width: 100%;
                min-width: 0;
                max-width: none;
            }

            #menu .menu-link {
                min-height: 82px;
                padding: 7px 3px !important;
                border-radius: 13px;
                font-size: .60rem;
            }

            #menu .menu-icon {
                width: 36px;
                height: 36px;
                flex-basis: 36px;
                margin-bottom: 5px !important;
                border-radius: 10px;
                font-size: 14px;
            }
        }


        /* =========================================================
       SMALL MOBILE
       ========================================================= */

        @media (max-width: 380px) {

            #menu .menu-wrapper {
                padding: 5px;
                border-radius: 16px;
            }

            #menu .menu-nav {
                gap: 4px;
            }

            #menu .menu-link {
                min-height: 76px;
                padding: 6px 2px !important;
                border-radius: 11px;
                font-size: .55rem;
            }

            #menu .menu-icon {
                width: 32px;
                height: 32px;
                flex-basis: 32px;
                font-size: 13px;
                border-radius: 9px;
            }
        }

        /* =========================================================
                                                                                           ABOUT
                                                                                           ========================================================= */

        .gt-about {
            padding: 100px 0 95px;
            background: linear-gradient(180deg, #fff 0%, #f5fafc 100%);
        }

        .about-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: clamp(35px, 5vw, 60px);
            align-items: center;
        }

        .about-visual {
            position: relative;
            min-width: 0;
        }

        .about-main-image {
            display: block;
            width: 100%;
            height: clamp(300px, 38vw, 430px);
            object-fit: cover;
            border-radius: 28px;
            box-shadow: var(--gt-shadow);
        }

        .about-mini-card {
            position: absolute;
            right: -20px;
            bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: calc(100% - 20px);
            padding: 15px 18px;
            border: 1px solid var(--gt-border);
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .12);
        }

        .about-mini-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex: 0 0 43px;
            border-radius: 13px;
            background: #e8f7f1;
            color: var(--gt-green-dark);
        }

        .about-mini-card strong {
            display: block;
            color: var(--gt-dark);
            font-size: .8rem;
        }

        .about-mini-card small {
            color: var(--gt-muted);
            font-size: .68rem;
        }

        .about-content {
            min-width: 0;
        }

        .about-content .eyebrow {
            display: inline-block;
            margin-bottom: 13px;
            color: var(--gt-green-dark);
            font-size: .73rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .about-content h2 {
            margin: 0 0 18px;
            color: var(--gt-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.8px;
        }

        .about-content>p {
            color: var(--gt-muted);
            font-size: .94rem;
            line-height: 1.9;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 28px;
        }

        .about-feature {
            display: flex;
            gap: 11px;
            min-width: 0;
            padding: 15px;
            border: 1px solid var(--gt-border);
            border-radius: 16px;
            background: #fff;
            transition: .25s ease;
        }

        .about-feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(2, 78, 127, .08);
        }

        .about-feature i {
            color: var(--gt-green);
            margin-top: 3px;
            flex: 0 0 auto;
        }

        .about-feature strong {
            display: block;
            color: var(--gt-dark);
            font-size: .78rem;
        }

        .about-feature small {
            display: block;
            margin-top: 3px;
            color: var(--gt-muted);
            font-size: .68rem;
            line-height: 1.5;
        }

        /* =========================================================
                                                                                           GALERI
                                                                                           ========================================================= */

        .gt-gallery {
            padding: 100px 0;
            background: #fff;
        }

        .gallery-carousel {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            box-shadow: var(--gt-shadow);
        }

        .gallery-carousel .carousel-item {
            height: clamp(280px, 40vw, 470px);
        }

        .gallery-carousel img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-carousel .carousel-caption {
            right: 8%;
            bottom: 30px;
            left: 8%;
            padding: 22px 25px;
            border-radius: 18px;
            background: rgba(1, 39, 60, .72);
            backdrop-filter: blur(10px);
        }

        .gallery-carousel .carousel-caption h5 {
            margin-bottom: 5px;
            font-weight: 800;
        }

        .gallery-carousel .carousel-caption p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: .8rem;
            line-height: 1.5;
        }

        .gallery-carousel .carousel-control-prev,
        .gallery-carousel .carousel-control-next {
            width: 55px;
        }

        .gallery-carousel .carousel-indicators {
            margin-bottom: 15px;
        }

        .gallery-carousel .carousel-indicators button {
            width: 25px;
            height: 4px;
            border: 0;
            border-radius: 10px;
        }

        /* =========================================================
                                                                                           ALUR MONITORING
                                                                                           ========================================================= */

        .gt-flow {
            padding: 100px 0;
            background: #f5fafc;
        }

        .flow-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .flow-card {
            position: relative;
            min-width: 0;
            padding: 28px 22px;
            border: 1px solid var(--gt-border);
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 8px 25px rgba(20, 60, 80, .05);
            transition: .25s ease;
        }

        .flow-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--gt-shadow-hover);
        }

        .flow-number {
            position: absolute;
            top: 17px;
            right: 18px;
            color: #dcecf3;
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1;
        }

        .flow-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 55px;
            height: 55px;
            margin-bottom: 20px;
            border-radius: 16px;
            background: #eaf5fb;
            color: var(--gt-primary);
            font-size: 21px;
        }

        .flow-card:nth-child(2) .flow-icon {
            background: #e8f7f1;
            color: var(--gt-green-dark);
        }

        .flow-card:nth-child(3) .flow-icon {
            background: #fff5df;
            color: #dc9700;
        }

        .flow-card:nth-child(4) .flow-icon {
            background: #f1eafa;
            color: #7651a8;
        }

        .flow-card h4 {
            margin-bottom: 8px;
            color: var(--gt-dark);
            font-size: 1rem;
            font-weight: 800;
        }

        .flow-card p {
            margin: 0;
            color: var(--gt-muted);
            font-size: .78rem;
            line-height: 1.7;
        }

        /* =========================================================
                                                                                           RIWAYAT
                                                                                           ========================================================= */

        #about {
            position: relative;
        }

        .riwayat-section {
            padding: 100px 0 110px;
            background: linear-gradient(180deg, #f5fafc 0%, #ffffff 100%);
        }

        .riwayat-title {
            max-width: 700px;
            margin: 0 auto 50px;
            text-align: center;
        }

        .riwayat-title .date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 13px;
            padding: 8px 14px;
            border-radius: 50px;
            background: #edf6fa;
            color: var(--gt-muted);
            font-size: .72rem;
        }

        .activity-title {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 20px;
        }

        .activity-title-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            border-radius: 15px;
            background: #eaf5fb;
            color: var(--gt-primary);
            font-size: 19px;
        }

        .activity-title h3 {
            margin: 0;
            color: var(--gt-dark);
            font-size: 1.2rem;
            font-weight: 800;
        }

        .activity-title small {
            font-size: .72rem;
        }

        .activity-card {
            position: relative;
            overflow: hidden;
            margin-bottom: 13px;
            border: 1px solid var(--gt-border) !important;
            border-radius: 18px !important;
            background: #fff;
            box-shadow: 0 7px 22px rgba(20, 60, 80, .04);
            transition: .25s ease;
        }

        .activity-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--gt-primary), var(--gt-green));
        }

        .activity-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(2, 78, 127, .10) !important;
        }

        .activity-card .card-body {
            padding: 18px 20px;
        }

        .activity-outlet {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--gt-primary);
            font-weight: 800;
            font-size: .87rem;
        }

        .activity-outlet i {
            color: var(--gt-green);
        }

        .activity-info {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 11px;
        }

        .activity-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 50px;
            background: #f3f7f9;
            color: #526778;
            font-size: .7rem;
            font-weight: 700;
        }

        .activity-date {
            display: block;
            margin-top: 11px;
            color: #8b9aa8;
            font-size: .68rem;
        }

        /* =========================================================
                                                                                           EMPTY / STATISTICS
                                                                                           ========================================================= */

        .empty-card {
            padding: 45px 25px;
            border: 1px dashed #cfdee6;
            border-radius: 20px;
            background: rgba(255, 255, 255, .8);
            text-align: center;
            color: var(--gt-muted);
        }

        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #edf6fa;
            color: var(--gt-primary);
            font-size: 23px;
        }

        .stat-card {
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
            padding: 18px;
            margin-bottom: 13px;
            overflow: hidden;
            border: 1px solid var(--gt-border);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 7px 22px rgba(20, 60, 80, .05);
            transition: .25s ease;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            right: -55px;
            top: -55px;
            border-radius: 50%;
            background: #f1f8fb;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(20, 60, 80, .10);
        }

        .stat-icon {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            border-radius: 15px;
            background: #eaf5fb;
            color: var(--gt-primary);
            font-size: 19px;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: #fff5df;
            color: #e49a00;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: #e8f8ee;
            color: #16a34a;
        }

        .stat-label {
            position: relative;
            z-index: 2;
            margin: 0 0 3px;
            color: var(--gt-muted);
            font-size: .72rem;
            font-weight: 600;
        }

        .stat-value {
            position: relative;
            z-index: 2;
            margin: 0;
            color: var(--gt-dark);
            font-size: 1rem;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        /* =========================================================
                                                                                           MODAL / FORM
                                                                                           ========================================================= */

        #modalInputPengiriman {
            padding-inline: 0 !important;
        }

        #modalInputPengiriman .modal-dialog {
            width: calc(100% - 24px);
            max-width: 900px;
            margin: 12px auto;
        }

        #modalInputPengiriman .modal-content {
            overflow: hidden;
            border: 0 !important;
            border-radius: 22px !important;
            box-shadow: 0 25px 70px rgba(0, 0, 0, .25);
        }

        #modalInputPengiriman .modal-header {
            padding: 18px 22px;
            background: linear-gradient(135deg, var(--gt-primary-dark), var(--gt-primary)) !important;
        }

        #modalInputPengiriman .modal-title {
            font-weight: 700;
        }

        #modalInputPengiriman .modal-body {
            max-height: min(68vh, 700px);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 25px;
            background: #fbfdff;
            overscroll-behavior: contain;
        }

        #modalInputPengiriman .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 15px 20px;
            background: #fff;
        }

        #modalInputPengiriman .modal-footer .btn {
            min-height: 42px;
        }

        .form-label,
        #modalInputPengiriman .modal-body label {
            display: block;
            margin-bottom: 7px;
            color: var(--gt-dark);
            font-size: .85rem;
            font-weight: 600;
        }

        #modalInputPengiriman .row {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: .25rem;
        }

        #modalInputPengiriman .form-control,
        #modalInputPengiriman .form-select {
            width: 100%;
            min-height: 45px;
            border: 1px solid #dce7ee;
            border-radius: 11px;
            box-shadow: none !important;
        }

        #modalInputPengiriman textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        #modalInputPengiriman .form-control:focus,
        #modalInputPengiriman .form-select:focus {
            border-color: var(--gt-primary);
            box-shadow: 0 0 0 3px rgba(2, 78, 127, .10) !important;
        }

        .scan-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 10px 0 15px;
            font-size: .95rem;
            font-weight: 700;
            text-align: center;
        }

        .scan-title.isi {
            color: #16a34a;
        }

        .scan-title.kosong {
            color: var(--gt-primary);
        }

        .scan-divider {
            height: 1px;
            margin: 25px 0;
            border: 0;
            background: #e3edf3;
            opacity: 1;
        }

        .scan-button {
            min-width: 155px;
            min-height: 42px;
            border-radius: 11px;
            font-weight: 600;
        }

        .scanner-box {
            position: relative;
            width: min(100%, 360px);
            height: min(360px, 62vw);
            min-height: 240px;
            margin: 15px auto;
            display: none;
            overflow: hidden;
            border: 3px solid #dbe8ef;
            border-radius: 18px;
            background: #071923;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .15);
        }

        #readerIsi video,
        #readerKosong video,
        #readerIsi canvas,
        #readerKosong canvas {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        #readerIsi>div,
        #readerKosong>div {
            max-width: 100% !important;
        }

        .scanner-box::after {
            content: "";
            position: absolute;
            width: 65%;
            height: 2px;
            top: 50%;
            left: 17.5%;
            background: #ff3b30;
            box-shadow: 0 0 8px rgba(255, 59, 48, .8);
            animation: scanLine 2s infinite;
            pointer-events: none;
            z-index: 5;
        }

        @keyframes scanLine {
            0% {
                top: 20%;
            }

            50% {
                top: 80%;
            }

            100% {
                top: 20%;
            }
        }

        .scan-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            margin-top: 8px;
        }

        .scan-item input {
            flex: 1 1 auto;
            min-width: 0;
        }

        .scan-item button {
            width: 45px;
            min-width: 45px;
            height: 45px;
            flex: 0 0 45px;
            border-radius: 10px;
        }

        /* =========================================================
                                                                                           TOUCH / TABLET
                                                                                           ========================================================= */

        @media (max-width: 1199.98px) {
            .gt-container {
                width: min(1100px, calc(100% - 36px));
            }

            .hero-row {
                gap: 40px;
            }

            .hero-right {
                flex-basis: 390px;
            }

            .flow-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .gt-container {
                width: min(760px, calc(100% - 32px));
            }

            .hero-content {
                padding: 65px 0 75px;
            }

            .hero-row {
                flex-direction: column;
                gap: 45px;
                text-align: center;
            }

            .hero-left {
                width: 100%;
            }

            .hero-right {
                width: min(520px, 100%);
                flex: 0 1 auto;
            }

            .hero-subtitle {
                margin-inline: auto;
            }

            .hero-actions {
                justify-content: center;
            }

            .hero-visual {
                margin-inline: auto;
            }

            .hero-image {
                height: clamp(300px, 55vw, 390px);
            }


            .gt-about {
                padding-top: 85px;
            }

            .about-grid {
                grid-template-columns: 1fr;
                gap: 45px;
            }

            .about-visual {
                width: min(700px, 100%);
                margin-inline: auto;
            }

            .about-content {
                text-align: center;
            }

            .about-features {
                text-align: left;
            }

            .about-main-image {
                height: clamp(320px, 55vw, 420px);
            }

            .about-mini-card {
                right: 15px;
            }

            .gallery-carousel .carousel-item {
                height: 400px;
            }

            #modalInputPengiriman .modal-dialog {
                max-width: 760px;
            }

            #modalInputPengiriman .modal-body {
                max-height: 70vh;
            }
        }

        /* =========================================================
                                                                                           TABLET PORTRAIT / LARGE MOBILE
                                                                                           ========================================================= */

        @media (max-width: 767.98px) {
            .gt-container {
                width: calc(100% - 28px);
            }

            .gt-section,
            .gt-gallery,
            .gt-flow {
                padding-top: 75px;
                padding-bottom: 75px;
            }

            .hero-content {
                padding: 55px 0 65px;
            }

            .judul-utama {
                font-size: clamp(2rem, 8vw, 2.8rem) !important;
                letter-spacing: -1.2px;
            }

            .hero-subtitle {
                max-width: 620px;
                font-size: .9rem;
            }

            .hero-actions {
                width: 100%;
            }

            .hero-btn {
                flex: 1 1 0;
            }

            .hero-right {
                width: min(500px, 100%);
            }

            .hero-image-frame {
                padding: 9px;
                border-radius: 25px;
            }

            .hero-image {
                height: clamp(270px, 58vw, 350px);
                border-radius: 18px;
            }

            .hero-floating-one {
                left: -6px;
                top: 25px;
            }

            .hero-floating-two {
                right: -6px;
                bottom: 45px;
            }

            .hero-floating-card {
                padding: 9px 11px;
            }



            .about-main-image {
                height: 300px;
                border-radius: 22px;
            }

            .about-content h2,
            .gt-section-title h2 {
                font-size: 2rem;
            }

            .about-content>p {
                font-size: .86rem;
                line-height: 1.8;
            }

            .about-features {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .about-feature {
                padding: 13px;
            }

            .flow-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .flow-card {
                padding: 23px 18px;
            }

            .gallery-carousel {
                border-radius: 21px;
            }

            .gallery-carousel .carousel-item {
                height: 330px;
            }

            .gallery-carousel .carousel-caption {
                right: 20px;
                bottom: 20px;
                left: 20px;
                padding: 14px 16px;
                border-radius: 14px;
            }

            .gallery-carousel .carousel-caption h5 {
                font-size: .9rem;
            }

            .gallery-carousel .carousel-caption p {
                font-size: .68rem;
            }

            .gallery-carousel .carousel-control-prev,
            .gallery-carousel .carousel-control-next {
                width: 42px;
            }

            .riwayat-section {
                padding: 75px 0 85px;
            }

            .activity-title {
                gap: 10px;
            }

            .activity-title-icon {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
                border-radius: 12px;
                font-size: 17px;
            }

            .activity-title h3 {
                font-size: 1rem;
            }

            .activity-title small {
                font-size: .64rem;
            }

            .activity-card .card-body {
                padding: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                flex-basis: 45px;
            }

            #modalInputPengiriman .modal-dialog {
                width: calc(100% - 20px);
                margin: 10px auto;
            }

            #modalInputPengiriman .modal-content {
                border-radius: 18px !important;
            }

            #modalInputPengiriman .modal-header {
                padding: 15px 16px;
            }

            #modalInputPengiriman .modal-body {
                max-height: 68vh;
                padding: 17px;
            }

            #modalInputPengiriman .modal-footer {
                padding: 12px 15px;
            }

            #modalInputPengiriman .modal-footer .btn {
                flex: 1 1 0;
            }

            .scanner-box {
                width: min(100%, 360px);
                height: min(360px, 72vw);
                min-height: 230px;
            }
        }

        /* =========================================================
                                                                                           MOBILE
                                                                                           ========================================================= */

        @media (max-width: 575.98px) {
            .gt-container {
                width: calc(100% - 28px);
            }

            .gt-section,
            .gt-gallery,
            .gt-flow {
                padding-top: 65px;
                padding-bottom: 65px;
            }

            .gt-section-title {
                margin-bottom: 35px;
            }

            .gt-section-title .eyebrow {
                font-size: .64rem;
                padding: 6px 11px;
            }

            .gt-section-title h2 {
                font-size: 1.8rem;
            }

            .gt-section-title p {
                font-size: .8rem;
                line-height: 1.7;
            }

            .hero-brand {
                max-width: 100%;
                padding: 7px 12px;
                font-size: .6rem;
                letter-spacing: .45px;
                white-space: normal;
            }

            .judul-utama {
                font-size: 2.05rem !important;
                line-height: 1.1;
                letter-spacing: -1px;
            }

            .hero-subtitle {
                margin-top: 18px;
                font-size: .82rem;
                line-height: 1.7;
            }

            .hero-actions {
                flex-direction: column;
                align-items: stretch;
                margin-top: 24px;
            }

            .hero-btn {
                width: 100%;
                flex: 1 1 auto;
            }

            .hero-right {
                width: 100%;
            }

            .hero-image-frame {
                padding: 7px;
                border-radius: 22px;
            }

            .hero-image {
                height: 285px;
                border-radius: 16px;
            }

            .hero-image-overlay {
                left: 15px;
                right: 15px;
                bottom: 15px;
                padding: 11px 12px;
                border-radius: 13px;
            }

            .hero-image-overlay strong {
                font-size: .76rem;
            }

            .hero-image-overlay small {
                font-size: .62rem;
            }

            .hero-floating-card {
                max-width: 145px;
                padding: 7px 9px;
                gap: 7px;
                border-radius: 11px;
            }

            .hero-floating-card i {
                width: 29px;
                height: 29px;
                flex-basis: 29px;
                border-radius: 8px;
                font-size: .75rem;
            }

            .hero-floating-card span {
                font-size: .57rem;
            }

            .hero-floating-card small {
                font-size: .51rem;
            }

            .hero-floating-one {
                left: -3px;
                top: 20px;
            }

            .hero-floating-two {
                right: -3px;
                bottom: 38px;
            }



            .gt-about {
                padding-top: 65px;
            }

            .about-main-image {
                height: 270px;
                border-radius: 20px;
            }

            .about-mini-card {
                right: 8px;
                bottom: 12px;
                max-width: calc(100% - 16px);
                padding: 9px 11px;
                gap: 9px;
                border-radius: 13px;
            }

            .about-mini-icon {
                width: 34px;
                height: 34px;
                flex-basis: 34px;
                border-radius: 9px;
            }

            .about-mini-card strong {
                font-size: .68rem;
            }

            .about-mini-card small {
                font-size: .58rem;
            }

            .about-content h2 {
                font-size: 1.8rem;
            }

            .about-features {
                grid-template-columns: 1fr;
                gap: 9px;
            }

            .about-feature small {
                font-size: .64rem;
            }

            .flow-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .flow-card {
                padding: 21px 18px;
            }

            .flow-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 15px;
            }

            .gallery-carousel {
                border-radius: 18px;
            }

            .gallery-carousel .carousel-item {
                height: 285px;
            }

            .gallery-carousel .carousel-caption {
                right: 15px;
                bottom: 16px;
                left: 15px;
                padding: 11px 12px;
                border-radius: 12px;
            }

            .gallery-carousel .carousel-caption h5 {
                margin-bottom: 3px;
                font-size: .78rem;
            }

            .gallery-carousel .carousel-caption p {
                font-size: .59rem;
            }

            .gallery-carousel .carousel-indicators {
                margin-bottom: 8px;
            }

            .gallery-carousel .carousel-indicators button {
                width: 18px;
                height: 3px;
            }

            .activity-info {
                display: block;
            }

            .activity-badge {
                width: 100%;
                margin-bottom: 6px;
                justify-content: flex-start;
            }

            #modalInputPengiriman .modal-dialog {
                width: calc(100% - 14px);
                margin: 7px auto;
            }

            #modalInputPengiriman .modal-header {
                padding: 14px;
            }

            #modalInputPengiriman .modal-header .modal-title {
                font-size: .95rem;
            }

            #modalInputPengiriman .modal-header small {
                font-size: .65rem;
            }

            #modalInputPengiriman .modal-body {
                max-height: 66vh;
                padding: 14px;
            }

            #modalInputPengiriman .modal-footer {
                display: flex;
                flex-wrap: wrap;
                gap: 7px;
                padding: 10px 12px;
            }

            #modalInputPengiriman .modal-footer .btn {
                flex: 1 1 calc(50% - 4px);
                min-width: 0;
                font-size: .78rem;
            }

            #modalInputPengiriman .modal-body .row>[class*="col-"] {
                margin-bottom: .25rem !important;
            }

            .scan-title {
                font-size: .85rem;
            }

            .scan-button {
                width: 100%;
                margin-bottom: 7px !important;
            }

            .scanner-box {
                width: 100%;
                height: min(330px, 78vw);
                min-height: 220px;
                margin-top: 12px;
                margin-bottom: 12px;
                border-radius: 15px;
            }

            .scan-item {
                gap: 6px;
            }

            .scan-item button {
                width: 42px;
                min-width: 42px;
                height: 42px;
                flex-basis: 42px;
            }

            #modalInputPengiriman .form-control,
            #modalInputPengiriman .form-select {
                min-height: 43px;
                font-size: .84rem;
            }

            #modalInputPengiriman .modal-body label {
                font-size: .78rem;
            }

            #modalInputPengiriman textarea.form-control {
                min-height: 90px;
            }
        }

        /* =========================================================
                                                                                           SMALL MOBILE
                                                                                           ========================================================= */

        @media (max-width: 380px) {
            .gt-container {
                width: calc(100% - 22px);
            }

            .hero-content {
                padding-top: 48px;
            }

            .judul-utama {
                font-size: 1.78rem !important;
            }

            .hero-image {
                height: 250px;
            }

            .hero-floating-card {
                transform: scale(.84);
                transform-origin: center;
            }

            .hero-floating-one {
                left: -7px;
            }

            .hero-floating-two {
                right: -7px;
            }



            .gt-section-title h2,
            .about-content h2 {
                font-size: 1.65rem;
            }

            .gallery-carousel .carousel-item {
                height: 245px;
            }

            #modalInputPengiriman .modal-footer .btn {
                flex-basis: 100%;
            }

            .scanner-box {
                height: 240px;
                min-height: 220px;
            }
        }

        /* =========================================================
                                                                                           LANDSCAPE MOBILE
                                                                                           ========================================================= */

        @media (max-height: 600px) and (orientation: landscape) {
            #modalInputPengiriman .modal-body {
                max-height: 55vh;
            }

            .hero-content {
                padding-top: 45px;
                padding-bottom: 55px;
            }

            .hero-row {
                gap: 30px;
            }

            .hero-image {
                height: 260px;
            }

            .scanner-box {
                height: 240px;
                min-height: 210px;
            }
        }

        /* =========================================================
                                                                                           REDUCE MOTION
                                                                                           ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        /* =========================================================
                                                                   TABLET FIX - 768px s/d 991px
                                                                   Navbar tidak menutupi Hero
                                                                   ========================================================= */

        @media (min-width: 768px) and (max-width: 991.98px) {

            /* Beri ruang ekstra karena navbar/header berada di atas hero */
            #hero .hero-content {
                padding-top: 120px;
                padding-bottom: 75px;
            }

            /* Judul tablet dibuat lebih proporsional */
            #hero .judul-utama {
                max-width: 760px;
                margin-inline: auto;
                font-size: clamp(2.8rem, 5.5vw, 3.5rem) !important;
                line-height: 1.08;
            }

            /* Subtitle sedikit lebih lebar */
            #hero .hero-subtitle {
                max-width: 680px;
                margin-left: auto;
                margin-right: auto;
                font-size: .95rem;
                line-height: 1.75;
            }

            /* Jarak tombol dengan subtitle */
            #hero .hero-actions {
                margin-top: 28px;
            }

            /* Gambar hero tetap besar tapi tidak terlalu tinggi */
            #hero .hero-right {
                width: min(600px, 100%);
            }

            #hero .hero-image {
                height: 360px;
            }

            /* Floating card jangan terlalu keluar layar tablet */
            #hero .hero-floating-one {
                left: 5px;
                top: 45px;
            }

            #hero .hero-floating-two {
                right: 5px;
                bottom: 50px;
            }
        }

        /* =========================================================
                                                               GO TUBE - FINAL RESPONSIVE LAYOUT FIX
                                                               Fokus:
                                                               - Konten tidak tertutup navbar
                                                               - Tablet lebih aman
                                                               - Mobile tetap aman
                                                               - Tidak mengubah responsive navbar
                                                               - Tidak mengubah backend / route / JS / modal
                                                               ========================================================= */

        /* =========================================================
                                                               GLOBAL CONTENT SAFETY
                                                               ========================================================= */

        .content.gt-page {
            position: relative;
            width: 100%;
            min-width: 0;
            overflow-x: clip;
        }

        /*
                                                             * Navbar adalah sticky.
                                                             * Berikan ruang aman pada halaman setelah navbar.
                                                             */
        .content.gt-page {
            scroll-margin-top: 80px;
        }


        /* =========================================================
                                                               DESKTOP
                                                               ========================================================= */

        @media (min-width: 992px) {

            #hero .hero-content {
                padding-top: 70px;
                padding-bottom: 90px;
            }

            #hero .hero-row {
                min-height: 560px;
            }

            #hero .hero-left {
                min-width: 0;
            }

            #hero .hero-right {
                min-width: 0;
            }

            #hero .judul-utama {
                max-width: 650px;
            }

            #hero .hero-subtitle {
                max-width: 560px;
            }


        }


        /* =========================================================
                                                               TABLET LANDSCAPE
                                                               992px sebelumnya sudah desktop.
                                                               Fokus 768px - 991px
                                                               ========================================================= */

        @media (min-width: 768px) and (max-width: 991.98px) {

            /*
                                                                 * Jarak hero dari navbar.
                                                                 * Ini bagian terpenting untuk kasus screenshot 913x677.
                                                                 */
            #hero .hero-content {
                padding-top: 105px !important;
                padding-bottom: 80px !important;
            }

            /*
                                                                 * Jangan biarkan isi hero terlalu dekat bagian atas.
                                                                 */
            #hero .hero-row {
                gap: 42px;
            }

            #hero .hero-left {
                width: 100%;
                max-width: 760px;
                margin-inline: auto;
            }

            #hero .hero-brand {
                margin-bottom: 18px;
            }

            #hero .judul-utama {
                max-width: 760px;
                margin-inline: auto;
                font-size: clamp(2.7rem, 6vw, 3.5rem) !important;
                line-height: 1.08;
            }

            #hero .hero-subtitle {
                max-width: 680px;
                margin: 22px auto 0;
                font-size: .95rem;
                line-height: 1.75;
            }

            #hero .hero-actions {
                justify-content: center;
                margin-top: 27px;
            }

            /*
                                                                 * Hero image.
                                                                 */
            #hero .hero-right {
                width: min(580px, 100%);
                margin-inline: auto;
            }

            #hero .hero-image {
                height: clamp(320px, 43vw, 390px);
            }

            /*
                                                                 * Floating card jangan terlalu keluar layar.
                                                                 */
            #hero .hero-floating-one {
                left: 4px;
                top: 42px;
            }

            #hero .hero-floating-two {
                right: 4px;
                bottom: 48px;
            }


            /* =====================================================
                                                                   MENU
                                                                   ===================================================== */

            #menu {
                margin-top: -18px;
            }

            #menu .menu-wrapper {
                width: 100%;
            }

            #menu .menu-link {
                min-height: 90px;
            }


            /* =====================================================
                                                                   ABOUT
                                                                   ===================================================== */

            .gt-about {
                padding-top: 85px;
                padding-bottom: 85px;
            }

            .about-grid {
                gap: 40px;
            }

            .about-visual {
                width: min(680px, 100%);
            }

            .about-main-image {
                height: 390px;
            }

            .about-mini-card {
                right: 15px;
                bottom: 20px;
            }


            /* =====================================================
                                                                   GALLERY
                                                                   ===================================================== */

            .gt-gallery {
                padding-top: 85px;
                padding-bottom: 85px;
            }

            .gallery-carousel .carousel-item {
                height: 390px;
            }


            /* =====================================================
                                                                   FLOW
                                                                   ===================================================== */

            .gt-flow {
                padding-top: 85px;
                padding-bottom: 85px;
            }

            .flow-grid {
                gap: 14px;
            }

            .flow-card {
                padding: 24px 19px;
            }


            /* =====================================================
                                                                   RIWAYAT
                                                                   ===================================================== */

            .riwayat-section {
                padding-top: 85px;
                padding-bottom: 90px;
            }
        }


        /* =========================================================
                                                               TABLET PORTRAIT
                                                               576px - 767px
                                                               ========================================================= */

        @media (min-width: 576px) and (max-width: 767.98px) {

            /*
                                                                 * Navbar sekitar 64-70px.
                                                                 * Hero dibuat punya ruang aman.
                                                                 */
            #hero .hero-content {
                padding-top: 85px !important;
                padding-bottom: 70px !important;
            }

            #hero .hero-row {
                gap: 38px;
            }

            #hero .judul-utama {
                max-width: 650px;
                margin-inline: auto;
                font-size: clamp(2.25rem, 7vw, 3rem) !important;
                line-height: 1.08;
            }

            #hero .hero-subtitle {
                max-width: 600px;
                margin-inline: auto;
            }

            #hero .hero-actions {
                justify-content: center;
            }

            #hero .hero-right {
                width: min(520px, 100%);
                margin-inline: auto;
            }

            #hero .hero-image {
                height: clamp(290px, 55vw, 350px);
            }

            #hero .hero-floating-one {
                left: 0;
                top: 25px;
            }

            #hero .hero-floating-two {
                right: 0;
                bottom: 40px;
            }


            /* MENU */

            #menu {
                margin-top: -12px;
            }

            .menu-link {
                min-height: 84px;
            }


            /* ABOUT */

            .gt-about {
                padding-top: 75px;
            }

            .about-main-image {
                height: 330px;
            }


            /* GALLERY */

            .gt-gallery {
                padding-top: 75px;
                padding-bottom: 75px;
            }

            .gallery-carousel .carousel-item {
                height: 340px;
            }


            /* FLOW */

            .gt-flow {
                padding-top: 75px;
                padding-bottom: 75px;
            }


            /* RIWAYAT */

            .riwayat-section {
                padding-top: 75px;
                padding-bottom: 80px;
            }
        }


        /* =========================================================
                                                               MOBILE
                                                               381px - 575px
                                                               ========================================================= */

        @media (min-width: 381px) and (max-width: 575.98px) {

            /*
                                                                 * Navbar mobile sudah responsive.
                                                                 * Jangan ubah navbar.
                                                                 * Hanya beri ruang untuk konten.
                                                                 */
            #hero .hero-content {
                padding-top: 70px !important;
                padding-bottom: 60px !important;
            }

            #hero .hero-row {
                gap: 32px;
            }

            #hero .hero-brand {
                margin-bottom: 15px;
            }

            #hero .judul-utama {
                font-size: 2.05rem !important;
                line-height: 1.1;
            }

            #hero .hero-subtitle {
                margin-top: 17px;
            }

            #hero .hero-actions {
                margin-top: 22px;
            }

            #hero .hero-right {
                width: 100%;
            }

            #hero .hero-image {
                height: 285px;
            }

            #hero .hero-floating-one {
                left: -2px;
                top: 20px;
            }

            #hero .hero-floating-two {
                right: -2px;
                bottom: 35px;
            }


            /* MENU */

            #menu {
                margin-top: -8px;
            }


            /* SECTION */

            .gt-about,
            .gt-gallery,
            .gt-flow,
            .riwayat-section {
                scroll-margin-top: 75px;
            }
        }


        /* =========================================================
                                                               SMALL MOBILE
                                                               <= 380px
                                                               ========================================================= */

        @media (max-width: 380px) {

            #hero .hero-content {
                padding-top: 62px !important;
                padding-bottom: 55px !important;
            }

            #hero .hero-row {
                gap: 28px;
            }

            #hero .judul-utama {
                font-size: 1.78rem !important;
                line-height: 1.1;
            }

            #hero .hero-subtitle {
                font-size: .78rem;
                line-height: 1.7;
            }

            #hero .hero-actions {
                margin-top: 20px;
            }

            #hero .hero-image {
                height: 250px;
            }

            #menu {
                margin-top: -7px;
            }
        }


        /* =========================================================
                                                               LANDSCAPE MOBILE / TABLET
                                                               ========================================================= */

        @media (orientation: landscape) and (max-height: 700px) {

            /*
                                                                 * Jangan menggunakan padding atas yang terlalu besar
                                                                 * pada landscape karena tinggi layar pendek.
                                                                 */
            #hero .hero-content {
                padding-top: 65px !important;
                padding-bottom: 60px !important;
            }

            #hero .hero-row {
                gap: 30px;
            }

            #hero .hero-image {
                height: 270px;
            }
        }


        /* =========================================================
                                                               ANCHOR / SCROLL FIX
                                                               Supaya saat klik #menu/#about/#hero,
                                                               section tidak masuk ke bawah sticky navbar.
                                                               ========================================================= */

        #hero,
        #menu,
        .gt-about,
        .gt-gallery,
        .gt-flow,
        #about {
            scroll-margin-top: 82px;
        }


        /* =========================================================
                                                               MENCEGAH ELEMENT INTERNAL MENYEBABKAN OVERFLOW
                                                               ========================================================= */

        .hero-left,
        .hero-right,
        .about-visual,
        .about-content,
        .gt-section-title,
        .flow-card,
        .activity-card,
        .stat-card,
        .menu-wrapper,
        .gallery-carousel {
            min-width: 0;
            max-width: 100%;
        }


        /* =========================================================
                                                               IMAGE SAFETY
                                                               ========================================================= */

        .hero-image,
        .about-main-image,
        .gallery-carousel img {
            max-width: 100%;
        }


        /* =========================================================
                                                               TABLET - FLOATING CARD SAFETY
                                                               ========================================================= */

        @media (max-width: 991.98px) {

            .hero-floating-card {
                max-width: 190px;
            }

            .hero-floating-card span,
            .hero-floating-card small {
                overflow: hidden;
                text-overflow: ellipsis;
            }

        }


        /* =========================================================
                                                               VERY SMALL SCREEN - FLOATING CARD
                                                               ========================================================= */

        @media (max-width: 480px) {

            .hero-floating-card {
                max-width: 145px;
            }

        }
    </style>


    <div class="content gt-page">


        {{-- =====================================================
        HERO
    ====================================================== --}}

        <section id="hero">

            <div class="gt-container hero-content">

                <div class="hero-row">


                    {{-- =================================================
                    HERO LEFT
                ================================================== --}}

                    <div class="hero-left" data-aos="fade-right" data-aos-duration="800">

                        <div class="hero-brand">

                            <i class="fa-solid fa-cube"></i>

                            GO TUBE MONITORING SYSTEM

                        </div>


                        <h1 class="judul-utama">

                            Monitoring Tabung
                            <span>Nitrogen</span>
                            Lebih Mudah.

                        </h1>


                        <p class="hero-subtitle">

                            Sistem monitoring pengiriman dan perputaran tabung
                            nitrogen untuk membantu proses distribusi menjadi
                            lebih terorganisir, cepat, dan mudah dipantau.

                        </p>


                        <div class="hero-actions">

                            @if (Auth::user()->role !== 'spv')
                                <a href="#" class="hero-btn hero-btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalInputPengiriman">

                                    <i class="fa-solid fa-plus"></i>

                                    Input Pengiriman

                                </a>
                            @endif


                            <a href="{{ route('tracking.index') }}" class="hero-btn hero-btn-outline">

                                <i class="fa-solid fa-location-dot"></i>

                                Lihat Tracking

                            </a>

                        </div>

                    </div>



                    {{-- =================================================
                    HERO RIGHT
                ================================================== --}}

                    <div class="hero-right" data-aos="fade-left" data-aos-duration="900">

                        <div class="hero-visual">


                            <div class="hero-image-frame">

                                <img src="{{ asset('penjamu/images/landing/foto1.png') }}" class="hero-image"
                                    alt="Monitoring dan distribusi">


                                <div class="hero-image-overlay">

                                    <strong>

                                        <i class="fa-solid fa-chart-line me-1"></i>

                                        Monitoring Terintegrasi

                                    </strong>

                                    <small>

                                        Pengiriman, tabung dan outlet
                                        dalam satu sistem.

                                    </small>

                                </div>

                            </div>



                            {{-- FLOATING CARD 1 --}}

                            <div class="hero-floating-card hero-floating-one">

                                <i class="fa-solid fa-truck-fast"></i>

                                <div>

                                    <span>
                                        Pengiriman
                                    </span>

                                    <small>
                                        Lebih terkontrol
                                    </small>

                                </div>

                            </div>



                            {{-- FLOATING CARD 2 --}}

                            <div class="hero-floating-card hero-floating-two">

                                <i class="fa-solid fa-qrcode"></i>

                                <div>

                                    <span>
                                        QR Tracking
                                    </span>

                                    <small>
                                        Scan lebih cepat
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
        MENU
    ====================================================== --}}

        <section id="menu">

            <div class="gt-container">

                <div class="menu-wrapper">

                    <ul class="nav menu-nav">


                        {{-- INPUT PENGIRIMAN --}}

                        @if (Auth::user()->role !== 'spv')
                            <li class="nav-item">

                                <a class="nav-link menu-link" data-bs-toggle="modal" data-bs-target="#modalInputPengiriman">

                                    <i class="fa-solid fa-plus menu-icon pt-3"></i>

                                    <span>
                                        Input Pengiriman
                                    </span>

                                </a>

                            </li>
                        @endif



                        {{-- TRACKING --}}

                        <li class="nav-item">

                            <a class="nav-link menu-link" href="{{ route('tracking.index') }}">

                                <i class="fa-solid fa-truck menu-icon pt-3"></i>

                                <span>
                                    Tracking Pengiriman
                                </span>

                            </a>

                        </li>



                        {{-- HISTORY --}}

                        <li class="nav-item">

                            <a class="nav-link menu-link" href="{{ route('history.index') }}">

                                <i class="fa-solid fa-clock-rotate-left menu-icon pt-3"></i>

                                <span>
                                    History Pengiriman
                                </span>

                            </a>

                        </li>



                        {{-- MONITORING TABUNG --}}

                        <li class="nav-item">

                            <a class="nav-link menu-link" href="{{ route('monitoring.tabung') }}">

                                <i class="fa-solid fa-chart-line menu-icon pt-3"></i>

                                <span>
                                    Monitoring Tabung
                                </span>

                            </a>

                        </li>

                        {{-- DATA SALES --}}

                        @if (in_array(Auth::user()->role, ['admin', 'spv']))
                            <li class="nav-item">

                                <a class="nav-link menu-link" href="{{ route('sales.index') }}">

                                    <i class="fa-solid fa-chart-column menu-icon pt-3"></i>

                                    <span>
                                        Data Sales
                                    </span>

                                </a>

                            </li>
                        @endif



                        {{-- DATA TABUNG --}}

                        <li class="nav-item">

                            <a class="nav-link menu-link" href="{{ route('tabung.index') }}">

                                <i class="fa-solid fa-gas-pump menu-icon pt-3"></i>

                                <span>
                                    Data Tabung
                                </span>

                            </a>

                        </li>



                        {{-- DATA OUTLET --}}

                        <li class="nav-item">

                            <a class="nav-link menu-link" href="{{ route('outlet.index') }}">

                                <i class="fa-solid fa-store menu-icon pt-3"></i>

                                <span>
                                    Data Outlet
                                </span>

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </section>



        {{-- =====================================================
        ABOUT GO TUBE
    ====================================================== --}}

        <section class="gt-about">

            <div class="gt-container">

                <div class="about-grid">


                    {{-- IMAGE --}}

                    <div class="about-visual" data-aos="fade-right">

                        <img src="{{ asset('penjamu/images/landing/foto2.png') }}" class="about-main-image"
                            alt="Go Tube Monitoring">


                        <div class="about-mini-card">

                            <div class="about-mini-icon">

                                <i class="fa-solid fa-chart-line"></i>

                            </div>

                            <div>

                                <strong>
                                    Data Lebih Terorganisir
                                </strong>

                                <small>
                                    Monitoring dalam satu sistem
                                </small>

                            </div>

                        </div>

                    </div>



                    {{-- TEXT --}}

                    <div class="about-content" data-aos="fade-left">

                        <div class="eyebrow">

                            <i class="fa-solid fa-circle-info me-1"></i>

                            Tentang Go Tube

                        </div>


                        <h2>

                            Satu Sistem Untuk
                            Mengelola Perjalanan Tabung.

                        </h2>


                        <p>

                            Go Tube merupakan sistem monitoring yang membantu
                            proses pengiriman tabung nitrogen mulai dari
                            pencatatan pengiriman, tracking tabung, pengambilan
                            tabung kosong, hingga pengelolaan data outlet.

                        </p>


                        <p>

                            Dengan bantuan QR Code, proses pencatatan tabung
                            dapat dilakukan dengan lebih cepat sekaligus
                            membantu menjaga data tetap terstruktur.

                        </p>


                        <div class="about-features">


                            <div class="about-feature">

                                <i class="fa-solid fa-qrcode"></i>

                                <div>

                                    <strong>
                                        QR Code
                                    </strong>

                                    <small>
                                        Identifikasi tabung lebih cepat.
                                    </small>

                                </div>

                            </div>


                            <div class="about-feature">

                                <i class="fa-solid fa-truck"></i>

                                <div>

                                    <strong>
                                        Tracking
                                    </strong>

                                    <small>
                                        Pantau perjalanan pengiriman.
                                    </small>

                                </div>

                            </div>


                            <div class="about-feature">

                                <i class="fa-solid fa-chart-line"></i>

                                <div>

                                    <strong>
                                        Monitoring
                                    </strong>

                                    <small>
                                        Data tabung lebih mudah dipantau.
                                    </small>

                                </div>

                            </div>


                            <div class="about-feature">

                                <i class="fa-solid fa-store"></i>

                                <div>

                                    <strong>
                                        Outlet
                                    </strong>

                                    <small>
                                        Data tujuan tersimpan terpusat.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
        GALERI / CAROUSEL
    ====================================================== --}}

        <section class="gt-gallery">

            <div class="gt-container">


                <div class="gt-section-title" data-aos="fade-up">

                    <div class="eyebrow">

                        <i class="fa-solid fa-images"></i>

                        Dokumentasi

                    </div>


                    <h2>
                        Aktivitas Go Tube
                    </h2>


                    <p>

                        Gambaran aktivitas operasional dan proses monitoring
                        pengiriman tabung nitrogen.

                    </p>

                </div>



                <div id="goTubeCarousel" class="carousel slide gallery-carousel" data-bs-ride="carousel"
                    data-bs-interval="4500" data-aos="fade-up">


                    {{-- INDICATORS --}}

                    <div class="carousel-indicators">

                        <button type="button" data-bs-target="#goTubeCarousel" data-bs-slide-to="0" class="active"
                            aria-current="true"></button>

                        <button type="button" data-bs-target="#goTubeCarousel" data-bs-slide-to="1"></button>

                        <button type="button" data-bs-target="#goTubeCarousel" data-bs-slide-to="2"></button>

                        <button type="button" data-bs-target="#goTubeCarousel" data-bs-slide-to="3"></button>

                    </div>



                    <div class="carousel-inner">


                        {{-- FOTO 1 --}}

                        <div class="carousel-item active">

                            <img src="{{ asset('penjamu/images/landing/carousel/foto1.png') }}"
                                alt="Aktivitas operasional">

                            <div class="carousel-caption">

                                <h5>
                                    Monitoring Pengiriman
                                </h5>

                                <p>
                                    Memudahkan proses pencatatan
                                    setiap pengiriman tabung.
                                </p>

                            </div>

                        </div>



                        {{-- FOTO 2 --}}

                        <div class="carousel-item">

                            <img src="{{ asset('penjamu/images/landing/carousel/foto2.1.png') }}""
                                alt="Sistem monitoring">

                            <div class="carousel-caption">

                                <h5>
                                    Sistem Terintegrasi
                                </h5>

                                <p>
                                    Informasi pengiriman dan tabung
                                    tersimpan secara terstruktur.
                                </p>

                            </div>

                        </div>



                        {{-- FOTO 3 --}}

                        <div class="carousel-item">

                            <img src="{{ asset('penjamu/images/landing/carousel/foto3.png') }}""
                                alt="Teknologi monitoring">

                            <div class="carousel-caption">

                                <h5>
                                    QR Code & Tracking
                                </h5>

                                <p>
                                    Proses identifikasi tabung
                                    menjadi lebih cepat.
                                </p>

                            </div>

                        </div>



                        {{-- FOTO 4 --}}

                        <div class="carousel-item">

                            <img src="{{ asset('penjamu/images/landing/carousel/foto4.png') }}""
                                alt="Aktivitas distribusi">

                            <div class="carousel-caption">

                                <h5>
                                    Distribusi Lebih Terpantau
                                </h5>

                                <p>
                                    Membantu menjaga alur distribusi
                                    tetap terdokumentasi.
                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- PREVIOUS --}}

                    <button class="carousel-control-prev" type="button" data-bs-target="#goTubeCarousel"
                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>

                        <span class="visually-hidden">
                            Previous
                        </span>

                    </button>



                    {{-- NEXT --}}

                    <button class="carousel-control-next" type="button" data-bs-target="#goTubeCarousel"
                        data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>

                        <span class="visually-hidden">
                            Next
                        </span>

                    </button>

                </div>

            </div>

        </section>



        {{-- =====================================================
        ALUR MONITORING
    ====================================================== --}}

        <section class="gt-flow">

            <div class="gt-container">


                <div class="gt-section-title" data-aos="fade-up">

                    <div class="eyebrow">

                        <i class="fa-solid fa-route"></i>

                        Alur Sistem

                    </div>


                    <h2>
                        Proses Monitoring Lebih Terstruktur
                    </h2>


                    <p>

                        Mulai dari pencatatan pengiriman hingga riwayat,
                        seluruh proses dapat dikelola dalam satu sistem.

                    </p>

                </div>



                <div class="flow-grid">


                    {{-- 01 --}}

                    <div class="flow-card" data-aos="fade-up" data-aos-delay="100">

                        <span class="flow-number">
                            01
                        </span>

                        <div class="flow-icon">

                            <i class="fa-solid fa-plus"></i>

                        </div>

                        <h4>
                            Input Pengiriman
                        </h4>

                        <p>

                            Catat outlet tujuan dan data pengiriman
                            tabung yang akan dikirim.

                        </p>

                    </div>



                    {{-- 02 --}}

                    <div class="flow-card" data-aos="fade-up" data-aos-delay="200">

                        <span class="flow-number">
                            02
                        </span>

                        <div class="flow-icon">

                            <i class="fa-solid fa-qrcode"></i>

                        </div>

                        <h4>
                            Scan Tabung
                        </h4>

                        <p>

                            Gunakan QR Code untuk mencatat tabung
                            isi maupun tabung kosong.

                        </p>

                    </div>



                    {{-- 03 --}}

                    <div class="flow-card" data-aos="fade-up" data-aos-delay="300">

                        <span class="flow-number">
                            03
                        </span>

                        <div class="flow-icon">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <h4>
                            Tracking
                        </h4>

                        <p>

                            Pantau informasi pengiriman dan
                            pergerakan tabung melalui sistem.

                        </p>

                    </div>



                    {{-- 04 --}}

                    <div class="flow-card" data-aos="fade-up" data-aos-delay="400">

                        <span class="flow-number">
                            04
                        </span>

                        <div class="flow-icon">

                            <i class="fa-solid fa-clock-rotate-left"></i>

                        </div>

                        <h4>
                            History
                        </h4>

                        <p>

                            Data aktivitas pengiriman tersimpan
                            dan dapat dilihat kembali.

                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
        RIWAYAT / AKTIVITAS
    ====================================================== --}}

        <section id="about" class="riwayat-section">

            <div class="gt-container">


                {{-- TITLE --}}

                <div class="riwayat-title" data-aos="fade-up">

                    <div class="gt-section-title mb-0">

                        <div class="eyebrow">

                            <i class="fa-solid fa-clock-rotate-left"></i>

                            Monitoring Aktivitas

                        </div>


                        <h2>
                            Riwayat & Aktivitas
                        </h2>


                        <p>

                            Pantau aktivitas pengiriman tabung yang
                            tercatat pada sistem hari ini.

                        </p>

                    </div>


                    <div class="date">

                        <i class="fa-regular fa-calendar"></i>

                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}

                        <span>•</span>

                        <i class="fa-regular fa-clock"></i>

                        {{ \Carbon\Carbon::now()->locale('id')->format('H:i') }}

                        WIB

                    </div>

                </div>



                <div class="row g-4">


                    {{-- =================================================
                    AKTIVITAS HARI INI
                ================================================== --}}

                    <div class="col-lg-7" data-aos="fade-right">

                        <div class="activity-title">

                            <div class="activity-title-icon">

                                <i class="fa-solid fa-clock-rotate-left"></i>

                            </div>

                            <div>

                                <h3>
                                    Aktivitas Hari Ini
                                </h3>

                                <small class="text-muted">
                                    Ringkasan aktivitas pengiriman
                                </small>

                            </div>

                        </div>


                        @if ($aktivitasHariIni->isEmpty())

                            <div class="empty-card">

                                <div class="empty-icon">

                                    <i class="fa-regular fa-folder-open"></i>

                                </div>


                                <h6 class="fw-bold">
                                    Belum Ada Aktivitas
                                </h6>


                                <p class="mb-0 small">

                                    Tidak ada aktivitas pengiriman
                                    untuk hari ini.

                                </p>

                            </div>
                        @else
                            @foreach ($aktivitasHariIni as $aktivitas)
                                <div class="card activity-card">

                                    <div class="card-body">


                                        <div class="activity-outlet">

                                            <i class="fa-solid fa-store"></i>

                                            <span>

                                                {{ $aktivitas->outlet->nama_outlet }}

                                            </span>

                                        </div>



                                        <div class="activity-info">

                                            <span class="activity-badge">

                                                <i class="fa-solid fa-cylinder"></i>

                                                {{ $aktivitas->tabungs->count() }}

                                                Tabung Isi Dikirim

                                            </span>


                                            <span class="activity-badge">

                                                <i class="fa-solid fa-box"></i>

                                                {{ $aktivitas->pengambilanKosong->count() }}

                                                Tabung Kosong Diambil

                                            </span>

                                        </div>



                                        <small class="activity-date">

                                            <i class="fa-regular fa-calendar me-1"></i>

                                            {{ \Carbon\Carbon::parse($aktivitas->tanggal_pengiriman)->translatedFormat('d F Y') }}

                                        </small>

                                    </div>

                                </div>
                            @endforeach

                        @endif

                    </div>



                    {{-- =================================================
                    STATISTIK
                ================================================== --}}

                    <div class="col-lg-5" data-aos="fade-left">

                        <div class="activity-title">

                            <div class="activity-title-icon">
                                <i class="fa-solid fa-chart-line"></i>

                            </div>

                            <div>

                                <h3>
                                    Ringkasan Hari Ini
                                </h3>

                                <small class="text-muted">
                                    Statistik aktivitas sistem
                                </small>

                            </div>

                        </div>



                        {{-- PENGIRIMAN --}}

                        <div class="stat-card">

                            <div class="stat-icon">

                                <i class="fa-solid fa-truck-fast"></i>

                            </div>

                            <div>

                                <p class="stat-label">

                                    Total Pengiriman Tabung Isi

                                </p>

                                <p class="stat-value">

                                    {{ $jumlahTabungHariIni }}

                                    Pengiriman

                                </p>

                            </div>

                        </div>



                        {{-- PENGAMBILAN --}}

                        <div class="stat-card">

                            <div class="stat-icon">

                                <i class="fa-solid fa-box-open"></i>

                            </div>

                            <div>

                                <p class="stat-label">

                                    Total Pengambilan Tabung Kosong

                                </p>

                                <p class="stat-value">

                                    {{ $jumlahTabungKosongHariIni }}

                                    Pengambilan

                                </p>

                            </div>

                        </div>



                        {{-- OUTLET --}}

                        <div class="stat-card">

                            <div class="stat-icon">

                                <i class="fa-solid fa-store"></i>

                            </div>

                            <div>

                                <p class="stat-label">

                                    Jumlah Outlet Tujuan

                                </p>

                                <p class="stat-value">

                                    {{ $jumlahOutletHariIni }}

                                    Outlet

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
        MODAL INPUT PENGIRIMAN
        FUNGSI ASLI TETAP
    ====================================================== --}}

        <div class="modal fade" id="modalInputPengiriman" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">


                    {{-- HEADER --}}

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title mb-1">

                                <i class="fa-solid fa-truck-fast me-2"></i>

                                Form Input Pengiriman

                            </h5>

                            <small class="opacity-75">

                                Masukkan data pengiriman dan scan tabung

                            </small>

                        </div>


                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                    </div>



                    {{-- BODY --}}

                    <div class="modal-body">

                        <form action="{{ route('pengiriman.store') }}" method="POST" id="formPengiriman">

                            @csrf


                            {{-- DATA PENGIRIMAN --}}

                            <div class="row">


                                {{-- OUTLET --}}

                                <div class="col-md-6 mb-3">

                                    <label>
                                        Outlet
                                    </label>

                                    <select class="form-select" name="outlet" required>

                                        <option value="">
                                            -- Pilih Outlet --
                                        </option>

                                        @foreach ($outlets as $outlet)
                                            <option value="{{ $outlet->id }}">

                                                {{ $outlet->nama_outlet }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>



                                {{-- TANGGAL --}}

                                <div class="col-md-6 mb-3">

                                    <label>
                                        Tanggal Pengiriman
                                    </label>

                                    <input type="date" name="tanggal_pengiriman" class="form-control" required>

                                </div>

                            </div>



                            <hr class="scan-divider">



                            {{-- =================================================
                            SCAN TABUNG ISI
                        ================================================== --}}

                            <div class="scan-title isi">

                                <i class="fa-solid fa-circle-check"></i>

                                Scan Tabung ISI

                            </div>



                            <div class="text-center">

                                <button type="button" class="btn btn-success scan-button" id="startScanIsi">

                                    <i class="fa-solid fa-camera me-1"></i>

                                    Mulai Scan ISI

                                </button>


                                <button type="button" class="btn btn-danger scan-button d-none" id="stopScanIsi">

                                    <i class="fa-solid fa-stop me-1"></i>

                                    Tutup Scanner

                                </button>

                            </div>



                            <div id="readerIsi" class="scanner-box"></div>


                            <div id="tabungWrapper"></div>



                            <div class="mt-3">

                                <label>
                                    Keterangan Pengiriman
                                </label>

                                <textarea name="keterangan" class="form-control" rows="3"
                                    placeholder="Tambahkan keterangan jika diperlukan..."></textarea>

                            </div>



                            <hr class="scan-divider">



                            {{-- =================================================
                            SCAN TABUNG KOSONG
                        ================================================== --}}

                            <div class="scan-title kosong">

                                <i class="fa-solid fa-circle-down"></i>

                                Scan Tabung KOSONG

                            </div>



                            <div class="text-center">

                                <button type="button" class="btn btn-primary scan-button" id="startScanKosong">

                                    <i class="fa-solid fa-camera me-1"></i>

                                    Mulai Scan KOSONG

                                </button>


                                <button type="button" class="btn btn-danger scan-button d-none" id="stopScanKosong">

                                    <i class="fa-solid fa-stop me-1"></i>

                                    Tutup Scanner

                                </button>

                            </div>



                            <div id="readerKosong" class="scanner-box"></div>


                            <div id="tabungWrapper2"></div>



                            <div class="mt-3">

                                <label>
                                    Keterangan Pengambilan
                                </label>

                                <textarea name="keterangan_pengambilan" class="form-control" rows="3"
                                    placeholder="Tambahkan keterangan jika diperlukan..."></textarea>

                            </div>

                        </form>

                    </div>



                    {{-- FOOTER --}}

                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                            Batal

                        </button>


                        <button type="submit" form="formPengiriman" class="btn btn-success px-4">

                            <i class="fa-solid fa-floppy-disk me-1"></i>

                            Simpan Pengiriman

                        </button>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
        QR SCANNER
    ====================================================== --}}

        <script src="https://unpkg.com/html5-qrcode"></script>

        <script>
            let scannerIsi = null;
            let scannerKosong = null;

            let scannedIsi = [];
            let scannedKosong = [];


            function getBackCamera(devices) {

                return devices.find(cam =>
                    cam.label.toLowerCase().includes("back") ||
                    cam.label.toLowerCase().includes("rear")
                ) || devices[0];

            }


            // =====================================================
            // START SCAN ISI
            // =====================================================

            document.getElementById("startScanIsi").onclick = async function() {

                if (scannerKosong) {

                    await scannerKosong.stop().catch(() => {});

                    scannerKosong.clear();

                    scannerKosong = null;

                    document.getElementById("readerKosong").style.display = "none";

                    document
                        .getElementById("stopScanKosong")
                        .classList.add("d-none");

                }


                document.getElementById("readerIsi").style.display = "block";

                document
                    .getElementById("stopScanIsi")
                    .classList.remove("d-none");


                let devices = await Html5Qrcode.getCameras();

                let camera = getBackCamera(devices);


                scannerIsi = new Html5Qrcode("readerIsi");


                scannerIsi.start(

                    camera.id,

                    {
                        fps: 10,

                        qrbox: {
                            width: 200,
                            height: 200
                        },

                        aspectRatio: 1.0
                    },

                    (decodedText) => {

                        if (
                            scannedIsi.includes(decodedText) ||
                            scannedKosong.includes(decodedText)
                        ) {

                            alert("❌ Tabung sudah ada di list!");

                            return;

                        }


                        scannedIsi.push(decodedText);


                        let row = `

                        <div class="scan-item">

                            <input
                                type="text"
                                name="tabung[]"
                                value="${decodedText}"
                                class="form-control"
                                readonly
                            >

                            <button
                                type="button"
                                class="btn btn-danger btn-remove"
                            >

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    `;


                        document
                            .getElementById("tabungWrapper")
                            .insertAdjacentHTML(
                                "beforeend",
                                row
                            );


                        new Audio(
                            'https://www.soundjay.com/buttons/sounds/beep-07.mp3'
                        ).play();

                    }

                );

            };


            // =====================================================
            // STOP SCAN ISI
            // =====================================================

            document.getElementById("stopScanIsi").onclick = async function() {

                if (scannerIsi) {

                    await scannerIsi.stop().catch(() => {});

                    scannerIsi.clear();

                    scannerIsi = null;

                }


                document.getElementById("readerIsi").style.display = "none";

                this.classList.add("d-none");

            };


            // =====================================================
            // START SCAN KOSONG
            // =====================================================

            document.getElementById("startScanKosong").onclick = async function() {

                if (scannerIsi) {

                    await scannerIsi.stop().catch(() => {});

                    scannerIsi.clear();

                    scannerIsi = null;

                    document.getElementById("readerIsi").style.display = "none";

                    document
                        .getElementById("stopScanIsi")
                        .classList.add("d-none");

                }


                document.getElementById("readerKosong").style.display = "block";

                document
                    .getElementById("stopScanKosong")
                    .classList.remove("d-none");


                let devices = await Html5Qrcode.getCameras();

                let camera = getBackCamera(devices);


                scannerKosong = new Html5Qrcode("readerKosong");


                scannerKosong.start(

                    camera.id,

                    {
                        fps: 10,

                        qrbox: {
                            width: 200,
                            height: 200
                        },

                        aspectRatio: 1.0
                    },

                    (decodedText) => {

                        if (
                            scannedKosong.includes(decodedText) ||
                            scannedIsi.includes(decodedText)
                        ) {

                            alert("❌ Tabung sudah ada di list!");

                            return;

                        }


                        scannedKosong.push(decodedText);


                        let row = `

                        <div class="scan-item">

                            <input
                                type="text"
                                name="tabung2[]"
                                value="${decodedText}"
                                class="form-control"
                                readonly
                            >

                            <button
                                type="button"
                                class="btn btn-danger btn-remove2"
                            >

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    `;


                        document
                            .getElementById("tabungWrapper2")
                            .insertAdjacentHTML(
                                "beforeend",
                                row
                            );


                        new Audio(
                            'https://www.soundjay.com/buttons/sounds/beep-07.mp3'
                        ).play();

                    }

                );

            };


            // =====================================================
            // STOP SCAN KOSONG
            // =====================================================

            document.getElementById("stopScanKosong").onclick = async function() {

                if (scannerKosong) {

                    await scannerKosong.stop().catch(() => {});

                    scannerKosong.clear();

                    scannerKosong = null;

                }


                document.getElementById("readerKosong").style.display = "none";

                this.classList.add("d-none");

            };


            // =====================================================
            // HAPUS ITEM
            // =====================================================

            document.addEventListener("click", function(e) {

                const removeIsi =
                    e.target.closest(".btn-remove");

                const removeKosong =
                    e.target.closest(".btn-remove2");


                if (removeIsi) {

                    let row =
                        removeIsi.closest(".scan-item");

                    let val =
                        row.querySelector("input").value;


                    scannedIsi =
                        scannedIsi.filter(
                            item => item !== val
                        );


                    row.remove();

                }


                if (removeKosong) {

                    let row =
                        removeKosong.closest(".scan-item");

                    let val =
                        row.querySelector("input").value;


                    scannedKosong =
                        scannedKosong.filter(
                            item => item !== val
                        );


                    row.remove();

                }

            });
        </script>



        {{-- =====================================================
        SWEET ALERT
    ====================================================== --}}

        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil!',

                    text: @json(session('success')),

                    showConfirmButton: false,

                    timer: 2000,

                    timerProgressBar: true

                });
            </script>
        @endif



        @if (session('error'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                Swal.fire({

                    icon: 'error',

                    title: 'Gagal!',

                    text: @json(session('error')),

                    showConfirmButton: false,

                    timer: 2500,

                    timerProgressBar: true

                });
            </script>
        @endif



        @include('layouts.bawah')

    </div>

@endsection
