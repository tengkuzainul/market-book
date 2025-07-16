<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MutasiBarang;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MutasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = MutasiBarang::with(['buku', 'user', 'referensi']);

            // Filter berdasarkan buku
            if ($request->filled('buku_id')) {
                $query->where('buku_id', $request->buku_id);
            }

            // Filter berdasarkan jenis mutasi
            if ($request->filled('jenis')) {
                $query->where('jenis_mutasi', $request->jenis);
            }

            // Filter berdasarkan referensi tipe
            if ($request->filled('referensi_tipe')) {
                $query->where('referensi_tipe', $request->referensi_tipe);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('dari_tanggal')) {
                $query->whereDate('created_at', '>=', $request->dari_tanggal);
            }

            if ($request->filled('sampai_tanggal')) {
                $query->whereDate('created_at', '<=', $request->sampai_tanggal);
            }

            $mutasiBarangs = $query->orderBy('created_at', 'desc')->paginate(15);
            $bukus = Buku::orderBy('judul')->get();
        } catch (\Exception $e) {
            // Jika terjadi error, buat collection kosong
            $mutasiBarangs = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(),
                0,
                15,
                1,
                ['path' => request()->url(), 'pageName' => 'page']
            );
            $bukus = Buku::orderBy('judul')->get();

            // Log error untuk debugging
            Log::error('Error in MutasiBarangController@index: ' . $e->getMessage());
        }

        return view('admin.mutasi_barang.index', [
            'pageName' => 'Mutasi Barang',
            'currentPage' => 'Mutasi Barang',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Mutasi Barang', 'route' => route('admin.mutasi-barang.index')]
            ],
            'mutasiBarangs' => $mutasiBarangs,
            'bukus' => $bukus,
            'filters' => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MutasiBarang $mutasiBarang)
    {
        $mutasiBarang->load(['buku', 'user', 'referensi']);

        return view('admin.mutasi_barang.show', [
            'pageName' => 'Detail Mutasi Barang',
            'currentPage' => 'Mutasi Barang',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Mutasi Barang', 'route' => route('admin.mutasi-barang.index')],
                ['name' => 'Detail', 'route' => route('admin.mutasi-barang.show', $mutasiBarang)]
            ],
            'mutasiBarang' => $mutasiBarang
        ]);
    }

    /**
     * Export mutasi barang data
     */
    public function export(Request $request)
    {
        // TODO: Implement export functionality (Excel/PDF)
        // This can be implemented using Laravel Excel package
        return response()->json(['message' => 'Export feature coming soon']);
    }

    /**
     * Get mutasi summary for dashboard
     */
    public function getSummary()
    {
        $today = now()->toDateString();
        $thisMonth = now()->format('Y-m');

        $summary = [
            'hari_ini' => [
                'masuk' => MutasiBarang::masuk()->whereDate('created_at', $today)->sum('jumlah'),
                'keluar' => MutasiBarang::keluar()->whereDate('created_at', $today)->sum('jumlah'),
                'retur' => MutasiBarang::retur()->whereDate('created_at', $today)->sum('jumlah'),
            ],
            'bulan_ini' => [
                'masuk' => MutasiBarang::masuk()->where('created_at', 'like', $thisMonth . '%')->sum('jumlah'),
                'keluar' => MutasiBarang::keluar()->where('created_at', 'like', $thisMonth . '%')->sum('jumlah'),
                'retur' => MutasiBarang::retur()->where('created_at', 'like', $thisMonth . '%')->sum('jumlah'),
            ]
        ];

        return response()->json($summary);
    }

    /**
     * Get buku dengan stok di bawah minimum
     */
    public function getBukuStokMinimum()
    {
        $bukuStokMinimum = Buku::whereRaw('stok <= min_stok')
            ->with('kategoriBuku')
            ->orderBy('stok')
            ->get();

        return view('admin.mutasi_barang.stok-minimum', [
            'pageName' => 'Buku Stok Minimum',
            'currentPage' => 'Mutasi Barang',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Mutasi Barang', 'route' => route('admin.mutasi-barang.index')],
                ['name' => 'Stok Minimum', 'route' => route('admin.mutasi-barang.stok-minimum')]
            ],
            'bukuStokMinimum' => $bukuStokMinimum
        ]);
    }

    /**
     * Display inventory report
     */
    public function laporan(Request $request)
    {
        // Get summary data
        $totalJenisBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $barangMasukBulanIni = MutasiBarang::where('jenis_mutasi', 'masuk')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah');
        $barangKeluarBulanIni = MutasiBarang::where('jenis_mutasi', 'keluar')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah');

        // Get categories
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();

        // Build query for books
        $query = Buku::with(['kategoriBuku']);

        // Apply filters
        if ($request->filled('kategori_id')) {
            $query->where('kategori_buku_id', $request->kategori_id);
        }

        if ($request->filled('stok_minimal')) {
            $query->where('stok', '>=', $request->stok_minimal);
        }

        if ($request->filled('stok_maksimal')) {
            $query->where('stok', '<=', $request->stok_maksimal);
        }

        $bukus = $query->orderBy('judul')->get();

        // Get books with low stock (5 or less)
        $stokMenipis = Buku::where('stok', '<=', 5)
            ->with('kategoriBuku')
            ->orderBy('stok')
            ->get();

        // Add mutation counts to books
        foreach ($bukus as $buku) {
            $buku->total_masuk = MutasiBarang::where('buku_id', $buku->id)
                ->where('jenis_mutasi', 'masuk')
                ->when($request->filled('periode_dari'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->periode_dari);
                })
                ->when($request->filled('periode_sampai'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->periode_sampai);
                })
                ->sum('jumlah');

            $buku->total_keluar = MutasiBarang::where('buku_id', $buku->id)
                ->where('jenis_mutasi', 'keluar')
                ->when($request->filled('periode_dari'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->periode_dari);
                })
                ->when($request->filled('periode_sampai'), function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->periode_sampai);
                })
                ->sum('jumlah');
        }

        return view('admin.mutasi_barang.laporan', [
            'pageName' => 'Laporan Inventory',
            'currentPage' => 'Laporan Inventory',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'route' => route('dashboard')],
                ['name' => 'Laporan Inventory', 'route' => route('admin.laporan-inventory')]
            ],
            'totalJenisBuku' => $totalJenisBuku,
            'totalStok' => $totalStok,
            'barangMasukBulanIni' => $barangMasukBulanIni,
            'barangKeluarBulanIni' => $barangKeluarBulanIni,
            'kategoris' => $kategoris,
            'bukus' => $bukus,
            'stokMenipis' => $stokMenipis
        ]);
    }
}
