<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::latest()->get();
        return view('outlet.index', compact('outlets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_outlet'   => 'required|max:255',
            'harga_isi_n2'  => 'nullable|numeric',
        ]);

        Outlet::create($request->all());

        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_outlet'   => 'required|max:255',
            'harga_isi_n2'  => 'nullable|numeric',
        ]);

        $outlet = Outlet::findOrFail($id);
        $outlet->update($request->all());

        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil diperbarui');
    }

    public function destroy($id)
    {
        $outlet = Outlet::findOrFail($id);
        $outlet->delete();

        return redirect()->route('outlet.index')->with('success', 'Outlet berhasil dihapus');
    }

    public function searchLocation(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return response()->json([
                'features' => [],
            ]);
        }

        try {

            $response = Http::timeout(15)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'GoTube/1.0 (https://gotube.my.id)',
                    'Referer' => 'https://gotube.my.id/',
                ])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'limit' => 10,
                    'countrycodes' => 'id',
                ]);

            if (!$response->successful()) {

                \Log::error('Nominatim Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'query' => $query,
                ]);

                return response()->json([
                    'features' => [],
                    'message' => 'Server pencarian lokasi tidak merespons.',
                ], 502);
            }

            $results = $response->json();

            $features = collect($results)->map(function ($item) {

                $address = $item['address'] ?? [];

                return [
                    'type' => 'Feature',

                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            (float) $item['lon'],
                            (float) $item['lat'],
                        ],
                    ],

                    'properties' => [
                        'name' => $item['name']
                            ?? $address['building']
                            ?? $address['road']
                            ?? 'Lokasi',

                        'street' => $address['road'] ?? null,
                        'housenumber' => $address['house_number'] ?? null,
                        'district' => $address['suburb']
                            ?? $address['village']
                            ?? $address['town']
                            ?? null,
                        'city' => $address['city']
                            ?? $address['municipality']
                            ?? $address['county']
                            ?? null,
                        'state' => $address['state'] ?? null,
                        'country' => $address['country'] ?? null,

                        'display_name' => $item['display_name'] ?? '',
                    ],
                ];
            })->values();

            return response()->json([
                'features' => $features,
            ]);
        } catch (\Throwable $e) {

            \Log::error('Nominatim Location Search Error', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'features' => [],
                'message' => 'Gagal menghubungi server pencarian lokasi.',
            ], 500);
        }
    }
}
