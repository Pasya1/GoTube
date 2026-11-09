<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::with('outlet')
            ->whereNotIn('status', ['diterima', 'completed', 'batal', 'dibatalkan'])
            ->orderBy('tanggal_pengiriman', 'desc');

        if ($request->tanggal) {
            $query->whereDate('tanggal_pengiriman', $request->tanggal);
        }

        $pengirimans = $query->get();

        return view('tracking.index', [
            'pengirimans' => $pengirimans,
            'csrfToken'   => csrf_token(), // kirim CSRF token ke view
        ]);
    }

    public function show($id)
    {
        // 🔹 Tambahkan relasi 'pengambilanKosong'
        $pengiriman = Pengiriman::with(['outlet', 'details', 'pengambilanKosong'])->findOrFail($id);

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
                return [
                    'kode_tabung' => $t->kode_tabung
                ];
            }),

            // 🔸 tabung kosong (yang diambil)
            'detail_pengambilan_kosongs' => $pengiriman->pengambilanKosong->map(function ($t) {
                return [
                    'kode_tabung' => $t->kode_tabung
                ];
            }),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->status = $request->status;
        $pengiriman->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }
}
