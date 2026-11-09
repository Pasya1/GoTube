@extends('layouts.master')

@section('title', 'Tracking Pengiriman')

@section('content')
    <div class="container mt-4">
        <h3 class="title-page text-center mb-4 text-uppercase" style="margin-top: 10%; color:#024E7F;">Tracking Pengiriman
        </h3>

        <!-- Filter Tanggal -->
        <form method="GET" class="row g-2 mb-3 align-items-center justify-content-center">
            <div class="col-md-4">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn w-100 rounded" style="background-color: #024E7F; color: white;">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('tracking.index') }}" class="btn btn-secondary w-100 rounded">Reset</a>
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
                    <button class="btn btn-detail rounded" style="background-color: #024E7F; color:white;"
                        data-id="{{ $item->id }}">
                        <i class="fa fa-eye"></i> Detail
                    </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = "{{ csrf_token() }}";

            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    fetch(`{{ url('tracking') }}/${id}`)
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
                                const hari = tgl.getDate();
                                const bulan = bulanIndo[tgl.getMonth()];
                                const tahun = tgl.getFullYear();
                                return `${hari} ${bulan} ${tahun}`;
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
                                    <div class="d-flex align-items-start">
                                    <div class="bg-light text-muted small p-2 rounded w-100">
                                    <strong>Keterangan :</strong><br>
                                        ${data.keterangan ?? 'Tidak Ada'}
                                    </div>
                                    </div>
                                </div>
                                </div>

                                <div class="card shadow-sm border-0">
                                <div class="card-header bg-light text-uppercase text-center fw-bold" style="color:#024E7F;">
                                    Tabung Kosong Diambil Dari Outlet
                                </div>
                                <div class="card-body">
                                    <ul class="mb-2">${tabungListAmbil || '<li>-</li>'}</ul>
                                    <div class="d-flex align-items-start">
                                    <div class="bg-light text-muted small p-2 rounded w-100">
                                    <strong>Keterangan Pengambilan :</strong><br>
                                      ${data.keterangan_pengambilan ?? 'Tidak Ada'}
                                    </div>
                                    </div>
                                </div>
                            </div>
                            `;


                            if (isAdmin) {
                                html += `
                                        <div class="card shadow-sm border-0 mt-3">
                                            <div class="card-header bg-light fw-bold text-uppercase" style="color:#024E7F;">
                                                Ubah Status Pengiriman
                                            </div>
                                            <div class="card-body">
                                                <form id="statusForm">
                                                    <input type="hidden" name="_token" value="${csrfToken}">
                                                    <input type="hidden" name="_method" value="PUT">

                                                    <div class="mb-3">
                                                        <label class="fw-bold mb-2" style="color:#024E7F;">Status Pengiriman</label>
                                                        <select name="status" class="form-select shadow-sm">
                                                            <option value="dikirim" ${data.status == 'dikirim' ? 'selected' : ''}>Menunggu Persetujuan</option>
                                                            <option value="diterima" ${data.status == 'diterima' ? 'selected' : ''}>Accepted</option>
                                                            <option value="dibatalkan" ${data.status == 'dibatalkan' ? 'selected' : ''}>Rejected</option>
                                                        </select>
                                                    </div>

                                                    <button type="submit" class="btn btn-success w-100 fw-semibold shadow-sm">
                                                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        `;
                            } else {
                                html += `
                                        <div class="card shadow-sm border-0 mt-3">
                                            <div class="card-header bg-light fw-bold text-uppercase" style="color:#024E7F;">
                                                Status Pengiriman
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div style="min-width:130px; color:#024E7F;"><strong>Status:</strong></div>
                                                    <div class="fw-semibold text-capitalize text-muted">${data.status ?? '-'}</div>
                                                </div>
                                            </div>
                                        </div>
                                        `;
                            }


                            document.getElementById('detailContent').innerHTML = html;

                            // === SWEETALERT UNTUK ADMIN ===
                            if (isAdmin) {
                                document.getElementById('statusForm').addEventListener('submit',
                                    function(e) {
                                        e.preventDefault();
                                        let formData = new FormData(this);

                                        fetch(`{{ url('tracking') }}/${data.id}/status`, {
                                                method: 'POST',
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'Accept': 'application/json'
                                                },
                                                body: formData
                                            })
                                            .then(r => r.json().catch(() => ({})))
                                            .then(resp => {
                                                if (resp.success) {
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: 'Status pengiriman berhasil diperbarui.',
                                                        icon: 'success',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Lihat Data',
                                                        cancelButtonText: 'Oke',
                                                        confirmButtonColor: '#024E7F',
                                                        cancelButtonColor: '#6c757d',
                                                    }).then((result) => {
                                                        if (result
                                                            .isConfirmed) {
                                                            window.location
                                                                .href =
                                                                "{{ url('/history') }}"; // ubah sesuai route tujuanmu
                                                        } else {
                                                            $('#modalDetail')
                                                                .modal('hide');
                                                            location.reload();
                                                        }
                                                    });
                                                } else {
                                                    Swal.fire('Gagal!', resp.message ||
                                                        'Tidak dapat memperbarui status.',
                                                        'error');
                                                }
                                            })
                                            .catch(() => Swal.fire('Gagal!',
                                                'Terjadi kesalahan sistem.', 'error'));
                                    });
                            }

                            $('#modalDetail').modal('show');
                        })
                        .catch(() => Swal.fire('Error', 'Gagal memuat detail pengiriman.',
                            'error'));
                });
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = "{{ csrf_token() }}";

            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    fetch(`{{ url('tracking') }}/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let tabungList = data.detail_pengirimans.map(t =>
                                `<li>${t.kode_tabung}</li>`).join('');

                            let html = `
                        <div class="d-flex mb-1"><div style="min-width:130px; color: #024E7F;"><strong>Outlet:</strong></div><div>${data.outlet?.nama_outlet ?? '-'}</div></div>
                        <div class="d-flex mb-1"><div style="min-width:130px; color: #024E7F;"><strong>Tanggal:</strong></div><div>${data.tanggal_pengiriman}</div></div>
                        <div class="d-flex mb-1"><div style="min-width:130px; color: #024E7F;"><strong>Keterangan:</strong></div><div>${data.keterangan ?? '-'}</div></div>
                        <h6 style="color: #024E7F;">Tabung:</h6>
                        <ul>${tabungList}</ul>
                        <form id="statusForm">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label class="fw-bold" style="color: #024E7F;">Status</label>
                                <select name="status" class="form-select">
                                    <option value="dikirim" ${data.status == 'dikirim' ? 'selected' : ''}>Dikirim</option>
                                    <option value="diterima" ${data.status == 'diterima' ? 'selected' : ''}>Diterima</option>
                                    <option value="dibatalkan" ${data.status == 'dibatalkan' ? 'selected' : ''}>Dibatalkan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </form>
                    `;

                            document.getElementById('detailContent').innerHTML = html;

                            // Submit form via AJAX
                            document.getElementById('statusForm').addEventListener('submit',
                                function(e) {
                                    e.preventDefault();
                                    let formData = new FormData(this);

                                    fetch(`{{ url('tracking') }}/${data.id}/status`, {
                                            method: 'POST',
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json'
                                            },
                                            body: formData
                                        })
                                        .then(r => {
                                            if (r.headers.get("content-type")?.includes(
                                                    "application/json")) {
                                                return r.json();
                                            } else {
                                                return {
                                                    success: true
                                                };
                                            }
                                        })
                                        .then(resp => {
                                            if (resp.success) {
                                                alert('Status berhasil diperbarui');
                                                $('#modalDetail').modal('hide');
                                                location.reload();
                                            } else {
                                                alert(resp.message ||
                                                    'Gagal mengubah status');
                                            }
                                        })
                                        .catch(err => {
                                            console.error(err);
                                            alert('Gagal mengubah status');
                                        });
                                });

                            $('#modalDetail').modal('show'); // Bootstrap 4
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal memuat detail');
                        });
                });
            });
        });
    </script> --}}

@endsection
