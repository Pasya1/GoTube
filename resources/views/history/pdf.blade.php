<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>History Pengiriman</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>History Pengiriman</h2>

    @if (request('tanggal_awal') && request('tanggal_akhir'))
        <p style="text-align:center; margin-top:-5px; margin-bottom:15px;">
            Periode :
            <strong>
                {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
            </strong>
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Outlet</th>
                <th>Jenis Pengiriman</th>
                <th>Status</th>
                <th>Kode Tabung</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengirimans as $p)
                @php
                    $hasIsi = $p->details->isNotEmpty();
                    $hasKosong = $p->pengambilanKosong->isNotEmpty();

                    $jenisPengiriman = match (true) {
                        $hasIsi && $hasKosong => 'Tabung Isi & Kosong',
                        $hasIsi => 'Tabung Isi Dikirim',
                        $hasKosong => 'Tabung Kosong Diambil',
                        default => '-',
                    };

                    $status = match (strtolower($p->status)) {
                        'diterima' => 'Accepted',
                        'dibatalkan' => 'Rejected',
                        default => ucfirst($p->status),
                    };
                @endphp

                @foreach ($p->details as $d)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pengiriman)->translatedFormat('d F Y') }}</td>
                        <td>{{ $p->outlet->nama_outlet ?? '-' }}</td>
                        <td>{{ $jenisPengiriman }}</td>
                        <td>{{ $status }}</td>
                        <td>{{ $d->kode_tabung }}</td>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach

                @foreach ($p->pengambilanKosong as $d)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pengiriman)->translatedFormat('d F Y') }}</td>
                        <td>{{ $p->outlet->nama_outlet ?? '-' }}</td>
                        <td>{{ $jenisPengiriman }}</td>
                        <td>{{ $status }}</td>
                        <td>{{ $d->kode_tabung }}</td>
                        <td>{{ $p->keterangan_pengambilan ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
