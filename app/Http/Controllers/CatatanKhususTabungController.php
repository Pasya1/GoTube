<?php

namespace App\Http\Controllers;

use App\Models\CatatanKhususTabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CatatanKhususTabungController extends Controller
{
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'spv'])) {
            abort(403);
        }

        $request->validate([
            'kode_tabung' => 'required|string|max:255',
            'outlet_id'   => 'required|exists:outlet,id',
            'catatan'     => 'required|string|max:2000',
        ]);

        $catatan = CatatanKhususTabung::create([
            'kode_tabung' => trim($request->kode_tabung),
            'outlet_id'   => $request->outlet_id,
            'user_id'     => Auth::id(),
            'catatan'     => trim($request->catatan),
        ]);

        /*
        |--------------------------------------------------------------------------
        | EMAIL NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        if ($user->email) {
            Mail::raw(
                "Catatan khusus baru telah ditambahkan.\n\n" .
                    "Tabung       : {$catatan->kode_tabung}\n" .
                    "Outlet       : {$catatan->outlet->nama_outlet}\n" .
                    "Catatan      : {$catatan->catatan}\n" .
                    "Ditambahkan  : {$user->name}\n" .
                    "Waktu        : {$catatan->created_at->format('d-m-Y H:i')}",
                function ($message) use ($user) {
                    $message
                        ->to($user->email)
                        ->subject('Notifikasi Catatan Khusus Tabung - GoTube');
                }
            );
        }

        return back()->with(
            'success',
            'Catatan khusus berhasil ditambahkan dan notifikasi email telah dikirim.'
        );
    }


    public function destroy(CatatanKhususTabung $catatanKhususTabung)
    {
        if (!in_array(Auth::user()->role, ['admin', 'spv'])) {
            abort(403);
        }

        $catatanKhususTabung->delete();

        return back()->with(
            'success',
            'Catatan khusus berhasil dihapus.'
        );
    }
}
