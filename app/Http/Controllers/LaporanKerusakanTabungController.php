<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakanTabung;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanTabungController extends Controller
{
    /**
     * Menampilkan seluruh laporan kerusakan (Admin)
     */
    public function index()
    {
        $laporan = LaporanKerusakanTabung::with([
            'pengiriman.outlet',
            'tabung',
            'user'
        ])
            ->latest()
            ->get();

        return view('laporan_kerusakan.index', compact('laporan'));
    }

    /**
     * Menyimpan laporan kerusakan (SPV)
     */
    public function store(Request $request)
    {
        // Hanya SPV yang boleh input
        if (Auth::user()->role != 'spv') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([

            'pengiriman_id' => 'required',

            'tabung_id' => 'required|array',

            'tabung_id.*' => 'exists:tabung,id',

            'catatan' => 'required'

        ]);

        // Cek apakah tabung tersebut sudah pernah dilaporkan
        $cek = LaporanKerusakanTabung::where('pengiriman_id', $request->pengiriman_id)
            ->where('tabung_id', $request->tabung_id)
            ->whereIn('status', ['menunggu', 'diproses'])
            ->first();


        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Tabung ini sudah pernah dilaporkan.'
            ], 422);
        }

        foreach ($request->tabung_id as $tabung) {

            $cek = LaporanKerusakanTabung::where('pengiriman_id', $request->pengiriman_id)

                ->where('tabung_id', $tabung)

                ->whereIn('status', ['menunggu', 'diproses'])

                ->exists();

            if (!$cek) {

                LaporanKerusakanTabung::create([

                    'pengiriman_id' => $request->pengiriman_id,

                    'tabung_id' => $tabung,

                    'catatan' => $request->catatan,

                    'status' => 'menunggu',

                    'user_id' => Auth::id()

                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Laporan kerusakan berhasil dikirim.'
        ]);
    }

    /**
     * Admin melihat detail laporan
     */
    public function show($id)
    {
        $laporan = LaporanKerusakanTabung::with([
            'pengiriman.outlet',
            'tabung',
            'user'
        ])->findOrFail($id);

        return response()->json($laporan);
    }

    /**
     * Admin mengubah status
     */
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak'
        ]);

        $laporan = LaporanKerusakanTabung::findOrFail($id);

        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Hapus laporan (Opsional)
     */
    public function destroy($id)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $laporan = LaporanKerusakanTabung::findOrFail($id);

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
