<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriBukus = KategoriBuku::all();

        $breadcrumbs = [
            ['name' => 'Master Data Kategori Buku', 'route' => route('kategori-buku.index')],
        ];

        $currentPage = 'Kategori Buku';

        $pageName = 'Data Kategori Buku';

        $title = 'Delete Kategori Buku!';
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('master-data.kategori-buku.index', compact('breadcrumbs', 'currentPage', 'pageName', 'kategoriBukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaKategori' => 'required|string|max:100|unique:kategori_bukus,nama_kategori',
        ]);

        KategoriBuku::create([
            'nama_kategori' => $request->namaKategori,
            'slug' => Str::slug($request->namaKategori),
        ]);

        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriBuku $kategoriBuku)
    {
        $request->validate([
            'namaKategori' => 'required|string|max:100|unique:kategori_bukus,nama_kategori,' . $kategoriBuku->id,
        ]);

        $kategoriBuku->update([
            'nama_kategori' => $request->namaKategori,
            'slug' => Str::slug($request->namaKategori),
        ]);

        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategoriBuku = KategoriBuku::findOrFail($id);
        $kategoriBuku->delete();
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori Buku berhasil dihapus.');
    }
}
