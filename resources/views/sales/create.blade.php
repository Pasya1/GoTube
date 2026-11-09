@extends('layouts.master')

@section('title', 'Input Data Sales')

@section('content')
    <style>
        /* =========================================================
                                                                                                                   SALES FORM - GO TUBE THEME
                                                                                                                ========================================================= */

        .sales-form-page {
            --sales-primary: #024E7F;
            --sales-primary-dark: #013B61;
            --sales-primary-light: #EAF5FB;
            --sales-border: #dce9f0;
            --sales-text: #102f42;
            --sales-muted: #6c7d87;
            --sales-yellow: #fef3c7;
            --sales-yellow-text: #92400e;
        }

        /* =========================
                                                                                                                   HEADER
                                                                                                                ========================= */

        .sales-page-header {
            background: linear-gradient(135deg,
                    #ffffff 0%,
                    #f7fbfd 100%);
            border: 1px solid var(--sales-border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 6px 20px rgba(2, 78, 127, 0.07);
        }

        .sales-page-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sales-page-icon {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(135deg,
                    var(--sales-primary),
                    #03699d);
            box-shadow: 0 7px 16px rgba(2, 78, 127, 0.20);
            font-size: 19px;
        }

        .sales-page-title h3 {
            color: var(--sales-text);
            font-size: 21px;
            font-weight: 800;
            margin: 0;
        }

        .sales-page-title p {
            color: var(--sales-muted);
            font-size: 13px;
            margin: 3px 0 0;
        }

        /* =========================
                                                                                                                   BUTTON KEMBALI
                                                                                                                ========================= */

        .btn-sales-back {
            border: 1px solid var(--sales-border);
            background: #fff;
            color: var(--sales-primary);
            font-weight: 700;
            border-radius: 10px;
            padding: 9px 15px;
            transition: all .2s ease;
        }

        .btn-sales-back:hover {
            background: var(--sales-primary-light);
            color: var(--sales-primary-dark);
            border-color: #c6dce8;
            transform: translateY(-1px);
        }

        /* =========================
                                                                                                                   MAIN FORM CARD
                                                                                                                ========================= */

        .sales-form-card {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--sales-border) !important;
            box-shadow: 0 10px 28px rgba(2, 78, 127, 0.08) !important;
        }

        .sales-form-header {
            background: linear-gradient(135deg,
                    var(--sales-primary),
                    #03699d);
            padding: 16px 20px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            letter-spacing: .1px;
        }

        .sales-form-header-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .14);
        }

        .sales-form-header small {
            display: block;
            font-size: 11px;
            font-weight: 500;
            opacity: .78;
            margin-top: 1px;
        }

        .sales-form-body {
            padding: 28px !important;
            background: #fff;
        }

        /* =========================
                                                                                                                   LABEL
                                                                                                                ========================= */

        .sales-form-body .form-label {
            color: #29485a;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        /* =========================
                                                                                                                   INPUT & SELECT
                                                                                                                ========================= */

        .sales-form-body .form-control,
        .sales-form-body .form-select {
            min-height: 43px;
            border: 1px solid #d7e4eb;
            border-radius: 10px;
            color: #263f4d;
            font-size: 13px;
            background-color: #fff;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background-color .2s ease;
        }

        .sales-form-body .form-control:hover,
        .sales-form-body .form-select:hover {
            border-color: #b8d0dd;
        }

        .sales-form-body .form-control:focus,
        .sales-form-body .form-select:focus {
            border-color: var(--sales-primary);
            box-shadow: 0 0 0 3px rgba(2, 78, 127, .10);
        }

        .sales-form-body .form-control.bg-light {
            background: #f5f9fb !important;
            color: #55707e;
            border-color: #dfeaf0;
        }

        .sales-form-body input[type="date"] {
            cursor: pointer;
        }

        /* =========================
                                                                                                                   DATA OTOMATIS
                                                                                                                ========================= */

        .automatic-data-box {
            position: relative;
            background: linear-gradient(135deg,
                    #f5fbfe 0%,
                    #edf7fb 100%) !important;
            border: 1px solid #d5e9f2;
            border-radius: 14px !important;
            padding: 20px !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .automatic-data-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--sales-primary) !important;
            font-size: 14px;
            font-weight: 800;
            padding-bottom: 12px;
            margin-bottom: 16px !important;
            border-bottom: 1px dashed #c9dfe9;
        }

        .automatic-data-title i {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #dff1f9;
        }

        .automatic-data-box .form-control {
            background: #fff !important;
        }

        .automatic-data-box .form-label {
            font-size: 12px;
            color: #5c7480;
        }

        /* =========================
                                                                                                                   MANUAL INPUT BADGE
                                                                                                                ========================= */

        .manual-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-left: 5px;
            padding: 4px 7px;
            border-radius: 6px;
            background: var(--sales-yellow) !important;
            color: var(--sales-yellow-text) !important;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .2px;
            vertical-align: middle;
        }

        /* =========================
                                                                                                                   HELP TEXT
                                                                                                                ========================= */

        .sales-form-body small.text-muted {
            display: block;
            margin-top: 5px;
            color: #80919a !important;
            font-size: 11px;
        }

        /* =========================
                                                                                                                   DIVIDER
                                                                                                                ========================= */

        .sales-form-divider {
            border: 0;
            border-top: 1px solid #e6eef2;
            opacity: 1;
            margin-top: 28px !important;
            margin-bottom: 22px !important;
        }

        /* =========================
                                                                                                                   ACTION BUTTON
                                                                                                                ========================= */

        .sales-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 9px;
        }

        .btn-sales-cancel {
            border: 1px solid #d9e5eb;
            background: #fff;
            color: #607681;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 17px;
            transition: all .2s ease;
        }

        .btn-sales-cancel:hover {
            background: #f5f8fa;
            border-color: #c7d7df;
            color: #405965;
        }

        .btn-sales-save {
            border: 0;
            border-radius: 10px;
            padding: 10px 19px;
            background: linear-gradient(135deg,
                    #198754,
                    #157347);
            color: #fff;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(25, 135, 84, .18);
            transition: all .2s ease;
        }

        .btn-sales-save:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(25, 135, 84, .25);
        }

        /* =========================
                                                                                                                   RESPONSIVE TABLET
                                                                                                                ========================= */

        @media (max-width: 767.98px) {

            .sales-form-body {
                padding: 20px !important;
            }

            .sales-page-header {
                padding: 18px;
            }

            .sales-page-title h3 {
                font-size: 19px;
            }

            .sales-page-title p {
                font-size: 12px;
            }

            .sales-page-icon {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
            }

            .automatic-data-box {
                padding: 17px !important;
            }
        }

        /* =========================
                                                                                                                   RESPONSIVE MOBILE
                                                                                                                ========================= */

        @media (max-width: 575.98px) {

            .sales-form-page {
                padding-left: 10px;
                padding-right: 10px;
            }

            .sales-page-header {
                padding: 16px;
                border-radius: 14px;
            }

            .sales-page-header>.d-flex {
                align-items: stretch !important;
            }

            .sales-page-title {
                width: 100%;
            }

            .sales-page-title h3 {
                font-size: 17px;
            }

            .sales-page-title p {
                font-size: 11px;
                line-height: 1.5;
            }

            .btn-sales-back {
                width: 100%;
                justify-content: center;
                display: inline-flex;
                align-items: center;
                margin-top: 2px;
            }

            .sales-form-card {
                border-radius: 14px;
            }

            .sales-form-header {
                padding: 14px 16px;
                font-size: 13px;
            }

            .sales-form-body {
                padding: 16px !important;
            }

            .automatic-data-box {
                padding: 14px !important;
                border-radius: 12px !important;
            }

            .automatic-data-title {
                font-size: 13px;
            }

            .manual-badge {
                font-size: 8px;
                padding: 3px 6px;
            }

            .sales-actions {
                flex-direction: column-reverse;
                width: 100%;
            }

            .btn-sales-cancel,
            .btn-sales-save {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>

    <div class="container py-5 mt-5 sales-form-page">

        {{-- HEADER --}}
        <div class="sales-page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div class="sales-page-title">
                <div class="sales-page-icon">
                    <i class="fa-solid fa-chart-column"></i>
                </div>

                <div>
                    <h3>Input Data Sales</h3>
                    <p>Masukkan data penjualan per tabung.</p>
                </div>
            </div>

            <a href="{{ route('sales.index') }}" class="btn btn-sales-back">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Kembali
            </a>

        </div>


        {{-- FORM --}}
        <div class="card sales-form-card border-0 shadow-sm">

            <div class="sales-form-header">

                <div class="sales-form-header-icon">
                    <i class="fa-solid fa-chart-column"></i>
                </div>

                <div>
                    <div>Form Input Sales</div>
                    <small>Lengkapi informasi penjualan tabung</small>
                </div>

            </div>

            <div class="card-body sales-form-body">

                <form action="{{ route('sales.store') }}" method="POST" id="formSales">

                    @csrf


                    <div class="row g-3">


                        {{-- ================================================= --}}
                        {{-- OUTLET --}}
                        {{-- ================================================= --}}

                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Outlet
                            </label>

                            <select name="outlet_id" id="outlet_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Outlet --
                                </option>

                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}" data-spv="{{ $outlet->nama_spv }}"
                                        data-area="{{ $outlet->nama_area }}" data-distributor="{{ $outlet->distribusi_by }}"
                                        data-inflator="{{ $outlet->merk_inflator }}"
                                        data-regulator="{{ $outlet->merk_regulator }}">

                                        {{ $outlet->nama_outlet }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- ================================================= --}}
                        {{-- DATE IN --}}
                        {{-- ================================================= --}}

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Date IN
                            </label>

                            <input type="date" name="date_in" id="date_in" class="form-control"
                                value="{{ old('date_in', date('Y-m-d')) }}" required>

                        </div>

                        {{-- ================================================= --}}
                        {{-- DATE END --}}
                        {{-- ================================================= --}}

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Date END
                            </label>

                            <input type="date" name="date_end" id="date_end" class="form-control"
                                value="{{ old('date_end') }}">

                            <small class="text-muted">
                                Boleh dikosongkan jika belum selesai.
                            </small>

                        </div>


                        {{-- ================================================= --}}
                        {{-- BULAN --}}
                        {{-- ================================================= --}}
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Bulan
                                <span class="manual-badge">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    BISA DIPILIH
                                </span>
                            </label>

                            <select name="bulan" id="bulan" class="form-select" required>

                                <option value="">-- Pilih Bulan --</option>

                                <option value="JANUARY" @selected(old('bulan') === 'JANUARY')>
                                    JANUARY
                                </option>

                                <option value="FEBRUARY" @selected(old('bulan') === 'FEBRUARY')>
                                    FEBRUARY
                                </option>

                                <option value="MARCH" @selected(old('bulan') === 'MARCH')>
                                    MARCH
                                </option>

                                <option value="APRIL" @selected(old('bulan') === 'APRIL')>
                                    APRIL
                                </option>

                                <option value="MAY" @selected(old('bulan') === 'MAY')>
                                    MAY
                                </option>

                                <option value="JUNE" @selected(old('bulan') === 'JUNE')>
                                    JUNE
                                </option>

                                <option value="JULY" @selected(old('bulan') === 'JULY')>
                                    JULY
                                </option>

                                <option value="AUGUST" @selected(old('bulan') === 'AUGUST')>
                                    AUGUST
                                </option>

                                <option value="SEPTEMBER" @selected(old('bulan') === 'SEPTEMBER')>
                                    SEPTEMBER
                                </option>

                                <option value="OCTOBER" @selected(old('bulan') === 'OCTOBER')>
                                    OCTOBER
                                </option>

                                <option value="NOVEMBER" @selected(old('bulan') === 'NOVEMBER')>
                                    NOVEMBER
                                </option>

                                <option value="DECEMBER" @selected(old('bulan') === 'DECEMBER')>
                                    DECEMBER
                                </option>

                            </select>

                            <small class="text-muted">
                                Otomatis mengikuti Date IN, tetapi masih bisa diubah.
                            </small>

                        </div>


                        {{-- ================================================= --}}
                        {{-- DATA OTOMATIS OUTLET --}}
                        {{-- ================================================= --}}

                        <div class="col-12">
                            <div class="automatic-data-box">

                                <div class="automatic-data-title">
                                    <i class="fa-solid fa-robot"></i>
                                    <span>Data Otomatis dari Outlet</span>
                                </div>


                                <div class="row g-3">


                                    <div class="col-md-4">

                                        <label class="form-label">
                                            SPV
                                        </label>

                                        <input type="text" id="auto_spv" class="form-control" readonly>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Area
                                        </label>

                                        <input type="text" id="auto_area" class="form-control" readonly>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Distributor to Outlet
                                        </label>

                                        <input type="text" id="auto_distributor" class="form-control" readonly>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Inflator
                                        </label>

                                        <input type="text" id="auto_inflator" class="form-control" readonly>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Regulator
                                        </label>

                                        <input type="text" id="auto_regulator" class="form-control" readonly>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- NO TABUNG --}}
                        {{-- ================================================= --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                No Tabung

                                <span class="manual-badge">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    INPUT
                                </span>

                            </label>

                            <select name="no_tabung" id="no_tabung" class="form-select" required>

                                <option value="">
                                    -- Pilih No Tabung --
                                </option>

                                @foreach ($tabungs as $tabung)
                                    <option value="{{ $tabung->kode_tabung }}" data-seri="{{ $tabung->nomor_seri }}"
                                        @selected(old('no_tabung') == $tabung->kode_tabung)>

                                        {{ $tabung->kode_tabung }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- ================================================= --}}
                        {{-- SERI TABUNG --}}
                        {{-- ================================================= --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Seri Tabung
                            </label>

                            <input type="text" id="seri_tabung_display" class="form-control bg-light" readonly
                                placeholder="Otomatis dari No Tabung">

                        </div>


                        {{-- ================================================= --}}
                        {{-- ITEM --}}
                        {{-- ================================================= --}}

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                Item

                                <span class="manual-badge">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    INPUT MANUAL
                                </span>

                            </label>

                            <select name="item" class="form-select" required>

                                <option value="">
                                    -- Pilih Item --
                                </option>

                                <option value="ISI N2" @selected(old('item') === 'ISI N2')>
                                    ISI N2
                                </option>

                                <option value="KOSONG" @selected(old('item') === 'KOSONG')>
                                    KOSONG
                                </option>

                            </select>

                        </div>




                        {{-- ================================================= --}}
                        {{-- TEKANAN --}}
                        {{-- ================================================= --}}

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                Tekanan (PSI)

                                <span class="badge" style="background:#fef3c7;color:#92400e;">
                                    INPUT MANUAL
                                </span>

                            </label>

                            <input type="number" name="tekanan" id="tekanan" class="form-control" min="0"
                                step="0.001" value="{{ old('tekanan') }}" placeholder="Contoh: 1300" required>

                        </div>





                        {{-- ================================================= --}}
                        {{-- SALES TABUNG --}}
                        {{-- ================================================= --}}

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                Sales Tabung (Rp)

                                <span class="badge" style="background:#fef3c7;color:#92400e;">
                                    INPUT MANUAL
                                </span>

                            </label>

                            <input type="number" name="sales_tabung" id="sales_tabung" class="form-control"
                                min="0" step="0.01" value="{{ old('sales_tabung') }}"
                                placeholder="Contoh: 1313000" required>

                        </div>


                        {{-- ================================================= --}}
                        {{-- KETERANGAN --}}
                        {{-- ================================================= --}}

                        <div class="col-md-3">

                            <label class="form-label fw-semibold">

                                Keterangan

                                <span class="badge" style="background:#fef3c7;color:#92400e;">
                                    INPUT MANUAL
                                </span>

                            </label>

                            <select name="keterangan" class="form-select" required>

                                <option value="">
                                    -- Pilih Keterangan --
                                </option>

                                <option value="BELUM HABIS" @selected(old('keterangan') === 'BELUM HABIS')>
                                    BELUM HABIS
                                </option>

                                <option value="HABIS" @selected(old('keterangan') === 'HABIS')>
                                    HABIS
                                </option>

                                <option value="LANJUTAN" @selected(old('keterangan') === 'LANJUTAN')>
                                    LANJUTAN
                                </option>

                                <option value="KOSONG" @selected(old('keterangan') === 'KOSONG')>
                                    KOSONG
                                </option>

                            </select>

                        </div>

                        {{-- CATATAN --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Catatan

                                <span class="badge" style="background:#fef3c7;color:#92400e;">
                                    INPUT MANUAL
                                </span>

                            </label>

                            <textarea name="catatan" class="form-control" rows="2" placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                        </div>

                        {{-- Nama Operator --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Nama Operator

                                <span class="badge" style="background:#fef3c7;color:#92400e;">
                                    INPUT MANUAL
                                </span>

                            </label>

                            <input type="text" name="nama_operator" class="form-control"
                                value="{{ old('nama_operator') }}" placeholder="Masukkan nama operator (Wajib)" required>
                        </div>

                    </div>


                    <hr class="sales-form-divider">


                    {{-- BUTTON --}}

                    <div class="sales-actions">

                        <a href="{{ route('sales.index') }}" class="btn btn-sales-cancel">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-sales-save">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Simpan Data Sales
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- ERROR VALIDATION --}}
    {{-- ============================================================= --}}

    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    html: `
                    <ul style="text-align:left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `
                });

            });
        </script>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const outlet =
                document.getElementById('outlet_id');

            const dateIn =
                document.getElementById('date_in');

            const bulan =
                document.getElementById('bulan');


            const noTabung =
                document.getElementById('no_tabung');

            const seriDisplay =
                document.getElementById('seri_tabung_display');


            /* =========================================================
               OUTLET OTOMATIS
            ========================================================= */

            outlet.addEventListener('change', function() {

                const option =
                    this.options[this.selectedIndex];

                document.getElementById('auto_spv').value =
                    option.dataset.spv || '-';

                document.getElementById('auto_area').value =
                    option.dataset.area || '-';

                document.getElementById('auto_distributor').value =
                    option.dataset.distributor || '-';

                document.getElementById('auto_inflator').value =
                    option.dataset.inflator || '-';

                document.getElementById('auto_regulator').value =
                    option.dataset.regulator || '-';

            });


            /* =========================================================
               BULAN OTOMATIS DARI DATE IN
            ========================================================= */

            function updateBulan() {

                if (!dateIn.value) {
                    return;
                }

                const date =
                    new Date(dateIn.value + 'T00:00:00');

                const months = [
                    'JANUARY',
                    'FEBRUARY',
                    'MARCH',
                    'APRIL',
                    'MAY',
                    'JUNE',
                    'JULY',
                    'AUGUST',
                    'SEPTEMBER',
                    'OCTOBER',
                    'NOVEMBER',
                    'DECEMBER'
                ];

                const namaBulan =
                    months[date.getMonth()];

                bulan.value = namaBulan;
            }


            dateIn.addEventListener(
                'change',
                updateBulan
            );


            updateBulan();


            /* =========================================================
               SERI TABUNG OTOMATIS
            ========================================================= */

            noTabung.addEventListener('change', function() {

                const option =
                    this.options[this.selectedIndex];

                seriDisplay.value =
                    option.dataset.seri || '-';

            });


            /* Jalankan saat halaman pertama dibuka */

            if (noTabung.value) {

                const option =
                    noTabung.options[
                        noTabung.selectedIndex
                    ];

                seriDisplay.value =
                    option.dataset.seri || '-';

            }

        });
    </script>

@endsection
