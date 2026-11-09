<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Outlet;
use App\Models\Sale;
use App\Models\Tabung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    /**
     * =========================================================
     * CHECK ROLE
     * =========================================================
     */
    private function checkRole()
    {
        abort_unless(
            in_array(Auth::user()->role, ['admin', 'spv']),
            403
        );
    }

    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $this->checkRole();

        $allowedSort = [
            'id',
            'bulan',
            'date_in',
            'item',
            'tekanan',
            'no_tabung',
            'seri_tabung',
            'date_end',
            'sales_tabung',
            'keterangan',
            'outlet_id',
        ];

        $sort = in_array(
            $request->sort,
            $allowedSort
        )
            ? $request->sort
            : 'date_in';

        $direction = $request->direction === 'asc'
            ? 'asc'
            : 'desc';

        $salesQuery = Sale::with([
            'outlet',
            'user'
        ])

            /**
             * SEARCH
             */
            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('no_tabung', 'like', "%{$search}%")

                        ->orWhere('seri_tabung', 'like', "%{$search}%")

                        ->orWhere('item', 'like', "%{$search}%")

                        ->orWhere('keterangan', 'like', "%{$search}%")

                        ->orWhere('bulan', 'like', "%{$search}%")

                        ->orWhereHas('outlet', function ($outlet) use ($search) {

                            $outlet
                                ->where(
                                    'nama_outlet',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'nama_area',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'nama_spv',
                                    'like',
                                    "%{$search}%"
                                );
                        });
                });
            })

            /**
             * BULAN
             */
            ->when(
                $request->filled('bulan'),
                function ($query) use ($request) {
                    $query->where(
                        'bulan',
                        $request->bulan
                    );
                }
            )

            /**
             * OUTLET
             */
            ->when(
                $request->filled('outlet_id'),
                function ($query) use ($request) {
                    $query->where(
                        'outlet_id',
                        $request->outlet_id
                    );
                }
            )

            /**
             * DATE IN
             */
            ->when(
                $request->filled('date_in'),
                function ($query) use ($request) {
                    $query->whereDate(
                        'date_in',
                        $request->date_in
                    );
                }
            )

            /**
             * RANGE DATE
             */
            ->when(
                $request->filled('date_in_start'),
                function ($query) use ($request) {
                    $query->whereDate(
                        'date_in',
                        '>=',
                        $request->date_in_start
                    );
                }
            )

            ->when(
                $request->filled('date_in_end'),
                function ($query) use ($request) {
                    $query->whereDate(
                        'date_in',
                        '<=',
                        $request->date_in_end
                    );
                }
            )

            /**
             * ITEM
             */
            ->when(
                $request->filled('item'),
                function ($query) use ($request) {
                    $query->where(
                        'item',
                        $request->item
                    );
                }
            )

            /**
             * KETERANGAN
             */
            ->when(
                $request->filled('keterangan'),
                function ($query) use ($request) {
                    $query->where(
                        'keterangan',
                        $request->keterangan
                    );
                }
            )

            /**
             * SORT
             */
            ->orderBy(
                $sort,
                $direction
            );

        /**
         * SUMMARY
         */
        $summaryQuery = clone $salesQuery;

        $totalData = $summaryQuery->count();

        $totalSales = (clone $salesQuery)
            ->sum('sales_tabung');

        $totalTekanan = (clone $salesQuery)
            ->sum('tekanan');

        $totalTabung = (clone $salesQuery)
            ->distinct('no_tabung')
            ->count('no_tabung');

        /**
         * PAGINATION
         */
        $perPage = in_array((int) $request->per_page, [10, 20, 50, 100])
            ? (int) $request->per_page
            : 20;

        $sales = $salesQuery
            ->paginate($perPage)
            ->withQueryString();

        /**
         * OUTLET
         */
        $outlets = Outlet::orderBy(
            'nama_outlet',
            'asc'
        )->get();

        return view(
            'sales.index',
            compact(
                'sales',
                'outlets',
                'totalData',
                'totalSales',
                'totalTekanan',
                'totalTabung',
                'sort',
                'direction',
                'perPage'
            )
        );
    }

    /**
     * =========================================================
     * EXPORT EXCEL
     * =========================================================
     */
    public function export(Request $request)
    {
        $this->checkRole();

        $filename =
            'Data_Sales_' .
            now()->format('Y-m-d_H-i-s') .
            '.xlsx';

        return Excel::download(
            new SalesExport($request),
            $filename
        );
    }

    /**
     * =========================================================
     * CREATE
     * =========================================================
     */
    public function create()
    {
        $this->checkRole();

        $outlets = Outlet::orderBy(
            'nama_outlet',
            'asc'
        )->get();

        $tabungs = Tabung::orderBy(
            'kode_tabung',
            'asc'
        )->get();

        return view(
            'sales.create',
            compact(
                'outlets',
                'tabungs'
            )
        );
    }

    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $this->checkRole();

        $validated = $request->validate([
            'outlet_id' => [
                'required',
                'exists:outlet,id'
            ],

            'date_in' => [
                'required',
                'date'
            ],

            'item' => [
                'required',
                'in:ISI N2,KOSONG'
            ],

            'tekanan' => [
                'required',
                'numeric',
                'min:0'
            ],

            'no_tabung' => [
                'required',
                'exists:tabung,kode_tabung'
            ],

            'date_end' => [
                'nullable',
                'date',
                'after_or_equal:date_in'
            ],

            'sales_tabung' => [
                'required',
                'numeric',
                'min:0'
            ],

            'keterangan' => [
                'required',
                'in:BELUM HABIS,HABIS,LANJUTAN,KOSONG'
            ],

            'catatan' => [
                'nullable',
                'string'
            ],

            'nama_operator' => [
                'required',
                'string'
            ],

            'bulan' => [
                'required',
                'in:JANUARY,FEBRUARY,MARCH,APRIL,MAY,JUNE,JULY,AUGUST,SEPTEMBER,OCTOBER,NOVEMBER,DECEMBER'
            ],
        ]);

        /**
         * Ambil tabung
         */
        $tabung = Tabung::where(
            'kode_tabung',
            $validated['no_tabung']
        )->firstOrFail();


        /**
         * Seri otomatis
         */
        $validated['seri_tabung'] =
            $tabung->nomor_seri;

        /**
         * User
         */
        $validated['user_id'] =
            Auth::id();

        /**
         * Simpan
         */
        Sale::create($validated);

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Data sales tabung berhasil ditambahkan.'
            );
    }

    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy(Sale $sale)
    {
        $this->checkRole();

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Data sales berhasil dihapus.'
            );
    }
}
