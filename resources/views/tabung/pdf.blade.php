<!DOCTYPE html>
<html>

<head>
    <title>QR Tabung</title>
    <style>
        body {
            font-family: sans-serif;
            margin-left: -30px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            text-align: center;
        }

        td {
            width: 50%;
            padding: 20px 0;
        }

        img {
            width: 10cm;
            height: 10cm;
            display: block;
            margin: 0 auto;
            /* 🔥 FIX TENGAH */
        }

        .text {
            margin-top: 5px;
            font-size: 13px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <h3>QR CODE TABUNG</h3>

    @foreach ($tabungs->chunk(4) as $chunk)
        <table>
            <tr>
                @foreach ($chunk->take(2) as $t)
                    <td>
                        <img src="{{ public_path('qrcode/' . $t->kode_tabung . '.png') }}">
                        <div class="text">
                            <strong>{{ $t->kode_tabung }}</strong><br>
                            {{ $t->nomor_seri }}
                        </div>
                    </td>
                @endforeach
            </tr>

            <tr>
                @foreach ($chunk->slice(2, 2) as $t)
                    <td>
                        <img src="{{ public_path('qrcode/' . $t->kode_tabung . '.png') }}">
                        <div class="text">
                            <strong>{{ $t->kode_tabung }}</strong><br>
                            {{ $t->nomor_seri }}
                        </div>
                    </td>
                @endforeach
            </tr>
        </table>

        <div class="page-break"></div>
    @endforeach

</body>

</html>
