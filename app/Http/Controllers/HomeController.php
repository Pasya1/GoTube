<?php

namespace App\Http\Controllers;

use App\Models\DetailPengambilanKosong;
use App\Models\DetailPengiriman;
use App\Models\Outlet;
use App\Models\Pengiriman;
use App\Models\Tabung;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        // Ambil hanya tabung isi untuk dikirim
        $tabungsIsi = Tabung::where('status', 'isi')->get();

        // Ambil hanya tabung kosong untuk diambil
        $tabungsKosong = Tabung::where('status', 'kosong')->get();

        $pengiriman = Pengiriman::all();
        $detailPengiriman = DetailPengiriman::all();
        $pengambilanKosong = DetailPengambilanKosong::all();

        $today = Carbon::today();

        // Ambil aktivitas terakhir hari ini
        $aktivitasHariIni = Pengiriman::with(['outlet', 'tabungs', 'pengambilanKosong'])
            ->whereDate('tanggal_pengiriman', $today)
            ->latest()
            ->take(3)
            ->get();

        // Hitung total pengiriman
        $totalPengirimanHariIni = Pengiriman::whereDate('tanggal_pengiriman', $today)->count();

        // Hitung jumlah tabung dikirim hari ini
        $jumlahTabungHariIni = Pengiriman::whereDate('tanggal_pengiriman', $today)
            ->withCount('tabungs')
            ->get()
            ->sum('tabungs_count');

        // Hitung jumlah outlet unik hari ini
        $jumlahOutletHariIni = Pengiriman::whereDate('tanggal_pengiriman', $today)
            ->distinct('outlet_id')
            ->count('outlet_id');

        // ✅ Hitung tabung kosong diambil hari ini
        $jumlahTabungKosongHariIni = Pengiriman::whereDate('tanggal_pengiriman', $today)
            ->withCount('pengambilanKosong')
            ->get()
            ->sum('pengambilan_kosong_count');

        return view('welcome', compact(
            'outlets',
            'tabungsIsi',
            'tabungsKosong',
            'pengiriman',
            'detailPengiriman',
            'aktivitasHariIni',
            'totalPengirimanHariIni',
            'jumlahTabungHariIni',
            'jumlahOutletHariIni',
            'jumlahTabungKosongHariIni'
        ));
    }
}
