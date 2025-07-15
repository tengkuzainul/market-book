<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\RekeningPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekenings = RekeningPembayaran::all();

        $breadcrumbs = [
            ['name' => 'Master Data Rekening', 'route' => route('rekening.index')],
        ];

        $currentPage = 'Rekening Toko';

        $pageName = 'Data Rekening';

        $title = 'Delete Rekening!';
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('master-data.rekening.index', compact('breadcrumbs', 'currentPage', 'pageName', 'rekenings'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:150',
            'nama_pemilik' => 'required|string|max:150',
            'nomor_rekening' => 'required|string|max:100|unique:rekening_pembayarans',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['logo'] = $filename;

            // Ensure directory exists
            if (!file_exists(public_path('image/logo_bank'))) {
                mkdir(public_path('image/logo_bank'), 0777, true);
            }

            $file->move(public_path('image/logo_bank'), $filename);
        }

        RekeningPembayaran::create($validated);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil ditambahkan!');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekeningPembayaran $rekening)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:150',
            'nama_pemilik' => 'required|string|max:150',
            'nomor_rekening' => [
                'required',
                'string',
                'max:100',
                Rule::unique('rekening_pembayarans')->ignore($rekening->id)
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($rekening->logo && file_exists(public_path('image/logo_bank/' . $rekening->logo))) {
                unlink(public_path('image/logo_bank/' . $rekening->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['logo'] = $filename;
            $file->move(public_path('image/logo_bank'), $filename);
        }

        $rekening->update($validated);

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningPembayaran $rekening)
    {
        // Delete logo file if exists
        if ($rekening->logo && file_exists(public_path('image/logo_bank/' . $rekening->logo))) {
            unlink(public_path('image/logo_bank/' . $rekening->logo));
        }

        $rekening->delete();

        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil dihapus!');
    }
}
