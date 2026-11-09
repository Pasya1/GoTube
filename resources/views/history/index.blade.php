@extends('layouts.master')

@section('title', 'History Pengiriman')

@section('content')
    <div class="container mt-4">
        <h3 class="title-page text-center mb-4 text-uppercase" style="margin-top: 10%; color:#024E7F;">
            History Pengiriman
        </h3>

        @if ($jumlahMenunggu > 0)
            <div
                class="alert alert-warning shadow-sm border-0 rounded-4 d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="mb-1">

                        <i class="fa fa-bell text-danger"></i>

                        Ada {{ $jumlahMenunggu }} laporan kerusakan baru

                    </h5>

                    <small>

                        Laporan tersebut masih menunggu pemeriksaan Admin.

                    </small>

                </div>

            </div>
        @endif

        <!-- Filter -->
        <form method="GET" class="row g-3 mb-3 align-items-end">
            <div class="col-12 col-sm-6 col-md-3">
                <label for="tanggal_awal" class="form-label">Dari:</label>
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control"
                    required>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <label for="tanggal_akhir" class="form-label">Sampai:</label>
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control"
                    required>
            </div>

            <div class="col-12 col-md-3 d-flex gap-2">
                <button class="btn w-100 rounded" style="background-color: #024E7F; color: white;">Cari Data</button>
                <a href="{{ route('history.index') }}" class="btn btn-secondary rounded w-100">Reset</a>
            </div>

            <div class="col-12 col-md-3 d-flex gap-2">
                <a href="{{ route('history.export.pdf', request()->all()) }}" class="btn btn-danger rounded w-100">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('history.export.excel', request()->all()) }}" class="btn btn-success rounded w-100">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </form>

        @forelse ($pengirimans as $item)
            <div class="card mb-3 shadow border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="color: #024E7F;">{{ $item->outlet->nama_outlet ?? '-' }}</h5>
                        <p class="mb-0 text-muted">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }} -
                            <span
                                class="badge bg-{{ $item->status == 'dikirim' ? 'warning' : ($item->status == 'diterima' ? 'success' : 'danger') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-0 action-button-group">

                        <button class="btn btn-detail btn-history" data-id="{{ $item->id }}">

                            <i class="fa fa-eye me-1"></i>
                            Detail

                        </button>

                        @if ($item->laporanKerusakan->count())
                            <button class="btn btn-primary btn-view-laporan btn-history" data-id="{{ $item->id }}">

                                <i class="fa fa-file-alt me-1"></i>
                                View Laporan

                            </button>
                        @endif

                        @if (auth()->user()->role == 'admin')
                            @php
                                $semuaSelesai =
                                    $item->laporanKerusakan->count() > 0 &&
                                    $item->laporanKerusakan->where('status', '!=', 'selesai')->count() == 0;
                            @endphp

                            @if ($item->laporanKerusakan->count() && !$semuaSelesai)
                                <button class="btn btn-success btn-history btn-status" data-id="{{ $item->id }}"
                                    data-status="{{ $item->status }}">
                                    <i class="fa fa-edit me-1"></i>
                                    Ubah Status
                                </button>
                            @endif
                        @endif

                        @if (auth()->user()->role == 'spv')
                            <button class="btn btn-danger btn-laporan btn-history" data-id="{{ $item->id }}">

                                <i class="fa fa-exclamation-triangle me-1"></i>
                                Laporkan Kerusakan

                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Tidak ada pengiriman untuk ditampilkan.</div>
        @endforelse
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #024E7F;">
                    <h5 class="modal-title">Detail Pengiriman</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <p>Memuat...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKerusakan">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-danger text-white">

                    <h5>
                        Laporan Kerusakan Tabung
                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <form id="formKerusakan">

                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="pengirimans_id" id="pengirimans_id">

                        <label class="fw-bold">

                            Pilih Tabung Yang Rusak

                        </label>

                        <div id="listTabung" class="border rounded p-3">

                        </div>

                        <div class="mt-3">

                            <label>

                                Catatan Kerusakan

                            </label>

                            <textarea class="form-control" rows="5" name="catatan" required></textarea>

                        </div>
                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Tutup

                        </button>

                        <button class="btn btn-danger">

                            Simpan Laporan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <div class="modal fade" id="modalViewLaporan">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">

                    <h5>Detail Laporan Kerusakan</h5>

                    <button class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body" id="isiLaporan">

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Ubah Status -->
    <div class="modal fade" id="modalStatus" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">

                        <i class="fa fa-edit"></i>

                        Ubah Status Pengiriman

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <form id="formStatus">

                    @csrf

                    <input type="hidden" id="status_pengiriman_id" name="pengiriman_id">

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="fw-bold">

                                Status Pengiriman

                            </label>

                            <select class="form-select" id="status_pengiriman" name="status">
                                <option value="perbaikan">
                                    Sedang Dalam Perbaikan
                                </option>

                                <option value="dikirim">
                                    Dikirim
                                </option>

                                <option value="diterima">
                                    Diterima
                                </option>

                                <option value="dibatalkan">
                                    Dibatalkan
                                </option>

                            </select>

                        </div>

                        <div class="alert alert-info mb-0">

                            <i class="fa fa-info-circle"></i>

                            Gunakan menu ini jika status pengiriman
                            perlu diubah kembali setelah proses
                            perbaikan selesai.

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-success">

                            <i class="fa fa-save"></i>

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>
        .btn-history {

            min-width: 170px;

            border-radius: 12px;

            font-weight: 600;

            transition: .3s;

            box-shadow: 0 4px 10px rgba(0, 0, 0, .12);

        }

        .btn-history:hover {

            transform: translateY(-2px);

            box-shadow: 0 8px 18px rgba(0, 0, 0, .18);

        }

        .btn-detail {

            background: #024E7F !important;

            color: #fff !important;

        }

        .btn-detail:hover {

            background: #0367a6 !important;

        }

        .btn-view-laporan {

            background: #0d6efd;

            color: white;

        }

        .btn-view-laporan:hover {

            background: #0b5ed7;

        }

        .btn-laporan {

            background: #dc3545;

            color: white;

        }

        .btn-laporan:hover {

            background: #bb2d3b;

        }

        @media(max-width:768px) {

            .card-body {

                display: flex;

                flex-direction: column;

                align-items: flex-start !important;

            }

            .action-button-group {

                width: 100%;

                margin-top: 15px;

            }

            .action-button-group button {

                width: 100%;

            }

            .btn-history {

                min-width: 100%;

                padding: 12px;

                font-size: 15px;

            }

        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = "{{ csrf_token() }}";

            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    fetch(`{{ url('history') }}/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let isAdmin = @json(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'admin');
                            let tabungList = data.detail_pengirimans.map(t =>
                                `<li>${t.kode_tabung}</li>`).join('');
                            let tabungListAmbil = data.detail_pengambilan_kosongs.map(t =>
                                `<li>${t.kode_tabung}</li>`).join('');

                            function formatTanggal(tanggal) {
                                if (!tanggal) return 'Tidak Ada';
                                const bulanIndo = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November',
                                    'Desember'
                                ];
                                const tgl = new Date(tanggal);
                                return `${tgl.getDate()} ${bulanIndo[tgl.getMonth()]} ${tgl.getFullYear()}`;
                            }

                            let html = `
                            <div class="card shadow-sm mb-3 border-0">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <div style="min-width:130px; color:#024E7F;"><strong>Outlet:</strong></div>
                                        <div>${data.outlet?.nama_outlet ?? 'Tidak Ada'}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div style="min-width:130px; color:#024E7F;"><strong>Tanggal:</strong></div>
                                        <div>${formatTanggal(data.tanggal_pengiriman)}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm mb-3 border-0">
                                <div class="card-header bg-light text-center text-uppercase fw-bold" style="color:#024E7F;">
                                    Tabung Isi Dikirim Ke Outlet
                                </div>
                                <div class="card-body">
                                    <ul class="mb-2">${tabungList || '<li>-</li>'}</ul>
                                    <div class="bg-light text-muted small p-2 rounded w-100">
                                        <strong>Keterangan :</strong><br>${data.keterangan ?? 'Tidak Ada'}
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light text-uppercase text-center fw-bold" style="color:#024E7F;">
                                    Tabung Kosong Diambil Dari Outlet
                                </div>
                                <div class="card-body">
                                    <ul class="mb-2">${tabungListAmbil || '<li>-</li>'}</ul>
                                    <div class="bg-light text-muted small p-2 rounded w-100">
                                        <strong>Keterangan Pengambilan :</strong><br>${data.keterangan_pengambilan ?? 'Tidak Ada'}
                                    </div>
                                </div>
                            </div>
                            `;

                            let statusColor = 'text-muted';
                            let statusText = data.status ?? '-';

                            // Ubah teks dan warna sesuai status
                            switch (data.status) {
                                case 'dikirim':
                                    statusColor = 'text-warning';
                                    statusText = 'Menunggu Persetujuan';
                                    break;
                                case 'diterima':
                                    statusColor = 'text-success';
                                    statusText = 'Accepted';
                                    break;
                                case 'dibatalkan':
                                    statusColor = 'text-danger';
                                    statusText = 'Rejected';
                                    break;
                            }

                            html += `
                                    <div class="card shadow-sm border-0 mt-3">
                                        <div class="card-header bg-light fw-bold text-uppercase" style="color:#024E7F;">
                                            Status Pengiriman
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div style="min-width:130px; color:#024E7F;"><strong>Status:</strong></div>
                                                <div class="fw-semibold text-capitalize ${statusColor}">
                                                    ${statusText}
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                            document.getElementById('detailContent').innerHTML = html;
                            $('#modalDetail').modal('show');
                        })
                        .catch(() => Swal.fire('Error', 'Gagal memuat detail pengiriman.',
                            'error'));
                });
            });
        });


        document.querySelectorAll('.btn-laporan').forEach(btn => {

            btn.addEventListener('click', function() {

                let id = this.dataset.id;

                fetch(`/history/${id}`)
                    .then(res => res.json())
                    .then(data => {

                        // id pengiriman
                        $('#pengirimans_id').val(data.id);

                        // membuat checkbox tabung
                        let html = '';

                        data.detail_pengirimans.forEach(function(item) {

                            html += `
                        <div class="form-check mb-2">

                          <input
                            type="checkbox"
                            name="kode_tabung[]"
                            value="${item.kode_tabung}">

                            <label
                                class="form-check-label"
                                for="tabung${item.id}">

                                ${item.kode_tabung}

                            </label>

                        </div>
                    `;

                        });

                        $('#listTabung').html(html);

                        $('#modalKerusakan').modal('show');

                    });

            });

        });

        $('#formKerusakan').submit(function(e) {

            e.preventDefault();

            $.ajax({

                url: "{{ route('laporan.store') }}",

                method: "POST",

                data: $(this).serialize(),

                success: function(response) {

                    $('#modalKerusakan').modal('hide');

                    $('#formKerusakan')[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Laporan kerusakan berhasil dikirim',
                        timer: 1800,
                        showConfirmButton: false
                    });

                    setTimeout(function() {

                        location.reload();

                    }, 1800);

                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseText
                    });

                }

            });

        });


        document.querySelectorAll('.btn-view-laporan').forEach(function(btn) {

            btn.addEventListener('click', function() {

                let id = this.dataset.id;

                fetch('/laporan-kerusakan/pengiriman/' + id)

                    .then(res => res.json())

                    .then(function(data) {

                        let html = '';

                        data.forEach(function(item) {

                            let warna = 'secondary';
                            let textStatus = item.status;

                            if (item.status == 'menunggu') {
                                warna = 'warning';
                                textStatus = 'Menunggu';
                            }

                            if (item.status == 'diproses') {
                                warna = 'primary';
                                textStatus = 'Diproses';
                            }

                            if (item.status == 'selesai') {
                                warna = 'success';
                                textStatus = 'Selesai Diperbaiki';
                            }

                            if (item.status == 'ditolak') {
                                warna = 'danger';
                                textStatus = 'Ditolak';
                            }

                            html += `

                    <div class="card mb-3 shadow-sm">

                        <div class="card-body">

                            <h6>

                                ${item.kode_tabung}

                            </h6>

                            <p>

                                ${item.catatan}

                            </p>

                         <span class="badge bg-${warna}">
                            ${textStatus}
                        </span>

                        </div>

                    </div>

                `;

                        });

                        $('#isiLaporan').html(html);

                        $('#modalViewLaporan').modal('show');

                    });

            });

        });

        $('.btn-status').click(function() {

            let id = $(this).data('id');

            let status = $(this).data('status');

            $('#status_pengiriman_id').val(id);

            $('#status_pengiriman').val(status);

            $('#modalStatus').modal('show');

        });

        $('#formStatus').submit(function(e) {

            e.preventDefault();

            $.ajax({

                url: "{{ route('history.updateStatus') }}",

                type: "POST",

                data: $(this).serialize(),

                success: function(response) {

                    $('#modalStatus').modal('hide');

                    // Jika status dipilih "Dikirim"
                    if (response.status == 'dikirim') {

                        Swal.fire({

                            icon: 'success',
                            title: 'Pengiriman Berhasil Dikirim Ulang',
                            html: `
                <div class="mt-2">
                    Data berhasil dipindahkan kembali ke
                    <b>Menu Pengiriman</b>.
                </div>
            `,
                            showCancelButton: true,
                            confirmButtonText: 'Lihat Pengiriman',
                            cancelButtonText: 'Tetap di History',
                            confirmButtonColor: '#024E7F',
                            cancelButtonColor: '#6c757d'

                        }).then((result) => {

                            if (result.isConfirmed) {

                                window.location.href = "{{ route('tracking.index') }}";

                            } else {

                                location.reload();

                            }

                        });

                    } else {

                        Swal.fire({

                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false

                        });

                        setTimeout(function() {

                            location.reload();

                        }, 1500);

                    }

                },

                error: function(xhr) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text: 'Status gagal diubah.'

                    });

                }

            });

        });
    </script>
@endsection
