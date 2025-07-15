<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('id', Auth::id())->get();
        $breadcrumbs = [
            ['name' => 'Master Data Pengguna', 'route' => route('pengguna.index')],
        ];
        $currentPage = 'Pengguna';
        $pageName = 'Data Pengguna';

        $title = 'Delete Pengguna!';
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('master-data.pengguna.index', compact('users', 'breadcrumbs', 'currentPage', 'title', 'pageName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Administrator,Customer',
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.index')->with([
            'success' => 'Pengguna berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pengguna)
    {
        if ($request->filled('email') && $request->email != $pengguna->email) {
            $request->validate([
                'email' => 'string|email|max:255|unique:users,email',
            ]);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'sometimes|in:Administrator,Customer',
        ]);

        $pengguna->update([
            'name' => $request->nama ?? $pengguna->name,
            'email' => $request->email ?? $pengguna->email,
            'password' => $request->password ? Hash::make($request->password) : $pengguna->password,
            'role' => $request->role ?? $pengguna->role,
        ]);

        return redirect()->route('pengguna.index')->with([
            'success' => 'Pengguna berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return redirect()->route('pengguna.index')->with([
                'error' => 'Anda tidak dapat menghapus akun Anda sendiri.'
            ]);
        }

        $user->delete();

        return redirect()->route('pengguna.index')->with([
            'success' => 'Pengguna berhasil dihapus.'
        ]);
    }
}
