<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::latest('id')->get();
        return view('users.index', compact('users'));
    }

    // STORE USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ], [
            'name.unique' => 'Nama sudah digunakan!',
            'email.unique' => 'Email sudah digunakan!',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User dihapus');
    }

    // CHANGE PASSWORD
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        User::findOrFail($id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password diubah');
    }
}
