@extends('layouts.master')

@section('title', 'Data Outlet | Go Tube')

@section('content')

    <style>
        <style>

        /* FIX LEAFLET DI DALAM MODAL */
        .leaflet-container {
            width: 100%;
            height: 100%;
            font-family: inherit;
            z-index: 1;
        }

        .leaflet-container img {
            max-width: none !important;
        }

        .leaflet-tile {
            max-width: none !important;
        }

        .leaflet-control {
            z-index: 2;
        }

        .map-wrapper {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 10px;
            position: relative;
        }

        .search-results {
            max-height: 260px;
            overflow-y: auto;
            border-radius: 8px;
        }

        .search-result-item {
            cursor: pointer;
            transition: .2s;
        }

        .search-result-item:hover {
            background: #f0f7fb;
        }
    </style>

    <div class="container">

        <h3 class="fw-bold mb-4 title-page text-uppercase text-center" style="color:#024E7F;">
            Data Outlet
        </h3>


        {{-- =========================================================
        HEADER
    ========================================================== --}}

        <div class="row g-2 align-items-center mb-4">

            @if (Auth::user()->role !== 'kurir' && Auth::user()->role !== 'spv')
                <div class="col-12 col-sm-auto">

                    <button class="btn w-100 rounded shadow" style="background-color:#3BA484;color:white;"
                        data-bs-toggle="modal" data-bs-target="#modalTambah">

                        <i class="fa-solid fa-plus me-1"></i>

                        Tambah Outlet

                    </button>

                </div>
            @endif


            <div class="col-12 col-sm">

                <input type="text" id="searchInput" class="form-control w-100" placeholder="Cari outlet...">

            </div>

        </div>


        {{-- =========================================================
        OUTLET CARDS
    ========================================================== --}}

        <div class="row g-3" id="outletCards">

            @forelse ($outlets as $o)
                <div class="col-12 col-sm-6 col-lg-4 outlet-card">

                    <div class="card shadow-sm rounded-4 h-100">

                        <div class="card-body">

                            <h5 class="fw-bold text-center text-uppercase" style="color:#024E7F;">

                                {{ $o->nama_outlet }}

                            </h5>


                            <div class="card-info-row mb-1">

                                <div class="card-info-label">
                                    SPV
                                </div>

                                <div class="card-info-value">
                                    : {{ $o->nama_spv ?? '-' }}
                                </div>

                            </div>


                            <div class="card-info-row mb-1">

                                <div class="card-info-label">
                                    Area
                                </div>

                                <div class="card-info-value">
                                    : {{ $o->nama_area ?? '-' }}
                                </div>

                            </div>


                            <div class="card-info-row mb-1">

                                <div class="card-info-label">
                                    Vendor
                                </div>

                                <div class="card-info-value">
                                    : {{ $o->nama_vendor ?? '-' }}
                                </div>

                            </div>


                            <div class="card-info-row mb-1">

                                <div class="card-info-label">
                                    Harga Isi N₂
                                </div>

                                <div class="card-info-value">

                                    : Rp
                                    {{ number_format($o->harga_isi_n2, 0, ',', '.') }}

                                </div>

                            </div>


                            <p>
                                {{ $o->alamat ?? '-' }}
                            </p>


                            {{-- MINI MAP --}}

                            @if ($o->latitude && $o->longitude)
                                <div class="outlet-map" data-lat="{{ $o->latitude }}" data-lng="{{ $o->longitude }}"
                                    data-nama="{{ $o->nama_outlet }}"
                                    style="
                                    height:150px;
                                    width:100%;
                                    border-radius:10px;
                                    overflow:hidden;
                                ">
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light text-muted"
                                    style="
                                    height:150px;
                                    border-radius:10px;
                                ">

                                    <span>

                                        <i class="fa-solid fa-location-dot me-1"></i>

                                        Lokasi belum tersedia

                                    </span>

                                </div>
                            @endif

                        </div>


                        {{-- FOOTER --}}

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">

                            {{-- DETAIL --}}

                            <button class="btn btn-primary btn-sm btn-detail rounded" data-nama="{{ $o->nama_outlet }}"
                                data-spv="{{ $o->nama_spv }}" data-area="{{ $o->nama_area }}"
                                data-vendor="{{ $o->nama_vendor }}" data-inflator="{{ $o->merk_inflator }}"
                                data-regulator="{{ $o->merk_regulator }}" data-distribusi="{{ $o->distribusi_by }}"
                                data-harga="{{ number_format($o->harga_isi_n2, 0, ',', '.') }}"
                                data-lat="{{ $o->latitude }}" data-lng="{{ $o->longitude }}" data-bs-toggle="modal"
                                data-bs-target="#modalDetail">

                                <i class="fa-solid fa-eye"></i>

                                Detail

                            </button>


                            @if (Auth::user()->role !== 'kurir' && Auth::user()->role !== 'spv')
                                <div>

                                    {{-- EDIT --}}

                                    <button class="btn btn-warning btn-sm text-white btn-edit rounded"
                                        data-id="{{ $o->id }}" data-nama="{{ $o->nama_outlet }}"
                                        data-spv="{{ $o->nama_spv }}" data-area="{{ $o->nama_area }}"
                                        data-inflator="{{ $o->merk_inflator }}" data-regulator="{{ $o->merk_regulator }}"
                                        data-distribusi="{{ $o->distribusi_by }}" data-vendor="{{ $o->nama_vendor }}"
                                        data-harga="{{ $o->harga_isi_n2 }}" data-lat="{{ $o->latitude }}"
                                        data-lng="{{ $o->longitude }}" data-bs-toggle="modal" data-bs-target="#modalEdit">

                                        <i class="fa-solid fa-pen"></i>

                                    </button>


                                    {{-- DELETE --}}

                                    <form action="{{ route('outlet.destroy', $o->id) }}" method="POST"
                                        class="d-inline form-delete">

                                        @csrf

                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm rounded">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <p class="text-center text-muted">
                    Belum ada data outlet.
                </p>
            @endforelse

        </div>

    </div>


    {{-- =========================================================
    MODAL DETAIL
========================================================== --}}

    <div class="modal fade" id="modalDetail" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Detail Outlet
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <h4 id="detailNama" class="fw-bold mb-3 text-center" style="color:#024E7F;">
                    </h4>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            SPV
                        </div>

                        <div class="card-info-value" id="detailSpv">
                        </div>
                    </div>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            Area
                        </div>

                        <div class="card-info-value" id="detailArea">
                        </div>
                    </div>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            Vendor
                        </div>

                        <div class="card-info-value" id="detailVendor">
                        </div>
                    </div>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            Merk Inflator
                        </div>

                        <div class="card-info-value" id="detailInflator">
                        </div>
                    </div>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            Merk Regulator
                        </div>

                        <div class="card-info-value" id="detailRegulator">
                        </div>
                    </div>


                    <div class="card-info-row mb-1">
                        <div class="card-info-label">
                            Distribusi By
                        </div>

                        <div class="card-info-value" id="detailDistribusi">
                        </div>
                    </div>


                    <div class="card-info-row mb-3">
                        <div class="card-info-label">
                            Harga Isi N₂
                        </div>

                        <div class="card-info-value">
                            Rp
                            <span id="detailHarga"></span>
                        </div>
                    </div>


                    <div id="detailMap"
                        style="
                        height:300px;
                        width:100%;
                        border-radius:10px;
                        overflow:hidden;
                    ">
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
    MODAL TAMBAH
