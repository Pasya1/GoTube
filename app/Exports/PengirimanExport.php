<?php

namespace App\Exports;

use App\Models\Pengiriman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengirimanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        $query = Pengiriman::with(['outlet', 'details', 'pengambilanKosong'])
            ->whereIn('status', ['diterima', 'dibatalkan'])
            ->orderBy('tanggal_pengiriman', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_pengiriman', [$this->startDate, $this->endDate]);
        }

        return $query->get()->flatMap(function ($p) {
            // Tentukan jenis pengiriman berdasarkan relasi
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

            // Gabungkan details dan pengambilan kosong
            $rows = collect();

            foreach ($p->details as $d) {
                $rows->push([
                    'Tanggal Pengiriman' => \Carbon\Carbon::parse($p->tanggal_pengiriman)
                        ->translatedFormat('d F Y'),
                    'Outlet'             => $p->outlet->nama_outlet ?? '-',
                    'Jenis Pengiriman'   => $jenisPengiriman,
                    'Status'             => $status,
                    'Kode Tabung'        => $d->kode_tabung,
                    'Keterangan'         => $p->keterangan ?? '-',
                ]);
            }

            foreach ($p->pengambilanKosong as $d) {
                $rows->push([
                    'Tanggal Pengiriman' => \Carbon\Carbon::parse($p->tanggal_pengiriman)
                        ->translatedFormat('d F Y'),
                    'Outlet'             => $p->outlet->nama_outlet ?? '-',
                    'Jenis Pengiriman'   => $jenisPengiriman,
                    'Status'             => $status,
                    'Kode Tabung'        => $d->kode_tabung,
                    'Keterangan'         => $p->keterangan_pengambilan ?? '-',
                ]);
            }

            return $rows;
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal Pengiriman',
            'Outlet',
            'Jenis Pengiriman',
            'Status',
            'Kode Tabung',
            'Keterangan',
        ];
    }
}
