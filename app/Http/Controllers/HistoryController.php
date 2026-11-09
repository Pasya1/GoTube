<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengirimanExport;
use App\Models\Tabung;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::with('outlet')
            ->whereNotIn('status', ['dikirim'])
            ->orderBy('tanggal_pengiriman', 'desc');

        // Filter tanggal range
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengiriman', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $pengirimans = $query->get();

        return view('history.index', [
            'pengirimans' => $pengirimans,
            'csrfToken'   => csrf_token(), // kirim CSRF token ke view
        ]);
    }

    public function show($id)
    {

        // 🔹 Tambahkan relasi 'pengambilanKosong'
        $pengiriman = Pengiriman::with([
            'outlet',
            'details',
            'pengambilanKosong'
        ])->findOrFail($id);

        return response()->json([
            'id' => $pengiriman->id,
            'tanggal_pengiriman' => $pengiriman->tanggal_pengiriman->format('Y-m-d'),
            'status' => $pengiriman->status,
            'keterangan' => $pengiriman->keterangan,
            'keterangan_pengambilan' => $pengiriman->keterangan_pengambilan,
            'outlet' => [
                'nama_outlet' => $pengiriman->outlet->nama_outlet ?? '-'
            ],


            // 🔸 tabung isi (yang dikirim)
            'detail_pengirimans' => $pengiriman->details->map(function ($t) {
                $tabung = Tabung::where('kode_tabung', $t->kode_tabung)->first();

                return [
                    'id' => $tabung?->id,
                    'kode_tabung' => $t->kode_tabung
                ];
            }),

            // 🔸 tabung kosong (yang diambil)
            'detail_pengambilan_kosongs' => $pengiriman->pengambilanKosong->map(function ($t) {
                return [
                    'id' => $t->tabung_id,
                    'kode_tabung' => $t->kode_tabung
                ];
            }),
        ]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PengirimanExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'history_pengiriman.xlsx'
        );
    }

    public function exportPDF(Request $request)
    {
        $query = Pengiriman::with(['outlet', 'details'])
            ->whereIn('status', ['diterima', 'dibatalkan'])
            ->orderBy('tanggal_pengiriman', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengiriman', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $pengirimans = $query->get();

        $pdf = PDF::loadView('history.pdf', compact('pengirimans'));
        return $pdf->download('history_pengiriman.pdf');
    }
}
