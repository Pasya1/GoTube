<?php

namespace App\Http\Controllers;

use App\Models\DetailPengambilanKosong;
use App\Models\DetailPengiriman;
use App\Models\Pengiriman;
use App\Models\Tabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'outlet' => 'required|exists:outlet,id',
            'tanggal_pengiriman' => 'required|date',

            'tabung' => 'nullable|array',
            'tabung.*' => 'nullable|exists:tabung,kode_tabung',

            // 🔥 FIX DI SINI
            'tabung2' => 'nullable|array',
            'tabung2.*' => 'nullable|exists:tabung,kode_tabung',
        ]);

        $tabungIsi = collect($request->tabung ?? [])->filter()->values();
        $tabungKosong = collect($request->tabung2 ?? [])->filter()->values();

        if ($tabungIsi->isEmpty() && $tabungKosong->isEmpty()) {
            return back()->with('error', 'Minimal 1 tabung harus diinput!');
        }

        DB::transaction(function () use ($request, $tabungIsi, $tabungKosong) {

            $pengiriman = Pengiriman::create([
                'outlet_id' => $request->outlet,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'keterangan' => $request->keterangan,
                'keterangan_pengambilan' => $request->keterangan_pengambilan,
                'status' => 'dikirim',
            ]);

            // TABUNG ISI (SCAN)
            foreach ($tabungIsi as $kode) {

                $tabung = Tabung::where('kode_tabung', $kode)->first();

                if (!$tabung) {
                    throw new \Exception("Tabung tidak ditemukan: " . $kode);
                }

                DetailPengiriman::create([
                    'pengiriman_id' => $pengiriman->id,
                    'kode_tabung' => $kode,
                ]);

                $tabung->update(['status' => 'kosong']);
            }

            // TABUNG KOSONG
            foreach ($tabungKosong as $kode) {

                $tabung = Tabung::where('kode_tabung', $kode)->first();

                if (!$tabung) {
                    throw new \Exception("Tabung kosong tidak ditemukan: " . $kode);
                }

                DetailPengambilanKosong::create([
                    'pengiriman_id' => $pengiriman->id,
                    'kode_tabung' => $kode,
                ]);

                $tabung->update(['status' => 'isi']);
            }
        });

        return back()->with('success', 'Berhasil disimpan!');
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikirim,diterima,dibatalkan'
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->status = $request->status;
        $pengiriman->save();

        return back()->with('success', 'Status pengiriman diperbarui.');
    }
}
