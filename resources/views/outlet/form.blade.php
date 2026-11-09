@php
    $isEditMode = isset($isEdit) && $isEdit;
    $prefix = $isEditMode ? 'Edit' : 'Tambah';
@endphp

<div class="mb-3">
    <label>Nama Outlet</label>


    <input type="text" name="nama_outlet" id="{{ $isEditMode ? 'editNama' : 'tambahNama' }}" class="form-control"
        required>


</div>

<div class="mb-3">
    <label>Nama SPV</label>


    <input type="text" name="nama_spv" id="{{ $isEditMode ? 'editSpv' : 'tambahSpv' }}" class="form-control">


</div>

<div class="mb-3">
    <label>Nama Area</label>


    <input type="text" name="nama_area" id="{{ $isEditMode ? 'editArea' : 'tambahArea' }}" class="form-control">


</div>

<div class="mb-3">
    <label>Merk Inflator</label>


    <input type="text" name="merk_inflator" id="{{ $isEditMode ? 'editInflator' : 'tambahInflator' }}"
        class="form-control">


</div>

<div class="mb-3">
    <label>Merk Regulator</label>


    <input type="text" name="merk_regulator" id="{{ $isEditMode ? 'editRegulator' : 'tambahRegulator' }}"
        class="form-control">


</div>

<div class="mb-3">
    <label>Distribusi By</label>


    <input type="text" name="distribusi_by" id="{{ $isEditMode ? 'editDistribusi' : 'tambahDistribusi' }}"
        class="form-control">


</div>

<div class="mb-3">
    <label>Nama Vendor</label>


    <input type="text" name="nama_vendor" id="{{ $isEditMode ? 'editVendor' : 'tambahVendor' }}"
        class="form-control">


</div>

<div class="mb-3">
    <label>Harga Isi N₂</label>


    <input type="number" name="harga_isi_n2" id="{{ $isEditMode ? 'editHarga' : 'tambahHarga' }}" class="form-control"
        step="1" min="0">


</div>

{{-- =========================================================
LOKASI
========================================================= --}}

<div class="mb-3">


    <label class="fw-bold mb-2">
        <i class="fa-solid fa-location-dot me-1"></i>
        Pilih Lokasi Outlet
    </label>


    {{-- SEARCH --}}
    <div class="input-group mb-2">

        <input type="text" id="{{ $isEditMode ? 'searchLocationEdit' : 'searchLocationTambah' }}"
            class="form-control" placeholder="Cari nama tempat atau alamat...">

        <button type="button" id="{{ $isEditMode ? 'btnSearchEdit' : 'btnSearchTambah' }}" class="btn"
            style="background:#024E7F;color:white;">

            <i class="fa-solid fa-magnifying-glass me-1"></i>
            Cari

        </button>

    </div>


    {{-- HASIL SEARCH --}}
    <div id="{{ $isEditMode ? 'searchResultsEdit' : 'searchResultsTambah' }}" class="list-group mb-2"
        style="display:none;">
    </div>


    {{-- MAP --}}
    <div id="{{ $isEditMode ? 'mapEdit' : 'mapTambah' }}"
        style="
        height:300px;
        width:100%;
        border-radius:10px;
        overflow:hidden;
        border:1px solid #ddd;
    ">
    </div>


    <small class="text-muted d-block mt-2">

        <i class="fa-solid fa-circle-info me-1"></i>

        Cari lokasi, pilih hasilnya, lalu geser marker atau klik peta
        untuk menentukan titik outlet yang paling tepat.

    </small>


    {{-- LATITUDE --}}
    <input type="hidden" name="latitude" id="{{ $isEditMode ? 'editLatitude' : 'tambahLatitude' }}">


    {{-- LONGITUDE --}}
    <input type="hidden" name="longitude" id="{{ $isEditMode ? 'editLongitude' : 'tambahLongitude' }}">


</div>
