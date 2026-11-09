<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Pengiriman;
use App\Models\DetailPengambilanKosong;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CatatanKhususTabung;

class MonitoringTabungController extends Controller
{
    public function index(Request $request)
    {
        $tanggalSekarang = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | OUTLET
        |--------------------------------------------------------------------------
        */
        $outlets = Outlet::orderBy('nama_outlet', 'asc')->get();


        /*
        |--------------------------------------------------------------------------
        | PENGIRIMAN YANG SUDAH DITERIMA
        |--------------------------------------------------------------------------
        */
        $pengirimans = Pengiriman::with([
            'outlet',
            'details',
            'pengambilanKosong'
        ])
            ->where('status', 'diterima')
            ->orderBy('tanggal_pengiriman', 'desc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PENGAMBILAN TABUNG KOSONG
        |--------------------------------------------------------------------------
        */
        $pengambilanKosongs = DetailPengambilanKosong::with([
            'pengiriman'
        ])
            ->whereHas('pengiriman', function ($query) {
                $query->where('status', 'diterima');
            })
            ->get();


        /*
        |--------------------------------------------------------------------------
        | EVENT TERAKHIR SETIAP TABUNG
        |--------------------------------------------------------------------------
        */
        $eventTabung = [];


        /*
        |--------------------------------------------------------------------------
        | EVENT TABUNG MASUK KE OUTLET
        |--------------------------------------------------------------------------
        */
        foreach ($pengirimans as $pengiriman) {

            if (!$pengiriman->outlet) {
                continue;
            }

            foreach ($pengiriman->details as $detail) {

                $kodeTabung = trim($detail->kode_tabung);

                if (!$kodeTabung) {
                    continue;
                }

                $tanggal = Carbon::parse(
                    $pengiriman->tanggal_pengiriman
                );

                /*
                | Jangan hitung tanggal masa depan
                */
                if ($tanggal->greaterThan($tanggalSekarang)) {
                    continue;
                }

                /*
                | Simpan hanya event terbaru
                */
                if (
                    !isset($eventTabung[$kodeTabung]) ||
                    $tanggal->greaterThan(
                        $eventTabung[$kodeTabung]['tanggal']
                    )
                ) {
                    $eventTabung[$kodeTabung] = [
                        'kode_tabung' => $kodeTabung,
                        'jenis' => 'masuk',
                        'tanggal' => $tanggal,
                        'pengiriman_id' => $pengiriman->id,
                        'outlet_id' => $pengiriman->outlet_id,
                        'outlet' => $pengiriman->outlet,
                    ];
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | EVENT TABUNG KELUAR DARI OUTLET
        |--------------------------------------------------------------------------
        */
        foreach ($pengambilanKosongs as $pengambilan) {

            $pengiriman = $pengambilan->pengiriman;

            if (!$pengiriman || !$pengiriman->outlet) {
                continue;
            }

            $kodeTabung = trim($pengambilan->kode_tabung);

            if (!$kodeTabung) {
                continue;
            }

            $tanggal = Carbon::parse(
                $pengiriman->tanggal_pengiriman
            );

            /*
            | Jangan hitung tanggal masa depan
            */
            if ($tanggal->greaterThan($tanggalSekarang)) {
                continue;
            }

            /*
            | Jika event keluar lebih baru,
            | maka tabung dianggap sudah keluar.
            */
            if (
                !isset($eventTabung[$kodeTabung]) ||
                $tanggal->greaterThan(
                    $eventTabung[$kodeTabung]['tanggal']
                )
            ) {
                $eventTabung[$kodeTabung] = [
                    'kode_tabung' => $kodeTabung,
                    'jenis' => 'keluar',
                    'tanggal' => $tanggal,
                    'pengiriman_id' => $pengiriman->id,
                    'outlet_id' => $pengiriman->outlet_id,
                    'outlet' => $pengiriman->outlet,
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HANYA TABUNG YANG EVENT TERAKHIR = MASUK
        |--------------------------------------------------------------------------
        |
        | Artinya tabung masih berada di outlet.
        |
        */
        $tabungDiOutlet = collect($eventTabung)
            ->filter(function ($item) {
                return $item['jenis'] === 'masuk';
            })
            ->map(function ($item) use ($tanggalSekarang) {

                $umurHari = $item['tanggal']->diffInDays(
                    $tanggalSekarang
                );

                /*
                |--------------------------------------------------------------------------
                | STATUS ALERT
                |--------------------------------------------------------------------------
                */

                if ($umurHari >= 30) {

                    $statusAlert = 'alert';
                    $labelAlert = 'Alert';
                } elseif ($umurHari >= 20) {

                    $statusAlert = 'peringatan';
                    $labelAlert = 'Perhatian';
                } else {

                    $statusAlert = 'normal';
                    $labelAlert = 'Normal';
                }

                $item['umur_hari'] = $umurHari;
                $item['status_alert'] = $statusAlert;
                $item['label_alert'] = $labelAlert;

                return $item;
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | FILTER OUTLET
        |--------------------------------------------------------------------------
        */
        if ($request->filled('outlet_id')) {

            $tabungDiOutlet = $tabungDiOutlet
                ->where(
                    'outlet_id',
                    $request->outlet_id
                )
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | CARI TABUNG
        |--------------------------------------------------------------------------
        |
        | Pencarian berdasarkan kode tabung.
        |
        */
        if ($request->filled('cari_tabung')) {

            $keyword = strtolower(
                trim($request->cari_tabung)
            );

            $tabungDiOutlet = $tabungDiOutlet
                ->filter(function ($item) use ($keyword) {

                    return str_contains(
                        strtolower($item['kode_tabung']),
                        $keyword
                    );
                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        |
        | Tabung paling lama berada di outlet
        | ditampilkan paling atas.
        |
        */
        $tabungDiOutlet = $tabungDiOutlet
            ->sortByDesc('umur_hari')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $totalTabung = $tabungDiOutlet->count();

        $totalAlert = $tabungDiOutlet
            ->where('status_alert', 'alert')
            ->count();

        $totalPeringatan = $tabungDiOutlet
            ->where('status_alert', 'peringatan')
            ->count();

        $totalNormal = $tabungDiOutlet
            ->where('status_alert', 'normal')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK PER OUTLET
        |--------------------------------------------------------------------------
        */
        $statistikOutlet = $tabungDiOutlet
            ->groupBy('outlet_id')
            ->map(function ($items) {

                $outlet = $items->first()['outlet'];

                return [
                    'outlet_id' => $outlet->id,

                    'nama_outlet' =>
                    $outlet->nama_outlet,

                    'total' =>
                    $items->count(),

                    'alert' =>
                    $items
                        ->where(
                            'status_alert',
                            'alert'
                        )
                        ->count(),

                    'peringatan' =>
                    $items
                        ->where(
                            'status_alert',
                            'peringatan'
                        )
                        ->count(),

                    'normal' =>
                    $items
                        ->where(
                            'status_alert',
                            'normal'
                        )
                        ->count(),
                ];
            })
            ->sortByDesc('alert')
            ->values();


        /*
|--------------------------------------------------------------------------
| CATATAN KHUSUS TABUNG
|--------------------------------------------------------------------------
*/

        $catatanKhusus = CatatanKhususTabung::with([
            'user',
            'outlet'
        ])
            ->whereIn(
                'kode_tabung',
                $tabungDiOutlet->pluck('kode_tabung')
            )
            ->get()
            ->groupBy(function ($item) {
                return $item->kode_tabung . '|' . $item->outlet_id;
            });


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'monitoring-tabung.index',
            compact(
                'outlets',
                'tabungDiOutlet',
                'totalTabung',
                'totalAlert',
                'totalPeringatan',
                'totalNormal',
                'statistikOutlet',
                'tanggalSekarang',
                'catatanKhusus'
            )
        );
    }
}