========================================================== --}}

    <div class="modal fade" id="modalTambah" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form action="{{ route('outlet.store') }}" method="POST">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Outlet
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        @include('outlet.form')

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-success">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
    MODAL EDIT
========================================================== --}}

    <div class="modal fade" id="modalEdit" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form id="formEdit" method="POST">

                    @csrf

                    @method('PUT')


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Outlet
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        @include('outlet.form', [
                            'isEdit' => true,
                        ])

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>


                        <button type="submit" class="btn btn-warning text-white">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
    LEAFLET CSS
========================================================== --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">


    {{-- =========================================================
    LEAFLET JS
========================================================== --}}

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <script>
        /*
                                                                |--------------------------------------------------------------------------
                                                                | GLOBAL MAP VARIABLES
                                                                |--------------------------------------------------------------------------
                                                                */

        let tambahMap = null;
        let tambahMarker = null;

        let editMap = null;
        let editMarker = null;

        let detailMap = null;


        /*
        |--------------------------------------------------------------------------
        | DEFAULT JAKARTA
        |--------------------------------------------------------------------------
        */

        const DEFAULT_LAT = -6.200000;
        const DEFAULT_LNG = 106.816666;


        /*
        |--------------------------------------------------------------------------
        | SEARCH OUTLET CARD
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('searchInput')
            .addEventListener('keyup', function() {

                let filter =
                    this.value.toLowerCase();

                document
                    .querySelectorAll('.outlet-card')
                    .forEach(function(card) {

                        let text =
                            card.innerText.toLowerCase();

                        card.style.display =
                            text.includes(filter) ?
                            '' :
                            'none';

                    });

            });


        /*
        |--------------------------------------------------------------------------
        | MINI MAP OUTLET
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.outlet-map')
            .forEach(function(element) {

                let lat =
                    parseFloat(element.dataset.lat);

                let lng =
                    parseFloat(element.dataset.lng);


                if (
                    isNaN(lat) ||
                    isNaN(lng)
                ) {
                    return;
                }


                let map =
                    L.map(element, {

                        zoomControl: false,

                        dragging: false,

                        scrollWheelZoom: false,

                        doubleClickZoom: false,

                        boxZoom: false,

                        keyboard: false,

                        touchZoom: false

                    })
                    .setView(
                        [lat, lng],
                        14
                    );


                L.tileLayer(
                        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

                            maxZoom: 19,

                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'

                        }
                    )
                    .addTo(map);


                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(
                        element.dataset.nama || 'Outlet'
                    );

            });


        /*
        |--------------------------------------------------------------------------
        | CREATE ADD MAP
        |--------------------------------------------------------------------------
        */

        function initTambahMap() {

            if (tambahMap !== null) {

                setTimeout(function() {
                    tambahMap.invalidateSize(true);
                }, 500);

                return;
            }

            const mapElement =
                document.getElementById('mapTambah');

            if (!mapElement) {
                return;
            }

            tambahMap = L.map(
                'mapTambah', {
                    zoomControl: true,
                    preferCanvas: false
                }
            ).setView(
                [
                    DEFAULT_LAT,
                    DEFAULT_LNG
                ],
                13
            );

            L.tileLayer(
                'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors'
                }
            ).addTo(tambahMap);

            tambahMarker =
                L.marker(
                    [
                        DEFAULT_LAT,
                        DEFAULT_LNG
                    ], {
                        draggable: true
                    }
                ).addTo(tambahMap);

            setTambahCoordinate(
                DEFAULT_LAT,
                DEFAULT_LNG
            );

            /*
             * DRAG MARKER
             */
            tambahMarker.on(
                'dragend',
                function(event) {

                    const position =
                        event.target.getLatLng();

                    setTambahCoordinate(
                        position.lat,
                        position.lng
                    );
                }
            );

            /*
             * CLICK MAP
             */
            tambahMap.on(
                'click',
                function(event) {

                    const lat =
                        event.latlng.lat;

                    const lng =
                        event.latlng.lng;

                    tambahMarker.setLatLng([
                        lat,
                        lng
                    ]);

                    setTambahCoordinate(
                        lat,
                        lng
                    );
                }
            );

            /*
             * PENTING:
             * Modal Bootstrap awalnya hidden.
             * Jadi Leaflet harus invalidate setelah modal benar-benar terbuka.
             */
            setTimeout(function() {

                tambahMap.invalidateSize(true);

            }, 700);
        }


        /*
        |--------------------------------------------------------------------------
        | SET ADD COORDINATE
        |--------------------------------------------------------------------------
        */

        function setTambahCoordinate(
            lat,
            lng
        ) {

            document.getElementById(
                'tambahLatitude'
            ).value = lat;


            document.getElementById(
                'tambahLongitude'
            ).value = lng;

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE EDIT MAP
        |--------------------------------------------------------------------------
        */

        function initEditMap(
            lat,
            lng
        ) {

            if (isNaN(lat)) {
                lat = DEFAULT_LAT;
            }

            if (isNaN(lng)) {
                lng = DEFAULT_LNG;
            }


            if (editMap !== null) {

                editMap.remove();

                editMap = null;

                editMarker = null;

            }


            editMap =
                L.map('mapEdit')
                .setView(
                    [lat, lng],
                    15
                );


            L.tileLayer(
                'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors'
                }
            ).addTo(editMap);


            editMarker =
                L.marker(
                    [lat, lng], {
                        draggable: true
                    }
                )
                .addTo(editMap);


            setEditCoordinate(
                lat,
                lng
            );


            /*
            | Drag marker
            */

            editMarker.on(
                'dragend',
                function(event) {

                    let position =
                        event.target.getLatLng();

                    setEditCoordinate(
                        position.lat,
                        position.lng
                    );

                }
            );


            /*
            | Click map
            */

            editMap.on(
                'click',
                function(event) {

                    let newLat =
                        event.latlng.lat;

                    let newLng =
                        event.latlng.lng;


                    editMarker.setLatLng(
                        [
                            newLat,
                            newLng
                        ]
                    );


                    setEditCoordinate(
                        newLat,
                        newLng
                    );

                }
            );

            setTimeout(function() {

                if (editMap) {

                    editMap.invalidateSize(true);

                }

            }, 700);

        }


        /*
        |--------------------------------------------------------------------------
        | SET EDIT COORDINATE
        |--------------------------------------------------------------------------
        */

        function setEditCoordinate(
            lat,
            lng
        ) {

            document.getElementById(
                'editLatitude'
            ).value = lat;


            document.getElementById(
                'editLongitude'
            ).value = lng;

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH TAMBAH
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('btnSearchTambah')
            .addEventListener(
                'click',
                function() {

                    searchLocation(
                        'tambah'
                    );

                }
            );


        document
            .getElementById('searchLocationTambah')
            .addEventListener(
                'keydown',
                function(event) {

                    if (
                        event.key === 'Enter'
                    ) {

                        event.preventDefault();

                        searchLocation(
                            'tambah'
                        );

                    }

                }
            );


        /*
        |--------------------------------------------------------------------------
        | SEARCH EDIT
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('btnSearchEdit')
            .addEventListener(
                'click',
                function() {

                    searchLocation(
                        'edit'
                    );

                }
            );


        document
            .getElementById('searchLocationEdit')
            .addEventListener(
                'keydown',
                function(event) {

                    if (
                        event.key === 'Enter'
                    ) {

                        event.preventDefault();

                        searchLocation(
                            'edit'
                        );

                    }

                }
            );


        /*
        |--------------------------------------------------------------------------
        | MODAL TAMBAH
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('modalTambah')
            .addEventListener(
                'shown.bs.modal',
                function() {

                    initTambahMap();

                    setTimeout(function() {

                        if (tambahMap) {

                            tambahMap.invalidateSize(true);

                        }

                    }, 700);

                }
            );


        /*
        |--------------------------------------------------------------------------
        | RESET FORM TAMBAH
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('modalTambah')
            .addEventListener(
                'hidden.bs.modal',
                function() {

                    document
                        .getElementById(
                            'searchLocationTambah'
                        )
                        .value = '';


                    document
                        .getElementById(
                            'searchResultsTambah'
                        )
                        .style.display = 'none';

                }
            );


        /*
        |--------------------------------------------------------------------------
        | EDIT BUTTON
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.btn-edit')
            .forEach(function(btn) {

                btn.addEventListener(
                    'click',
                    function() {

                        let id =
                            this.dataset.id;


                        let lat =
                            parseFloat(
                                this.dataset.lat
                            );


                        let lng =
                            parseFloat(
                                this.dataset.lng
                            );


                        /*
                        | Form action
                        */

                        document
                            .getElementById(
                                'formEdit'
                            )
                            .action =
                            `/outlet/${id}`;


                        /*
                        | Data
                        */

                        document
                            .getElementById(
                                'editNama'
                            )
                            .value =
                            this.dataset.nama || '';


                        document
                            .getElementById(
                                'editSpv'
                            )
                            .value =
                            this.dataset.spv || '';


                        document
                            .getElementById(
                                'editArea'
                            )
                            .value =
                            this.dataset.area || '';


                        document
                            .getElementById(
                                'editInflator'
                            )
                            .value =
                            this.dataset.inflator || '';


                        document
                            .getElementById(
                                'editRegulator'
                            )
                            .value =
                            this.dataset.regulator || '';


                        document
                            .getElementById(
                                'editDistribusi'
                            )
                            .value =
                            this.dataset.distribusi || '';


                        document
                            .getElementById(
                                'editVendor'
                            )
                            .value =
                            this.dataset.vendor || '';


                        document
                            .getElementById(
                                'editHarga'
                            )
                            .value =
                            this.dataset.harga || '';


                        /*
                        | Existing coordinates
                        */

                        if (isNaN(lat)) {

                            lat =
                                DEFAULT_LAT;

                        }


                        if (isNaN(lng)) {

                            lng =
                                DEFAULT_LNG;

                        }


                        document
                            .getElementById(
                                'editLatitude'
                            )
                            .value = lat;


                        document
                            .getElementById(
                                'editLongitude'
                            )
                            .value = lng;


                        /*
                        | Clear old search
                        */

                        document
                            .getElementById(
                                'searchLocationEdit'
                            )
                            .value = '';


                        document
                            .getElementById(
                                'searchResultsEdit'
                            )
                            .style.display =
                            'none';


                        /*
                        | Create map after modal opens
                        */

                        document
                            .getElementById(
                                'modalEdit'
                            )
                            .addEventListener(
                                'shown.bs.modal',
                                function editMapHandler() {

                                    initEditMap(
                                        lat,
                                        lng
                                    );

                                    this.removeEventListener(
                                        'shown.bs.modal',
                                        editMapHandler
                                    );

                                }
                            );

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | DETAIL MAP
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.btn-detail')
            .forEach(function(btn) {

                btn.addEventListener(
                    'click',
                    function() {

                        document
                            .getElementById(
                                'detailNama'
                            )
                            .innerText =
                            this.dataset.nama || '-';


                        document
                            .getElementById(
                                'detailSpv'
                            )
                            .innerText =
                            this.dataset.spv || '-';


                        document
                            .getElementById(
                                'detailArea'
                            )
                            .innerText =
                            this.dataset.area || '-';


                        document
                            .getElementById(
                                'detailVendor'
                            )
                            .innerText =
                            this.dataset.vendor || '-';


                        document
                            .getElementById(
                                'detailInflator'
                            )
                            .innerText =
                            this.dataset.inflator || '-';


                        document
                            .getElementById(
                                'detailRegulator'
                            )
                            .innerText =
                            this.dataset.regulator || '-';


                        document
                            .getElementById(
                                'detailDistribusi'
                            )
                            .innerText =
                            this.dataset.distribusi || '-';


                        document
                            .getElementById(
                                'detailHarga'
                            )
                            .innerText =
                            this.dataset.harga || '0';


                        let lat =
                            parseFloat(
                                this.dataset.lat
                            );


                        let lng =
                            parseFloat(
                                this.dataset.lng
                            );


                        if (
                            detailMap !== null
                        ) {

                            detailMap.remove();

                            detailMap = null;

                        }


                        if (
                            isNaN(lat) ||
                            isNaN(lng)
                        ) {

                            document
                                .getElementById(
                                    'detailMap'
                                )
                                .innerHTML = `

                                <div class="d-flex
                                            align-items-center
                                            justify-content-center
                                            bg-light
                                            text-muted"
                                     style="height:100%;">

                                    <span>

                                        <i class="fa-solid fa-location-dot me-1"></i>

                                        Lokasi belum tersedia

                                    </span>

                                </div>

                            `;

                            return;

                        }


                        document
                            .getElementById(
                                'detailMap'
                            )
                            .innerHTML = '';


                        detailMap =
                            L.map(
                                'detailMap'
                            )
                            .setView(
                                [lat, lng],
                                15
                            );


                        L.tileLayer(
                            'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors'
                            }
                        ).addTo(detailMap);


                        L.marker(
                                [lat, lng]
                            )
                            .addTo(detailMap)
                            .bindPopup(
                                this.dataset.nama ||
                                'Lokasi Outlet'
                            )
                            .openPopup();


                        setTimeout(function() {

                            if (detailMap) {
                                detailMap.invalidateSize(true);
                            }

                        }, 700);

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | DELETE SWEETALERT
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.form-delete')
            .forEach(function(form) {

                form.addEventListener(
                    'submit',
                    function(e) {

                        e.preventDefault();


                        Swal.fire({

                                title: 'Yakin hapus data ini?',

                                icon: 'warning',

                                showCancelButton: true,

                                confirmButtonColor: '#d33',

                                cancelButtonColor: '#3085d6',

                                confirmButtonText: 'Ya, hapus!',

                                cancelButtonText: 'Batal'

                            })
                            .then(function(result) {

                                if (
                                    result.isConfirmed
                                ) {

                                    form.submit();

                                }

                            });

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        @if (session('success'))

            Swal.fire({

                icon: 'success',

                title: 'Berhasil',

                text: "{{ session('success') }}"

            });
        @endif
    </script>
    <script>
        async function searchLocation(type) {

            let input;
            let results;

            if (type === 'tambah') {

                input = document.getElementById(
                    'searchLocationTambah'
                );

                results = document.getElementById(
                    'searchResultsTambah'
                );

            } else {

                input = document.getElementById(
                    'searchLocationEdit'
                );

                results = document.getElementById(
                    'searchResultsEdit'
                );
            }

            const query = input.value.trim();

            if (!query) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Lokasi belum diisi',
                    text: 'Masukkan nama outlet, nama tempat, jalan, atau alamat.'
                });

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            results.style.display = 'block';

            results.innerHTML = `
            <div class="list-group-item text-center py-3">

                <div
                    class="spinner-border spinner-border-sm me-2"
                    style="color:#024E7F;"
                    role="status">
                </div>

                Mencari lokasi...

            </div>
        `;


            try {

                /*
                |--------------------------------------------------------------------------
                | REQUEST KE LARAVEL
                |--------------------------------------------------------------------------
                */

                const response = await fetch(
                    `{{ route('outlet.search-location') }}?q=${encodeURIComponent(query)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );


                if (!response.ok) {

                    throw new Error(
                        'Server pencarian mengembalikan error.'
                    );
                }


                const data = await response.json();

                const features = data.features || [];


                /*
                |--------------------------------------------------------------------------
                | TIDAK ADA HASIL
                |--------------------------------------------------------------------------
                */

                if (!features.length) {

                    results.innerHTML = `
                    <div class="list-group-item text-muted py-3">

                        <i class="fa-solid fa-circle-exclamation me-1"></i>

                        Lokasi tidak ditemukan.

                        <br>

                        <small>
                            Coba gunakan nama tempat + kota.
                            Contoh:
                            <b>Rmh Kent Makassar</b>
                        </small>

                    </div>
                `;

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | BERSIHKAN HASIL
                |--------------------------------------------------------------------------
                */

                results.innerHTML = '';


                /*
                |--------------------------------------------------------------------------
                | LOOP HASIL
                |--------------------------------------------------------------------------
                */

                features.forEach(function(item) {

                    const properties =
                        item.properties || {};

                    const geometry =
                        item.geometry || {};


                    if (
                        !geometry.coordinates ||
                        geometry.coordinates.length < 2
                    ) {
                        return;
                    }


                    const lng =
                        parseFloat(
                            geometry.coordinates[0]
                        );

                    const lat =
                        parseFloat(
                            geometry.coordinates[1]
                        );


                    if (
                        isNaN(lat) ||
                        isNaN(lng)
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NAMA
                    |--------------------------------------------------------------------------
                    */

                    const nama =
                        properties.name ||
                        properties.street ||
                        properties.city ||
                        'Lokasi';


                    /*
                    |--------------------------------------------------------------------------
                    | ALAMAT
                    |--------------------------------------------------------------------------
                    */

                    const alamatParts = [];


                    if (properties.housenumber) {

                        alamatParts.push(
                            properties.housenumber
                        );
                    }


                    if (properties.street) {

                        alamatParts.push(
                            properties.street
                        );
                    }


                    if (properties.district) {

                        alamatParts.push(
                            properties.district
                        );
                    }


                    if (properties.city) {

                        alamatParts.push(
                            properties.city
                        );
                    }


                    if (properties.state) {

                        alamatParts.push(
                            properties.state
                        );
                    }


                    const alamat =
                        alamatParts.length ?
                        alamatParts.join(', ') :
                        'Lokasi ditemukan';


                    /*
                    |--------------------------------------------------------------------------
                    | JENIS
                    |--------------------------------------------------------------------------
                    */

                    const tipe =
                        properties.type ||
                        'Lokasi';


                    /*
                    |--------------------------------------------------------------------------
                    | BUTTON RESULT
                    |--------------------------------------------------------------------------
                    */

                    const button =
                        document.createElement('button');


                    button.type = 'button';


                    button.className =
                        'list-group-item list-group-item-action text-start search-result-item';


                    button.innerHTML = `

                    <div class="d-flex align-items-start gap-2">

                        <div
                            style="
                                color:#024E7F;
                                font-size:18px;
                                margin-top:2px;
                            "
                        >
                            <i class="fa-solid fa-location-dot"></i>
                        </div>


                        <div style="min-width:0;">

                            <div class="fw-bold">

                                ${escapeHtml(nama)}

                            </div>


                            <div class="small text-muted">

                                ${escapeHtml(alamat)}

                            </div>


                            <div class="mt-1">

                                <span
                                    class="badge"
                                    style="
                                        background:#EAF5FB;
                                        color:#024E7F;
                                    "
                                >
                                    ${escapeHtml(tipe)}
                                </span>

                            </div>

                        </div>

                    </div>

                `;


                    /*
                    |--------------------------------------------------------------------------
                    | KETIKA HASIL DIPILIH
                    |--------------------------------------------------------------------------
                    */

                    button.addEventListener(
                        'click',
                        function() {

                            /*
                            |--------------------------------------------------------------------------
                            | TAMBAH
                            |--------------------------------------------------------------------------
                            */

                            if (type === 'tambah') {

                                if (
                                    !tambahMap ||
                                    !tambahMarker
                                ) {
                                    return;
                                }


                                tambahMap.setView(
                                    [lat, lng],
                                    18, {
                                        animate: true
                                    }
                                );


                                tambahMarker.setLatLng([
                                    lat,
                                    lng
                                ]);


                                setTambahCoordinate(
                                    lat,
                                    lng
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | EDIT
                            |--------------------------------------------------------------------------
                            */
                            else {

                                if (
                                    !editMap ||
                                    !editMarker
                                ) {
                                    return;
                                }


                                editMap.setView(
                                    [lat, lng],
                                    18, {
                                        animate: true
                                    }
                                );


                                editMarker.setLatLng([
                                    lat,
                                    lng
                                ]);


                                setEditCoordinate(
                                    lat,
                                    lng
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | MASUKKAN KE INPUT
                            |--------------------------------------------------------------------------
                            */

                            input.value =
                                nama +
                                ', ' +
                                alamat;


                            /*
                            |--------------------------------------------------------------------------
                            | SEMBUNYIKAN HASIL
                            |--------------------------------------------------------------------------
                            */

                            results.style.display =
                                'none';


                            /*
                            |--------------------------------------------------------------------------
                            | REFRESH MAP
                            |--------------------------------------------------------------------------
                            */

                            setTimeout(function() {

                                if (
                                    type === 'tambah' &&
                                    tambahMap
                                ) {

                                    tambahMap.invalidateSize(
                                        true
                                    );

                                }


                                if (
                                    type === 'edit' &&
                                    editMap
                                ) {

                                    editMap.invalidateSize(
                                        true
                                    );

                                }

                            }, 300);

                        }
                    );


                    results.appendChild(button);

                });


            } catch (error) {

                console.error(
                    'SEARCH LOCATION ERROR:',
                    error
                );


                results.innerHTML = `

                <div class="list-group-item text-danger py-3">

                    <i
                        class="fa-solid fa-triangle-exclamation me-1">
                    </i>

                    Gagal mencari lokasi.

                    <br>

                    <small>
                        Terjadi masalah saat menghubungi
                        server pencarian.
                    </small>

                </div>

            `;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;
        }



        /*
         * ============================================================
         * ESCAPE HTML
         * ============================================================
         */

        function escapeHtml(value) {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;
        }
    </script>

@endsection
