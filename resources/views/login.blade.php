<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" type="image/png" href="{{ asset('penjamu/images/logo.png') }}">
    <title>Go Tube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            color: #000;
            background-color: #f8f9fa;
            min-height: 100vh;
            margin: 0;
            b display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .card1 {
            width: 100%;
            max-width: 400px;
            padding: 30px 25px;
            background-image: linear-gradient(to right, #024e7f, #3ba484);
            color: white;
            border-radius: 10px;
        }

        .logo-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #fff;
            border: 4px solid #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo-circle img {
            width: 80%;
            height: auto;
            object-fit: contain;
        }

        .btn-color {
            border-radius: 50px;
            color: #024e7f;
            background-color: #fff;
            padding: 12px;
            border: none;
            margin-top: 15px;
            font-weight: bold;
        }

        .btn-color:hover {
            opacity: 0.85;
        }

        @media (max-width: 576px) {
            .card1 {
                padding: 20px 15px;
            }

            .logo-circle {
                width: 100px;
                height: 100px;
            }

            h5 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    <div class="card card1 shadow-lg text-center">
        <div class="mb-4">
            <div class="logo-circle mx-auto">
                <img src="{{ asset('penjamu/images/logo.png') }}" alt="Logo">
            </div>
        </div>

        <h5>Selamat Datang,</h5>
        <small>Silahkan Login Kembali</small>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" class="mt-3">
            @csrf
            <div class="form-group text-left">
                <label>Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group text-left">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-color btn-block">Login</button>
        </form>

        <div class="mt-3">
            <a href="#" data-toggle="modal" data-target="#helpModal" class="text-light"><small>Butuh
                    Bantuan?</small></a>
        </div>
    </div>

    <!-- Modal Butuh Bantuan -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Need Help?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Jika membutuhkan bantuan atau memiliki kendala, silakan hubungi admin melalui WhatsApp
                    <b>+62-878-4706-6081</b>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <a href="https://api.whatsapp.com/send?phone=6287847066081&text=Halo%20Admin,%20saya%20membutuhkan%20bantuan."
                        target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
