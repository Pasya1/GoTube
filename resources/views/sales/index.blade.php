@extends('layouts.master')

@section('title', 'Data Sales')

@section('content')

    <div class="container py-4 py-md-5 mt-5">

        {{-- =========================================================
        HEADER
    ========================================================== --}}
        <div class="sales-header mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="sales-icon">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>

                    <div>
                        <h3 class="fw-bold mb-0">
                            Data Sales
                        </h3>

                        <small class="text-muted">
                            Monitoring data penjualan per tabung
                        </small>
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
        SUMMARY
    ========================================================== --}}
        <div class="row g-3 mb-4">

            {{-- TOTAL DATA --}}
            <div class="col-6 col-xl-3">
                <div class="summary-card">

                    <div class="summary-icon blue">
                        <i class="fa-solid fa-database"></i>
                    </div>

                    <div>
                        <small>Total Data</small>
                        <h4>
                            {{ number_format($totalData, 0, ',', '.') }}
                        </h4>
                    </div>

                </div>
            </div>


            {{-- TOTAL TABUNG --}}
            <div class="col-6 col-xl-3">
                <div class="summary-card">

                    <div class="summary-icon cyan">
                        <i class="fa-solid fa-gas-pump"></i>
                    </div>

                    <div>
                        <small>Total Tabung</small>
                        <h4>
                            {{ number_format($totalTabung, 0, ',', '.') }}
                        </h4>
                    </div>

                </div>
            </div>


            {{-- TOTAL TEKANAN --}}
            <div class="col-6 col-xl-3">
                <div class="summary-card">

                    <div class="summary-icon orange">
                        <i class="fa-solid fa-gauge-high"></i>
                    </div>

                    <div>
                        <small>Total Tekanan</small>
                        <h4>
                            {{ number_format($totalTekanan, 0, ',', '.') }}
                        </h4>
                        <small>PSI</small>
                    </div>

                </div>
            </div>

            {{-- TOTAL SALES --}}
            <div class="col-6 col-xl-3">
                <div class="summary-card summary-sales">

                    <div class="summary-icon green">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div class="summary-content">
                        <small>Total Sales</small>

                        <h4>
                            Rp {{ number_format($totalSales, 0, ',', '.') }}
                        </h4>
                    </div>

                </div>
            </div>

        </div>


        {{-- =========================================================
        FILTER
    ========================================================== --}}
        {{-- =========================================================
FILTER
========================================================== --}}
        <div class="card filter-card border-0 shadow-sm mb-4">

            {{-- FILTER HEADER / TOGGLE --}}
            <button type="button" class="filter-header border-0 w-100 text-start" data-bs-toggle="collapse"
                data-bs-target="#filterSalesCollapse" aria-expanded="false" aria-controls="filterSalesCollapse">

                <div class="d-flex align-items-center justify-content-between w-100">

                    <div class="d-flex align-items-center gap-2">

                        <div class="filter-toggle-icon">
                            <i class="fa-solid fa-filter"></i>
                        </div>

                        <div>
                            <div class="filter-title">
                                Filter & Pencarian
                            </div>

                            <small>
                                Filter dan urutan berlaku untuk tabel serta Export Excel
                            </small>
                        </div>

                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <span class="filter-count">
                            {{ $sales->total() }} data
                        </span>

                        <span class="filter-chevron">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>

                    </div>

                </div>
            </button>


            {{-- FILTER CONTENT --}}
            <div class="collapse" id="filterSalesCollapse">

                <div class="card-body">

                    <form method="GET" action="{{ route('sales.index') }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <p class="text-muted small mb-3">
                            Terapkan filter terlebih dahulu. Excel akan memuat seluruh hasil filter, dari semua halaman tabel.
                        </p>

                        {{-- =====================================================
                SEARCH + FILTER UTAMA
                ====================================================== --}}
                        <div class="row g-3 mb-3">

                            {{-- SEARCH --}}
                            <div class="col-12 col-lg-5">

                                <label class="form-label fw-semibold">
                                    Cari Data
                                </label>

                                <div class="search-box">

                                    <i class="fa-solid fa-magnifying-glass"></i>

                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control" placeholder="Cari tabung, outlet, SPV, area, item...">

                                </div>

                            </div>


                            {{-- BULAN --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">
                                    Bulan
                                </label>

                                <select name="bulan" class="form-select">

                                    <option value="">
                                        Semua Bulan
                                    </option>

                                    @foreach (['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $bulan)
                                        <option value="{{ $bulan }}" @selected(request('bulan') == $bulan)>
                                            {{ $bulan }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            {{-- ITEM --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">
                                    Item
                                </label>

                                <select name="item" class="form-select">

                                    <option value="">
                                        Semua Item
                                    </option>

                                    <option value="ISI N2" @selected(request('item') === 'ISI N2')>
                                        ISI N2
                                    </option>

                                    <option value="KOSONG" @selected(request('item') === 'KOSONG')>
                                        KOSONG
                                    </option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}
                            <div class="col-6 col-lg-3">

                                <label class="form-label fw-semibold">
                                    Keterangan
                                </label>

                                <select name="keterangan" class="form-select">

                                    <option value="">
                                        Semua Keterangan
                                    </option>

                                    @foreach (['BELUM HABIS', 'HABIS', 'LANJUTAN', 'KOSONG'] as $ket)
                                        <option value="{{ $ket }}" @selected(request('keterangan') === $ket)>
                                            {{ $ket }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- =====================================================
                FILTER BARIS 2
                ====================================================== --}}
                        <div class="row g-3">

                            {{-- OUTLET --}}
                            <div class="col-12 col-lg-4">

                                <label class="form-label fw-semibold">
                                    Outlet
                                </label>

                                <select name="outlet_id" class="form-select">

                                    <option value="">
                                        Semua Outlet
                                    </option>

                                    @foreach ($outlets as $outlet)
                                        <option value="{{ $outlet->id }}" @selected(request('outlet_id') == $outlet->id)>
                                            {{ $outlet->nama_outlet }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            {{-- DATE START --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">
                                    Date IN Dari
                                </label>

                                <input type="date" name="date_in_start" value="{{ request('date_in_start') }}"
                                    class="form-control">

                            </div>


                            {{-- DATE END --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">
                                    Date IN Sampai
                                </label>

                                <input type="date" name="date_in_end" value="{{ request('date_in_end') }}"
                                    class="form-control">

                            </div>


                            {{-- SORT --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-arrow-down-a-z me-1"></i>

                                    Urutkan

                                </label>

                                <select name="sort" class="form-select">

                                    <option value="date_in" @selected($sort === 'date_in')>
                                        Date IN
                                    </option>

                                    <option value="no_tabung" @selected($sort === 'no_tabung')>
                                        No Tabung
                                    </option>

                                    <option value="tekanan" @selected($sort === 'tekanan')>
                                        Tekanan
                                    </option>

                                    <option value="sales_tabung" @selected($sort === 'sales_tabung')>
                                        Sales
                                    </option>

                                    <option value="outlet_id" @selected($sort === 'outlet_id')>
                                        Outlet
                                    </option>

                                </select>

                            </div>


                            {{-- DIRECTION --}}
                            <div class="col-6 col-lg-2">

                                <label class="form-label fw-semibold">

                                    <i class="fa-solid fa-sort me-1"></i>

                                    Arah

                                </label>

                                <select name="direction" class="form-select">

                                    <option value="desc" @selected($direction === 'desc')>
                                        Terbaru / Terbesar
                                    </option>

                                    <option value="asc" @selected($direction === 'asc')>
                                        Terlama / Terkecil
                                    </option>

                                </select>

                            </div>



                        </div>


                        {{-- =====================================================
                BUTTON
                ====================================================== --}}
                        <div class="filter-buttons mt-4">

                            <button type="submit" class="btn btn-primary-main">

                                <i class="fa-solid fa-filter me-1"></i>

                                Terapkan Filter untuk Export

                            </button>


                            <a href="{{ route('sales.index') }}" class="btn btn-light border">

                                <i class="fa-solid fa-rotate-left me-1"></i>

                                Reset

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="sales-header mb-4">

            <div class="text-muted small">
                <strong class="text-dark">{{ number_format($sales->total(), 0, ',', '.') }} data siap diexport</strong>
                <div>Sesuai filter yang sudah diterapkan, mencakup semua halaman.</div>
            </div>

            <div class="header-actions">

                <a href="{{ route('sales.export', request()->except(['page', 'per_page'])) }}" class="btn btn-excel">
                    <i class="fa-solid fa-file-excel me-1"></i>
                    Export Excel
                </a>

                <a href="{{ route('sales.create') }}" class="btn btn-primary-main">
                    <i class="fa-solid fa-plus me-1"></i>
                    Input Sales
                </a>

            </div>

        </div>


        {{-- =========================================================
        TABLE
    ========================================================== --}}
        <div class="card border-0 shadow-sm sales-card">

            <div class="sales-display-toolbar">
                <div class="sales-display-intro">
                    <span class="sales-display-icon" aria-hidden="true"><i class="fa-solid fa-sliders"></i></span>
                    <div>
                        <div class="sales-display-title">Tampilan Tabel</div>
                        <p>Atur baris per halaman. Excel tetap memuat semua hasil filter.</p>
                    </div>
                </div>
                <form method="GET" action="{{ route('sales.index') }}" class="sales-display-form">
                    @foreach (request()->except(['page', 'per_page']) as $key => $value)
                        @if (is_scalar($value))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <div class="sales-page-size">
                    <label for="sales-per-page">Baris per halaman</label>
                    <select id="sales-per-page" name="per_page" class="form-select">
                        @foreach ([10, 20, 50, 100] as $pageSize)
                            <option value="{{ $pageSize }}" @selected($perPage == $pageSize)>{{ $pageSize }} baris</option>
                        @endforeach
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary-main sales-display-button">
                        <i class="fa-solid fa-check me-1" aria-hidden="true"></i> Ubah Tampilan
                    </button>
                </form>
            </div>

            <div class="card-header table-header">

                <div class="table-header-left">
                    <div class="table-header-icon">
                        <i class="fa-solid fa-table-list"></i>
                    </div>

                    <div>
                        <div class="table-title">
                            Daftar Data Sales
                        </div>

                        <small>
                            Data penjualan tabung
                        </small>
                    </div>
                </div>

                <div class="table-header-info">
                    <span class="data-count-badge">
                        <i class="fa-solid fa-database me-1"></i>
                        {{ $sales->total() }} Data
                    </span>

                    <span class="page-info">
                        Halaman {{ $sales->currentPage() }}
                        / {{ $sales->lastPage() }}
                    </span>
                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0 sales-table">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Bulan</th>

                                <th>Date IN</th>

                                <th>Item</th>

                                <th>Tekanan</th>

                                <th>No Tabung</th>

                                <th>Seri Tabung</th>

                                <th>Date END</th>

                                <th>Sales Tabung</th>

                                <th>Ket</th>

                                <th>Outlet</th>

                                <th>Outlet Detail</th>

                                <th>Catatan</th>

                                <th>Operator</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($sales as $sale)
                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center fw-semibold text-muted">

                                        {{ $sales->firstItem() + $loop->index }}

                                    </td>


                                    {{-- BULAN --}}
                                    <td class="text-center">

                                        <span class="month-badge">

                                            {{ $sale->bulan }}

                                        </span>

                                    </td>


                                    {{-- DATE IN --}}
                                    <td class="text-center">

                                        {{ $sale->date_in ? $sale->date_in->format('d/m/Y') : '-' }}

                                    </td>


                                    {{-- ITEM --}}
                                    <td class="text-center">

                                        @if ($sale->item === 'ISI N2')
                                            <span class="status-badge success">
                                                <i class="fa-solid fa-circle-check me-1"></i>
                                                ISI N2
                                            </span>
                                        @else
                                            <span class="status-badge secondary">
                                                <i class="fa-solid fa-circle me-1"></i>
                                                KOSONG
                                            </span>
                                        @endif

                                    </td>


                                    {{-- TEKANAN --}}
                                    <td class="text-end">

                                        <span class="number-cell">

                                            {{ number_format($sale->tekanan, 0, ',', '.') }}

                                            <small>PSI</small>

                                        </span>

                                    </td>


                                    {{-- NO TABUNG --}}
                                    <td class="text-center">

                                        <span class="tube-code">

                                            {{ $sale->no_tabung }}

                                        </span>

                                    </td>


                                    {{-- SERI --}}
                                    <td class="text-center">

                                        {{ $sale->seri_tabung ?? '-' }}

                                    </td>


                                    {{-- DATE END --}}
                                    <td class="text-center">

                                        {{ $sale->date_end ? $sale->date_end->format('d/m/Y') : '-' }}

                                    </td>


                                    {{-- SALES --}}
                                    <td class="text-end">

                                        <span class="sales-price">

                                            Rp
                                            {{ number_format($sale->sales_tabung, 0, ',', '.') }}

                                        </span>

                                    </td>


                                    {{-- KETERANGAN --}}
                                    <td class="text-center">

                                        @php

                                            $ketClass = match ($sale->keterangan) {
                                                'HABIS' => 'danger',
                                                'LANJUTAN' => 'primary',
                                                'KOSONG' => 'secondary',
                                                default => 'warning',
                                            };

                                        @endphp

                                        <span class="ket-badge {{ $ketClass }}">

                                            {{ $sale->keterangan }}

                                        </span>

                                    </td>


                                    {{-- OUTLET --}}
                                    <td>

                                        <div class="outlet-name">

                                            <i class="fa-solid fa-store me-1"></i>

                                            {{ $sale->outlet->nama_outlet ?? '-' }}

                                        </div>

                                    </td>


                                    {{-- DETAIL OUTLET --}}
                                    <td class="text-center">

                                        @if ($sale->outlet)
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary btn-detail-outlet"
                                                data-bs-toggle="modal" data-bs-target="#modalDetailOutlet"
                                                data-outlet="{{ $sale->outlet->nama_outlet }}"
                                                data-spv="{{ $sale->outlet->nama_spv }}"
                                                data-area="{{ $sale->outlet->nama_area }}"
                                                data-distributor="{{ $sale->outlet->distribusi_by }}"
                                                data-inflator="{{ $sale->outlet->merk_inflator }}"
                                                data-regulator="{{ $sale->outlet->merk_regulator }}">

                                                <i class="fa-solid fa-eye me-1"></i>
                                                Detail

                                            </button>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>

                                    {{-- CATATAN --}}
                                    <td class="text-center">

                                        {{ $sale->catatan ?? '-' }}

                                    </td>

                                    {{-- OPERATOR --}}
                                    <td class="text-center">

                                        {{ $sale->nama_operator ?? '-' }}
                                    </td>


                                    {{-- AKSI --}}
                                    <td class="text-center">

                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                            class="form-hapus-sales">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="13" class="empty-data">

                                        <i class="fa-regular fa-folder-open"></i>

                                        <h6>
                                            Belum ada data sales
                                        </h6>

                                        <p>
                                            Coba ubah filter atau tambahkan data sales baru.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- PAGINATION --}}
            <div class="card-footer table-footer">

                <div class="table-footer-info">

                    @if ($sales->total() > 0)
                        Menampilkan
                        <strong>{{ $sales->firstItem() }}</strong>
                        -
                        <strong>{{ $sales->lastItem() }}</strong>
                        dari
                        <strong>{{ $sales->total() }}</strong>
                        data
                    @else
                        Tidak ada data
                    @endif

                </div>

                @if ($sales->hasPages())
                    <div class="pagination-wrapper">
                        {{ $sales->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
    MODAL DETAIL OUTLET
========================================================== --}}
    <div class="modal fade" id="modalDetailOutlet" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header outlet-modal-header">

                    <div>

                        <div class="d-flex align-items-center gap-2">

                            <div class="modal-icon">

                                <i class="fa-solid fa-store"></i>

                            </div>

                            <div>

                                <h5 class="modal-title fw-bold mb-0">

                                    Detail Outlet

                                </h5>

                                <small>
                                    Informasi outlet
                                </small>

                            </div>

                        </div>

                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body p-4">

                    <div class="outlet-detail-title">

                        <i class="fa-solid fa-location-dot me-2"></i>

                        <span id="detailOutlet">
                            -
                        </span>

                    </div>


                    <div class="row g-3 mt-2">

                        <div class="col-12 col-md-6">

                            <div class="detail-box">

                                <small>
                                    SPV
                                </small>

                                <strong id="detailSpv">
                                    -
                                </strong>

                            </div>

                        </div>


                        <div class="col-12 col-md-6">

                            <div class="detail-box">

                                <small>
                                    Area
                                </small>

                                <strong id="detailArea">
                                    -
                                </strong>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="detail-box">

                                <small>
                                    Distributor to Outlet
                                </small>

                                <strong id="detailDistributor">
                                    -
                                </strong>

                            </div>

                        </div>


                        <div class="col-12 col-md-6">

                            <div class="detail-box">

                                <small>
                                    Inflator
                                </small>

                                <strong id="detailInflator">
                                    -
                                </strong>

                            </div>

                        </div>


                        <div class="col-12 col-md-6">

                            <div class="detail-box">

                                <small>
                                    Regulator
                                </small>

                                <strong id="detailRegulator">
                                    -
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer border-0">

                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">

                        Tutup

                    </button>

                </div>

            </div>

        </div>

    </div>

    <style>
        /* =========================================================
                                                                                   TABLE HEADER
                                                                                ========================================================= */

        .table-header {
            background: #ffffff;
            border-bottom: 1px solid #e5edf3;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
        }

        .table-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eaf5fb;
            color: var(--sales-primary);
        }

        .table-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--sales-text);
        }

        .table-header-left small {
            display: block;
            margin-top: 2px;
            color: #94a3b8;
            font-size: 11px;
        }

        .table-header-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .data-count-badge {
            display: inline-flex;
            align-items: center;

            padding: 6px 10px;

            background: #eaf5fb;
            color: var(--sales-primary);

            border-radius: 8px;

            font-size: 11px;
            font-weight: 700;
        }

        .page-info {
            color: #64748b;
            font-size: 12px;
        }


        /* =========================================================
                                                                                   FILTER BUTTON
                                                                                ========================================================= */

        .filter-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-buttons .btn {
            min-height: 42px;
            padding-left: 18px;
            padding-right: 18px;
        }


        /* =========================================================
                                                                                   EXCEL BUTTON
                                                                                ========================================================= */

        .btn-excel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;

            background: #198754;
            border: 1px solid #198754;

            color: #fff;

            font-weight: 700;

            border-radius: 9px;

            padding: 9px 15px;

            transition: all .2s ease;
        }

        .btn-excel:hover {
            background: #157347;
            border-color: #157347;

            color: #fff;

            transform: translateY(-1px);

            box-shadow: 0 5px 12px rgba(25, 135, 84, .20);
        }


        /* =========================================================
                                                                                   PRIMARY BUTTON
                                                                                ========================================================= */

        .btn-primary-main {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: var(--sales-primary);
            border-color: var(--sales-primary);

            color: #fff;

            font-weight: 700;

            border-radius: 9px;

            padding: 9px 15px;

            transition: all .2s ease;
        }

        .btn-primary-main:hover {
            background: var(--sales-dark);
            border-color: var(--sales-dark);
            color: #fff;

            transform: translateY(-1px);

            box-shadow:
                0 5px 12px rgba(2, 78, 127, .20);
        }


        /* =========================================================
                                                                                   TABLE
                                                                                ========================================================= */

        .sales-card {
            border-radius: 15px;
            overflow: hidden;

            border: 1px solid #edf2f7 !important;

            box-shadow:
                0 7px 25px rgba(15, 23, 42, .07) !important;
        }

        .sales-table {
            min-width: 1450px;
        }

        .sales-table thead th {
            background: #024E7F !important;
            color: #fff !important;

            border-color: rgba(255, 255, 255, .12) !important;

            text-align: center;
            vertical-align: middle;

            white-space: nowrap;

            font-size: 11px;
            font-weight: 700;

            padding: 13px 10px;
        }

        .sales-table tbody td {
            font-size: 13px;

            padding: 12px 10px;

            border-color: #edf1f5;

            white-space: nowrap;
        }

        .sales-table tbody tr {
            transition: all .15s ease;
        }

        .sales-table tbody tr:hover {
            background: #eef8fc !important;

            box-shadow:
                inset 3px 0 0 var(--sales-primary);
        }

        .sales-table tbody tr:nth-child(even) {
            background: #fbfdff;
        }

        .sales-table tbody tr:nth-child(even):hover {
            background: #eef8fc !important;
        }


        /* =========================================================
                                                                                   FOOTER
                                                                                ========================================================= */

        .table-footer {
            background: #ffffff;

            border-top: 1px solid #edf2f7 !important;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 14px 20px;
        }

        .table-footer-info {
            color: #64748b;
            font-size: 12px;
        }

        .table-footer-info strong {
            color: var(--sales-text);
            font-weight: 800;
        }


        /* =========================================================
                                                                                   PAGINATION
                                                                                ========================================================= */

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .pagination {
            margin: 0;

            gap: 4px;
        }

        .pagination .page-link {
            border: 0;

            min-width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px !important;

            color: #475569;

            font-size: 12px;
            font-weight: 600;

            background: #f8fafc;

            transition: all .15s ease;
        }

        .pagination .page-link:hover {
            background: #eaf5fb;
            color: var(--sales-primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--sales-primary);

            color: #fff;

            box-shadow:
                0 4px 10px rgba(2, 78, 127, .20);
        }

        .pagination .page-item.disabled .page-link {
            background: #f8fafc;
            color: #cbd5e1;
        }


        /* =========================================================
                                                                                   FORM SELECT
                                                                                ========================================================= */

        .form-select,
        .form-control {
            min-height: 42px;

            border: 1px solid #dbe4eb;

            border-radius: 9px;

            color: #334155;

            font-size: 13px;

            background-color: #fff;

            transition: all .15s ease;
        }

        .form-select:hover,
        .form-control:hover {
            border-color: #b8cbd7;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--sales-primary);

            box-shadow:
                0 0 0 .2rem rgba(2, 78, 127, .09);
        }


        /* =========================================================
                                                                                   FILTER HEADER
                                                                                ========================================================= */

        .filter-header {
            background: linear-gradient(135deg,
                    #024E7F,
                    #03699d);

            color: white;

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 14px 18px;

            font-weight: 700;
        }

        .filter-header span {
            background: rgba(255, 255, 255, .12);

            border-radius: 20px;

            padding: 5px 10px;

            font-size: 11px;

            font-weight: 600;

            opacity: 1;
        }


        @media (max-width: 991.98px) {

            .sales-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .table-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .table-header-info {
                width: 100%;
                justify-content: space-between;
            }

            .table-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .pagination-wrapper {
                width: 100%;
                justify-content: center;
            }
        }


        @media (max-width: 575.98px) {

            .header-actions {
                flex-direction: column;
            }

            .header-actions .btn {
                width: 100%;
            }

            .table-header {
                padding: 14px;
            }

            .table-header-info {
                align-items: flex-start;
                flex-direction: column;
            }

            .table-footer {
                padding: 14px;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }

            .pagination .page-link {
                min-width: 32px;
                height: 32px;
            }
        }

        /* =========================================================
                                       FILTER COLLAPSE
                                    ========================================================= */

        .filter-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .filter-header {
            background: linear-gradient(135deg,
                    var(--sales-primary),
                    #03699d);

            color: white;

            padding: 14px 18px;

            cursor: pointer;

            transition: all .2s ease;
        }

        .filter-header:hover {
            background: linear-gradient(135deg,
                    var(--sales-dark),
                    #035f8d);
        }

        .filter-toggle-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, .13);

            border-radius: 9px;

            flex-shrink: 0;
        }

        .filter-title {
            font-size: 14px;
            font-weight: 800;
        }

        .filter-header small {
            display: block;

            margin-top: 2px;

            font-size: 11px;

            color: rgba(255, 255, 255, .75);
        }

        .filter-count {
            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .12);

            border-radius: 20px;

            padding: 5px 10px;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;
        }

        .filter-chevron {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, .10);

            border-radius: 8px;

            transition: transform .25s ease;
        }


        /* Saat filter terbuka */
        .filter-header[aria-expanded="true"] .filter-chevron {
            transform: rotate(180deg);
        }


        /* Body filter */
        #filterSalesCollapse {
            border-top: 1px solid #e5edf3;
        }

        #filterSalesCollapse .card-body {
            background: #ffffff;
            padding: 20px;
        }


        /* Animasi collapse */
        #filterSalesCollapse.collapsing {
            transition: height .25s ease;
        }

        /* =========================================================
                                       FILTER COLLAPSE
                                    ========================================================= */

        .filter-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .filter-header {
            background: linear-gradient(135deg,
                    var(--sales-primary),
                    #03699d);

            color: white;

            padding: 14px 18px;

            cursor: pointer;

            transition: all .2s ease;
        }

        .filter-header:hover {
            background: linear-gradient(135deg,
                    var(--sales-dark),
                    #035f8d);
        }

        .filter-toggle-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, .13);

            border-radius: 9px;

            flex-shrink: 0;
        }

        .filter-title {
            font-size: 14px;
            font-weight: 800;
        }

        .filter-header small {
            display: block;

            margin-top: 2px;

            font-size: 11px;

            color: rgba(255, 255, 255, .75);
        }

        .filter-count {
            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .12);

            border-radius: 20px;

            padding: 5px 10px;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;
        }

        .filter-chevron {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, .10);

            border-radius: 8px;

            transition: transform .25s ease;
        }


        /* Saat filter terbuka */
        .filter-header[aria-expanded="true"] .filter-chevron {
            transform: rotate(180deg);
        }


        /* Body filter */
        #filterSalesCollapse {
            border-top: 1px solid #e5edf3;
        }

        #filterSalesCollapse .card-body {
            background: #ffffff;
            padding: 20px;
        }


        /* Animasi collapse */
        #filterSalesCollapse.collapsing {
            transition: height .25s ease;
        }

        /* =========================================================
               TOTAL SALES - MOBILE
            ========================================================= */

        .summary-sales .summary-content {
            min-width: 0;
        }

        .summary-sales h4 {
            white-space: nowrap;
        }


        /* MOBILE */
        @media (max-width: 575.98px) {

            .summary-sales {
                flex-direction: column;
                align-items: flex-start;
                justify-content: center;
                gap: 8px;

                padding: 13px;
            }

            .summary-sales .summary-icon {
                width: 38px;
                height: 38px;
                min-width: 38px;

                font-size: 15px;
            }

            .summary-sales .summary-content {
                width: 100%;
            }

            .summary-sales small {
                font-size: 10px;
                white-space: nowrap;
            }

            .summary-sales h4 {
                margin-top: 3px;

                font-size: 14px;
                line-height: 1.3;

                white-space: nowrap;
                overflow: visible;
                text-overflow: clip;

                letter-spacing: -0.3px;
            }

        }
    </style>
    {{-- =========================================================
    SWEET ALERT
========================================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /**
             * =========================================================
             * DETAIL OUTLET
             * =========================================================
             */
            document
                .querySelectorAll('.btn-detail-outlet')
                .forEach(function(button) {

                    button.addEventListener('click', function() {

                        document.getElementById('detailOutlet').textContent =
                            this.dataset.outlet || '-';

                        document.getElementById('detailSpv').textContent =
                            this.dataset.spv || '-';

                        document.getElementById('detailArea').textContent =
                            this.dataset.area || '-';

                        document.getElementById('detailDistributor').textContent =
                            this.dataset.distributor || '-';

                        document.getElementById('detailInflator').textContent =
                            this.dataset.inflator || '-';

                        document.getElementById('detailRegulator').textContent =
                            this.dataset.regulator || '-';

                    });

                });


            /**
             * =========================================================
             * HAPUS DATA
             * =========================================================
             */
            document
                .querySelectorAll('.form-hapus-sales')
                .forEach(function(form) {

                    form.addEventListener('submit', function(e) {

                        e.preventDefault();

                        Swal.fire({

                            title: 'Hapus Data Sales?',

                            text: 'Data yang dihapus tidak dapat dikembalikan.',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonText: 'Ya, Hapus',

                            cancelButtonText: 'Batal',

                            confirmButtonColor: '#dc2626',

                            cancelButtonColor: '#64748b',

                            reverseButtons: true,

                            focusCancel: true

                        }).then(function(result) {

                            if (result.isConfirmed) {

                                form.submit();

                            }

                        });

                    });

                });


            /**
             * =========================================================
             * SUCCESS
             * =========================================================
             */
            @if (session('success'))

                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil!',

                    text: @json(session('success')),

                    timer: 2000,

                    showConfirmButton: false

                });
            @endif

        });
    </script>


    {{-- =========================================================
    STYLE
========================================================== --}}
    <style>
        :root {

            --sales-primary: #024E7F;
            --sales-dark: #013B61;
            --sales-blue: #0d6efd;

            --sales-light: #EAF5FB;

            --sales-border: #e2e8f0;

            --sales-text: #102f42;

        }


        /* =========================================================
                                                                                                                       HEADER
                                                                                                                    ========================================================= */

        .sales-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

        }

        .sales-icon {

            width: 45px;

            height: 45px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            background: var(--sales-primary);

            box-shadow:
                0 5px 15px rgba(2, 78, 127, .20);

        }

        .sales-header h3 {

            color: var(--sales-text);

        }

        .header-actions {

            display: flex;

            gap: 8px;

            flex-wrap: wrap;

        }


        /* =========================================================
                                                                                                                       BUTTON
                                                                                                                    ========================================================= */

        .btn-primary-main {

            background: var(--sales-primary);

            border-color: var(--sales-primary);

            color: white;

            font-weight: 600;

        }

        .btn-primary-main:hover {

            background: var(--sales-dark);

            border-color: var(--sales-dark);

            color: white;

        }


        .btn-excel {

            background: #198754;

            border-color: #198754;

            color: white;

            font-weight: 600;

        }

        .btn-excel:hover {

            background: #146c43;

            border-color: #146c43;

            color: white;

        }


        /* =========================================================
                                                                                                                       SUMMARY
                                                                                                                    ========================================================= */

        .summary-card {

            background: white;

            border-radius: 14px;

            padding: 18px;

            display: flex;

            align-items: center;

            gap: 14px;

            height: 100%;

            border: 1px solid #edf1f5;

            box-shadow:
                0 5px 18px rgba(15, 23, 42, .06);

        }

        .summary-icon {

            width: 48px;

            height: 48px;

            flex-shrink: 0;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 19px;

        }

        .summary-icon.blue {

            background: #e0f2fe;

            color: #0369a1;

        }

        .summary-icon.cyan {

            background: #cffafe;

            color: #0e7490;

        }

        .summary-icon.orange {

            background: #ffedd5;

            color: #c2410c;

        }

        .summary-icon.green {

            background: #dcfce7;

            color: #15803d;

        }

        .summary-card small {

            color: #64748b;

        }

        .summary-card h4 {

            margin: 2px 0 0;

            font-weight: 800;

            color: var(--sales-text);

            font-size: 19px;

        }


        /* =========================================================
                                                                                                                       FILTER
                                                                                                                    ========================================================= */

        .filter-card {

            border-radius: 14px;

            overflow: hidden;

        }

        .filter-header {

            background: var(--sales-primary);

            color: white;

            display: flex;

            justify-content: space-between;

            align-items: center;

            font-weight: 700;

        }

        .filter-header span {

            font-size: 12px;

            font-weight: 500;

            opacity: .85;

        }

        .form-label {

            color: #334155;

            font-size: 13px;

        }

        .form-select,

        .form-control {

            min-height: 42px;

            border-color: #dbe3ea;

        }

        .form-select:focus,

        .form-control:focus {

            border-color: var(--sales-primary);

            box-shadow:
                0 0 0 .2rem rgba(2, 78, 127, .10);

        }

        .search-box {

            position: relative;

        }

        .search-box i {

            position: absolute;

            left: 14px;

            top: 13px;

            color: #94a3b8;

            z-index: 2;

        }

        .search-box input {

            padding-left: 40px;

        }

        .filter-buttons {

            display: flex;

            gap: 8px;

        }


        /* =========================================================
                                                                                                                       TABLE
                                                                                                                    ========================================================= */

        .sales-card {

            border-radius: 14px;

            overflow: hidden;

        }

        .table-header {

            background: #ffffff;

            border-bottom: 1px solid var(--sales-border);

            display: flex;

            justify-content: space-between;

            align-items: center;

            color: var(--sales-text);

            font-weight: 700;

        }

        .table-header small {

            color: #64748b;

            font-weight: 500;

        }

        .sales-table {

            min-width: 1450px;

        }

        .sales-table thead th {

            background: #024E7F !important;

            color: white !important;

            border-color: #333 !important;

            text-align: center;

            vertical-align: middle;

            white-space: nowrap;

            font-size: 12px;

            font-weight: 700;

            padding: 13px 10px;

        }

        .sales-table tbody td {

            font-size: 13px;

            padding: 12px 10px;

            border-color: #e5e7eb;

            white-space: nowrap;

        }

        .sales-table tbody tr {

            transition: .15s ease;

        }

        .sales-table tbody tr:hover {

            background: #f4f9fb;

        }

        .sales-table tbody tr:nth-child(even) {

            background: #fbfdfe;

        }

        .sales-table tbody tr:nth-child(even):hover {

            background: #f4f9fb;

        }


        /* =========================================================
                                                                                                                       BADGES
                                                                                                                    ========================================================= */

        .month-badge {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 7px;

            background: #eaf5fb;

            color: var(--sales-primary);

            font-weight: 700;

            font-size: 11px;

        }

        .status-badge {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 700;

        }

        .status-badge.success {

            color: #166534;

            background: #dcfce7;

        }

        .status-badge.secondary {

            color: #475569;

            background: #e2e8f0;

        }

        .tube-code {

            color: var(--sales-primary);

            font-weight: 800;

        }

        .number-cell {

            font-weight: 600;

        }

        .number-cell small {

            color: #94a3b8;

            font-size: 10px;

        }

        .sales-price {

            color: #166534;

            font-weight: 800;

        }

        .ket-badge {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 700;

        }

        .ket-badge.warning {

            background: #fef3c7;

            color: #92400e;

        }

        .ket-badge.danger {

            background: #fee2e2;

            color: #991b1b;

        }

        .ket-badge.primary {

            background: #dbeafe;

            color: #1e40af;

        }

        .ket-badge.secondary {

            background: #e2e8f0;

            color: #475569;

        }

        .outlet-name {

            color: var(--sales-text);

            font-weight: 700;

        }


        /* =========================================================
                                                                                                                       EMPTY
                                                                                                                    ========================================================= */

        .empty-data {

            text-align: center;

            padding: 70px 20px !important;

            color: #94a3b8;

        }

        .empty-data i {

            font-size: 42px;

            margin-bottom: 12px;

        }

        .empty-data h6 {

            color: #475569;

            font-weight: 700;

            margin-bottom: 5px;

        }

        .empty-data p {

            margin: 0;

            font-size: 13px;

        }


        /* =========================================================
                                                                                                                       OUTLET MODAL
                                                                                                                    ========================================================= */

        .outlet-modal-header {

            background: var(--sales-primary);

            color: white;

        }

        .outlet-modal-header small {

            opacity: .8;

        }

        .modal-icon {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: rgba(255, 255, 255, .15);

            border-radius: 10px;

        }

        .outlet-detail-title {

            background: #eaf5fb;

            border: 1px solid #d5eaf5;

            color: var(--sales-primary);

            border-radius: 10px;

            padding: 14px 16px;

            font-size: 18px;

            font-weight: 800;

        }

        .detail-box {

            height: 100%;

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 10px;

            padding: 13px 15px;

        }

        .detail-box small {

            display: block;

            color: #64748b;

            margin-bottom: 4px;

            font-size: 11px;

            text-transform: uppercase;

            font-weight: 700;

        }

        .detail-box strong {

            display: block;

            color: var(--sales-text);

            font-size: 14px;

            word-break: break-word;

        }


        /* =========================================================
                                                                                                                       PAGINATION
                                                                                                                    ========================================================= */

        .pagination-wrapper {

            display: flex;

            justify-content: center;

        }

        .pagination {

            margin-bottom: 0;

        }


        /* =========================================================
                                                                                                                       MOBILE
                                                                                                                    ========================================================= */

        @media (max-width: 768px) {

            .container-fluid {

                padding-left: 12px;

                padding-right: 12px;

            }

            .sales-header {

                align-items: flex-start;

                flex-direction: column;

            }

            .header-actions {

                width: 100%;

            }

            .header-actions .btn {

                flex: 1;

            }

            .summary-card {

                padding: 13px;

            }

            .summary-icon {

                width: 40px;

                height: 40px;

                font-size: 16px;

            }

            .summary-card h4 {

                font-size: 15px;

            }

            .filter-buttons {

                flex-direction: column;

            }

            .filter-buttons .btn {

                width: 100%;

            }

            .table-header {

                align-items: flex-start;

                gap: 8px;

                flex-direction: column;

            }

            .sales-table {

                min-width: 1450px;

            }

        }

        /* Controls scoped to the sales table. */
        .sales-card .sales-display-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding: 22px 24px;
            background: linear-gradient(120deg, #f0f8fc, #fff);
            border-bottom: 1px solid var(--sales-border);
        }
        .sales-display-intro { display: flex; align-items: center; gap: 12px; flex: 1 1 260px; min-width: 0; }
        .sales-display-icon {
            display: grid; place-items: center; flex: 0 0 44px; height: 44px;
            border: 1px solid #d3e7f2; border-radius: 14px;
            color: var(--sales-primary); background: #fff;
        }
        .sales-display-title { color: var(--sales-text); font-size: 14px; font-weight: 800; }
        .sales-display-intro p { margin: 4px 0 0; color: #64748b; font-size: 12px; line-height: 1.6; }
        .sales-display-form { display: flex; align-items: flex-end; gap: 10px; }
        .sales-page-size label { display: block; margin-bottom: 6px; font-size: 11px; font-weight: 700; color: #64748b; }
        .sales-page-size .form-select {
            min-width: 140px; min-height: 42px; border-radius: 10px;
            border-color: #d3e3ed; color: var(--sales-text); font-size: 13px; font-weight: 600;
        }
        .sales-page-size .form-select:focus { border-color: var(--sales-primary); box-shadow: 0 0 0 3px rgba(2,78,127,.12); }
        .sales-display-form .sales-display-button { min-height: 42px; border-radius: 10px; padding: 9px 16px; font-size: 12px; white-space: nowrap; }
        .sales-card .table-header { padding: 18px 24px; flex-wrap: wrap; }
        .sales-card .table-header-info { flex-wrap: wrap; }
        .sales-card .data-count-badge { border-radius: 20px; padding: 7px 12px; }
        .sales-card .table-footer {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
            gap: 14px; padding: 18px 24px; background: #f8fbfd; border-top: 1px solid var(--sales-border);
        }
        .sales-card .table-footer-info { color: #64748b; font-size: 12px; }
        .sales-card .table-footer-info strong { color: var(--sales-primary); }
        .sales-card .pagination-wrapper { max-width: 100%; }
        .sales-card .pagination { flex-wrap: wrap; gap: 4px; }
        .sales-card .pagination .page-link { border-radius: 9px; }
        @media (max-width: 767.98px) {
            .sales-card .sales-display-toolbar { padding: 18px 16px; gap: 16px; }
            .sales-display-intro { flex-basis: 100%; }
            .sales-display-form { width: 100%; }
            .sales-page-size { flex: 1; min-width: 0; }
            .sales-page-size .form-select { min-width: 0; width: 100%; }
            .sales-card .table-header { padding: 16px; align-items: flex-start; }
            .sales-card .table-header-info { width: 100%; justify-content: space-between; }
            .sales-card .table-footer { padding: 16px; flex-direction: column; align-items: stretch; }
            .sales-card .table-footer-info { text-align: center; }
            .sales-card .pagination-wrapper { width: 100%; justify-content: center; }
        }
    </style>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#024E7F',
                    timer: 2500,
                    timerProgressBar: true
                });

            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#DC2626'
                });

            });
        </script>
    @endif
@endsection
