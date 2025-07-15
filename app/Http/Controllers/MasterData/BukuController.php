<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::with('kategoriBuku')->get();

        $breadcrumbs = [
            ['name' => 'Master Data Buku', 'route' => route('buku.index')],
        ];

        $currentPage = 'Buku';

        $pageName = 'Data Buku';

        $title = 'Delete Buku!';
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('master-data.buku.index', compact('breadcrumbs', 'currentPage', 'pageName', 'bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriBukus = KategoriBuku::select('id', 'nama_kategori')->get();

        $breadcrumbs = [
            ['name' => 'Master Data Buku', 'route' => route('buku.index')],
            ['name' => 'Tambah Data Buku', 'route' => route('buku.create')],
        ];

        $currentPage = 'Tambah Data';

        $pageName = 'Tambah Data Buku';

        $currentYear = date('Y');
        $futureYear = 2025;
        $years = [];
        for ($year = $futureYear; $year >= 1945; $year--) {
            $years[] = $year;
        }

        return view('master-data.buku.create', compact('breadcrumbs', 'currentPage', 'pageName', 'kategoriBukus', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategoriBuku' => 'required|exists:kategori_bukus,id',
            'judul' => 'required|string|max:255|unique:bukus,judul',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahunTerbit' => 'required|integer|between:1945,2025',
            'jumlahHalaman' => 'nullable|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'minStok' => 'required|integer|min:0',
            'status' => 'required|in:published,draft',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = uniqid('cover_') . '.' . $cover->getClientOriginalExtension();
            $coverPath = 'image/cover_buku/' . $coverName;
            $cover->move(public_path('image/cover_buku'), $coverName);
        }

        $slug = Str::slug($validated['judul']);

        $buku = Buku::create([
            'kategori_buku_id' => $validated['kategoriBuku'],
            'judul' => $validated['judul'],
            'slug' => $slug,
            'penulis' => $validated['penulis'],
            'penerbit' => $validated['penerbit'],
            'gambar_cover' => $coverPath,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tahun_terbit' => $validated['tahunTerbit'],
            'jumlah_halaman' => $validated['jumlahHalaman'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'min_stok' => $validated['minStok'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        // Load the relationship
        $buku->load('kategoriBuku');

        $breadcrumbs = [
            ['name' => 'Master Data Buku', 'route' => route('buku.index')],
            ['name' => 'Detail Buku', 'route' => route('buku.show', $buku)],
        ];

        $currentPage = 'Detail Buku';
        $pageName = 'Detail Buku: ' . $buku->judul;

        return view('master-data.buku.show', compact('breadcrumbs', 'currentPage', 'pageName', 'buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $kategoriBukus = KategoriBuku::select('id', 'nama_kategori')->get();

        $breadcrumbs = [
            ['name' => 'Master Data Buku', 'route' => route('buku.index')],
            ['name' => 'Edit Buku', 'route' => route('buku.edit', $buku)],
        ];

        $currentPage = 'Edit Buku';
        $pageName = 'Edit Buku: ' . $buku->judul;

        $currentYear = date('Y');
        $futureYear = 2025;
        $years = [];
        for ($year = $futureYear; $year >= 1945; $year--) {
            $years[] = $year;
        }

        return view('master-data.buku.edit', compact('breadcrumbs', 'currentPage', 'pageName', 'buku', 'kategoriBukus', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kategoriBuku' => 'required|exists:kategori_bukus,id',
            'judul' => 'required|string|max:255|unique:bukus,judul,' . $buku->id,
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahunTerbit' => 'required|integer|between:1945,2025',
            'jumlahHalaman' => 'nullable|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'minStok' => 'required|integer|min:0',
            'status' => 'required|in:published,draft',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updateData = [
            'kategori_buku_id' => $validated['kategoriBuku'],
            'judul' => $validated['judul'],
            'penulis' => $validated['penulis'],
            'penerbit' => $validated['penerbit'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tahun_terbit' => $validated['tahunTerbit'],
            'jumlah_halaman' => $validated['jumlahHalaman'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'min_stok' => $validated['minStok'],
            'status' => $validated['status'],
        ];

        // Update slug only if title changed
        if ($buku->judul != $validated['judul']) {
            $updateData['slug'] = Str::slug($validated['judul']);
        }

        // Handle cover image update
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($buku->gambar_cover && file_exists(public_path($buku->gambar_cover))) {
                unlink(public_path($buku->gambar_cover));
            }

            // Save new cover
            $cover = $request->file('cover');
            $coverName = uniqid('cover_') . '.' . $cover->getClientOriginalExtension();
            $coverPath = 'image/cover_buku/' . $coverName;
            $cover->move(public_path('image/cover_buku'), $coverName);

            $updateData['gambar_cover'] = $coverPath;
        }

        $buku->update($updateData);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {

        // Delete cover file if exists
        if ($buku->gambar_cover && file_exists(public_path($buku->gambar_cover))) {
            unlink(public_path($buku->gambar_cover));
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
