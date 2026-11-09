@extends('layouts.master')

@section('title', 'Kelola User')

@section('content')

    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --main: #024E7F;
        }

        .content-wrapper {
            margin-top: 100px;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .btn {
            border-radius: 10px;
            font-size: 13px;
        }

        .btn-primary {
            background: var(--main);
            border: none;
        }

        .btn-primary:hover {
            background: #013a5f;
        }

        .badge {
            border-radius: 8px;
            padding: 6px 10px;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .action-btn i {
            margin-right: 4px;
        }
    </style>

    <div class="container content-wrapper">

        <div class="d-flex justify-content-between mb-3">
            <h3 style="color: #013a5f;">Kelola User</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                + Tambah User
            </button>
        </div>

        <!-- SEARCH MOBILE -->
        <input type="text" id="searchMobile" class="form-control mb-3 d-md-none" placeholder="Cari user...">

        <!-- DESKTOP TABLE -->
        <div class="table-responsive d-none d-md-block">
            <table id="userTableDesktop" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span
                                    class="badge
                                @if ($user->role == 'admin') bg-danger
                                @elseif($user->role == 'spv') bg-warning
                                @else bg-primary @endif">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm mb-2"
                                    onclick='editUser(@json($user))'><i class="fas fa-edit"></i></button>

                                <button class="btn btn-info btn-sm mb-2" onclick="setPassword({{ $user->id }})"> <i
                                        class="fas fa-key"></i></button>

                                <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm mb-2" onclick="confirmDelete(this.form)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARD -->
        <div class="d-md-none">
            @foreach ($users as $user)
                <div class="card mb-2 user-card">
                    <div class="card-body">
                        <h5>{{ $user->name }}</h5>
                        <p>{{ $user->email }}</p>

                        <span
                            class="badge
                        @if ($user->role == 'admin') bg-danger
                        @elseif($user->role == 'spv') bg-warning
                        @else bg-primary @endif">
                            {{ strtoupper($user->role) }}
                        </span>

                        <div class="mt-2 d-flex gap-1 flex-wrap">
                            <button class="btn btn-warning btn-sm" onclick='editUser(@json($user))'> <i
                                    class="fas fa-edit"></i></button>

                            <button class="btn btn-info btn-sm" onclick="setPassword({{ $user->id }})"> <i
                                    class="fas fa-key"></i></button>

                            <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(this.form)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-content p-3">
                    <h5>Tambah User</h5>

                    <input name="name" class="form-control mb-2" placeholder="Nama" required>
                    <input name="email" class="form-control mb-2" placeholder="Email" required>
                    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>

                    <select name="role" class="form-control mb-2">
                        <option value="admin">Admin</option>
                        <option value="spv">SPV</option>
                        <option value="kurir">Kurir</option>
                    </select>

                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="modal-content p-3">
                    <h5>Edit User</h5>

                    <input id="editName" name="name" class="form-control mb-2">
                    <input id="editEmail" name="email" class="form-control mb-2">

                    <select id="editRole" name="role" class="form-control mb-2">
                        <option value="admin">Admin</option>
                        <option value="spv">SPV</option>
                        <option value="kurir">Kurir</option>
                    </select>

                    <button class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PASSWORD -->
    <div class="modal fade" id="passwordModal">
        <div class="modal-dialog">
            <form method="POST" id="passwordForm">
                @csrf
                <div class="modal-content p-3">
                    <h5>Ganti Password</h5>

                    <input name="password" type="password" class="form-control mb-2" placeholder="Password baru" required>

                    <button class="btn btn-info">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#userTableDesktop').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                searching: true,
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                }
            });
        });

        // SEARCH MOBILE
        document.getElementById("searchMobile")?.addEventListener("keyup", function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll(".user-card").forEach(el => {
                el.style.display = el.innerText.toLowerCase().includes(value) ? "" : "none";
            });
        });

        // EDIT
        function editUser(user) {
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editRole').value = user.role;

            document.getElementById('editForm').action = '/users/update/' + user.id;

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        // PASSWORD
        function setPassword(id) {
            document.getElementById('passwordForm').action = '/users/password/' + id;
            new bootstrap.Modal(document.getElementById('passwordModal')).show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(form) {
            event.preventDefault();

            Swal.fire({
                title: 'Yakin?',
                text: "User akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#024E7F',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`
            })
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#024E7F',
                timer: 2000,
                showConfirmButton: false
            })
        @endif
    </script>

@endsection
