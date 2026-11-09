<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Endroid\QrCode\Builder\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TabungController extends Controller
{
    public function index()
    {
        $tabungs = Tabung::latest()->get();
        return view('tabung.index', compact('tabungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tabung' => 'required|unique:tabung,kode_tabung|max:50',
            'seri_tabung' => 'required|unique:tabung,nomor_seri|max:50',
            'catatan' => 'nullable|string|max:1000'
        ]);

        $tabung = Tabung::create([
            'kode_tabung' => $request->kode_tabung,
            'nomor_seri' => $request->seri_tabung,
            'catatan' => $request->catatan,
            'status' => 'isi'
        ]);

        $path = public_path('qrcode/');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // 🔥 GENERATE QR TANPA ERROR
        $result = Builder::create()
            ->data($tabung->kode_tabung)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($path . $tabung->kode_tabung . '.png');

        return redirect()->route('tabung.index')->with('success', 'Tabung + QR berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $tabung = Tabung::findOrFail($id);

        $request->validate([
            'kode_tabung' => 'required|max:50|unique:tabung,kode_tabung,' . $tabung->id,
            'seri_tabung' => 'required|max:50|unique:tabung,nomor_seri,' . $tabung->id,
            'catatan' => 'nullable|string|max:1000,' . $tabung->id,
        ]);

        // ❗ JANGAN GENERATE QR LAGI
        $tabung->update([
            'kode_tabung' => $request->kode_tabung,
            'nomor_seri' => $request->seri_tabung,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('tabung.index')->with('success', 'Tabung berhasil diperbarui (QR tetap sama)');
    }

    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:1000'
        ]);

        $tabung = Tabung::findOrFail($id);

        $tabung->update([
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Catatan berhasil diperbarui.');
    }

    public function editCatatan(Request $request, $id)
    {
        if (Auth::user()->role != 'kurir') {
            abort(403);
        }

        $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $tabung = Tabung::findOrFail($id);

        $tabung->update([
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tabung = Tabung::findOrFail($id);

        // HAPUS FILE QR
        $path = public_path('qrcode/' . $tabung->kode_tabung . '.png');
        if (File::exists($path)) {
            File::delete($path);
        }

        $tabung->delete();

        return redirect()->route('tabung.index')->with('success', 'Tabung berhasil dihapus');
    }

    public function generateQRMassal()
    {
        $tabungs = Tabung::all();

        $path = public_path('qrcode/');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        foreach ($tabungs as $tabung) {

            $file = $path . $tabung->kode_tabung . '.png';

            if (!File::exists($file)) {

                $result = Builder::create()
                    ->data($tabung->kode_tabung)
                    ->size(300)
                    ->margin(10)
                    ->build();

                $result->saveToFile($file);
            }
        }

        return "QR berhasil digenerate untuk semua tabung!";
    }

    public function downloadQR($kode)
    {
        $path = public_path('qrcode/' . $kode . '.png');

        if (!file_exists($path)) {
            return back()->with('error', 'QR tidak ditemukan');
        }

        return response()->download($path);
    }

    public function downloadPDF()
    {
        $tabungs = Tabung::all();

        $pdf = Pdf::loadView('tabung.pdf', compact('tabungs'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('QR-Tabung.pdf');
    }
}
