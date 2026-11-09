@extends('layouts.master')

@section('title', 'Data Tabung | Go Tube')

@section('content')
    <style>
        #tabungTable tbody tr {
            transition: 0.2s;
        }

        #tabungTable tbody tr:hover {
            background-color: #f8fbff;
            transform: scale(1.01);
        }

        .badge {
            font-size: 13px;
            border-radius: 8px;
        }

        .card {
            border: none;
        }
    </style>
    <div class="content" style="min-height: 100vh;">
        <div class="container">
            <h3 class="title-page text-center text-uppercase fw-bold mb-4" style="color:#024E7F;">Data Tabung</h3>

            {{-- Tombol tambah & search --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                @if (Auth::user()->role !== 'kurir')
                    @if (Auth::user()->role !== 'spv')
                        <button class="btn rounded" style="background-color:#3BA484; color:white;" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Tabung
                        </button>
                    @endif
                    <a href="{{ route('tabung.downloadPDF') }}" class="btn btn-danger">
                        <i class="fa-solid fa-file-pdf"></i> Download PDF QR
                    </a>

                @endif

                <input type="text" id="searchInput" class="form-control w-70 w-md-auto" placeholder="Cari tabung...">
            </div>

            <div class="mb-3">
                <span class="badge bg-success px-3 py-2">
                    Total Tabung: {{ $tabungs->count() }}
                </span>
            </div>

            {{-- List tabung --}}
            <div class="card shadow-sm rounded-4 table-responsive">
                <div class="card-body p-0">
                    <table id="tabungTable" class="table align-middle table-hover mb-0">
                        <thead class="text-center" style="background-color:#024E7F; color:white;">
                            <tr>
                                <th style="width:50px;">#</th>
                                <th class="text-start">Kode Tabung</th>
                                <th class="text-start">Seri Tabung</th>
                                <th class="text-start">Catatan</th>
                                @if (Auth::user()->role !== 'kurir')
                                    <th>QR Code</th>
                                    @if (Auth::user()->role !== 'spv')
                                        <th style="width:120px;">Aksi</th>
                                    @endif
                                @elseif (Auth::user()->role == 'kurir')
                                    <th style="width:120px;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabungs as $t)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="badge bg-primary px-3 py-2">
                                            {{ $t->kode_tabung }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-muted">
                                            {{ $t->nomor_seri }}
                                        </span>
                                    </td>


                                    <td>
                                        <span>
                                            {{ $t->catatan ?? '-' }}
                                        </span>
                                    </td>

                                    @if (Auth::user()->role !== 'kurir')
                                        <td class="text-center">
                                            <img src="{{ asset('qrcode/' . $t->kode_tabung . '.png') }}" width="70"
                                                class="mb-2 border rounded p-1 bg-white">

                                            <br>

                                            <a href="{{ route('tabung.downloadQR', $t->kode_tabung) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </td>
                                    @endif
                                    @if (Auth::user()->role !== 'kurir')
                                        @if (Auth::user()->role !== 'spv')
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">

                                                    <button class="btn btn-warning btn-sm text-white btn-edit rounded"
                                                        data-id="{{ $t->id }}" data-kode="{{ $t->kode_tabung }}"
                                                        data-seri="{{ $t->nomor_seri }}"
                                                        data-catatan="{{ $t->catatan }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>

                                                    <form action="{{ route('tabung.destroy', $t->id) }}" method="POST"
                                                        class="form-delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm rounded">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    @elseif (Auth::user()->role == 'kurir')
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-info btn-sm text-white btn-catatan"
                                                    data-id="{{ $t->id }}" data-kode="{{ $t->kode_tabung }}"
                                                    data-catatan="{{ $t->catatan }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalCatatan">

                                                    <i class="fa-solid fa-note-sticky"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#024E7F; color:white;">
                    <h5 class="modal-title">Tambah Tabung</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('tabung.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label>Kode Tabung</label>
                        <input type="text" name="kode_tabung" class="form-control mb-2" required>
                        <label>Seri Tabung</label>
                        <input type="text" name="seri_tabung" class="form-control" required>
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn" style="background-color:#3BA484; color:white;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#024E7F; color:white;">
                    <h5 class="modal-title">Edit Tabung</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label>Kode Tabung</label>
                        <input type="text" name="kode_tabung" id="editKode" class="form-control" readonly>
                        <label>Seri Tabung</label>
                        <input type="text" name="seri_tabung" id="editSeri" class="form-control" required>
                        <label>Catatan</label>
                        <textarea name="catatan" id="editCatatan" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn" style="background-color:#3BA484; color:white;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCatatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" style="background:#024E7F;color:white">
                    <h5>Catatan Tabung</h5>
                    <button class="btn-close bg-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="formCatatan" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label>Kode Tabung</label>
                        <input type="text" id="catatanKode" class="form-control mb-3" readonly>

                        <label>Catatan</label>

                        <textarea name="catatan" id="catatanText" class="form-control" rows="5"></textarea>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button class="btn btn-success">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCatatan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="background:#024E7F;color:white;">
                    <h5 class="modal-title">
                        Edit Catatan Tabung
                    </h5>

                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <form id="formCatatan" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label>Kode Tabung</label>

                        <input type="text" id="catatanKode" class="form-control mb-3" readonly>

                        <label>Catatan</label>

                        <textarea name="catatan" id="catatanText" class="form-control" rows="5" placeholder="Masukkan catatan..."></textarea>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button class="btn" style="background:#3BA484;color:white;">
                            Simpan Catatan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Search filter
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tabungTable tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Isi modal edit
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let kode = this.getAttribute('data-kode');
                let seri = this.getAttribute('data-seri');
                let catatan = this.getAttribute('data-catatan');
                document.getElementById('editKode').value = kode;
                document.getElementById('editSeri').value = seri;
                document.getElementById('editCatatan').value = catatan;
                document.getElementById('formEdit').action = `/tabung/${id}`;
            });
        });

        // SweetAlert untuk hapus
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin?',
                    text: "Data tabung akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3BA484',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.btn-catatan').forEach(btn => {

            btn.addEventListener('click', function() {

                let id = this.dataset.id;
                let kode = this.dataset.kode;
                let catatan = this.dataset.catatan;

                document.getElementById('catatanKode').value = kode;
                document.getElementById('catatanText').value = catatan;

                document.getElementById('formCatatan').action =
                    `/tabung/${id}/catatan`;

            });

        });

        document.querySelectorAll('.btn-catatan').forEach(btn => {

            btn.addEventListener('click', function() {

                document.getElementById('catatanKode').value = this.dataset.kode;
                document.getElementById('catatanText').value = this.dataset.catatan;

                document.getElementById('formCatatan').action =
                    '/tabung/' + this.dataset.id + '/catatan';

            });

        });

        // SweetAlert untuk notifikasi dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
            });
        @endif
    </script>
@endsection
