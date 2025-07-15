<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display home page
     */
    public function home()
    {
        $pageName = 'Beranda';
        $featuredBooks = Buku::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $categories = KategoriBuku::all();

        return view('frontend.home', compact('pageName', 'featuredBooks', 'categories'));
    }

    /**
     * Display products page
     */
    public function products(Request $request)
    {
        $pageName = 'Produk Kami';
        $categories = KategoriBuku::all();

        $query = Buku::where('status', 1);

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('kategori_buku_id', $request->category);
        }

        // Filter by price
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('harga', '>=', $request->min_price);
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('judul', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('judul', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $books = $query->paginate(9)->withQueryString();

        return view('frontend.products', compact('pageName', 'categories', 'books'));
    }

    /**
     * Display products by category
     */
    public function category(Request $request, $slug)
    {
        $category = KategoriBuku::where('slug', $slug)->firstOrFail();
        $pageName = $category->nama_kategori;
        $categories = KategoriBuku::all();

        $query = Buku::where('status', 1)
            ->where('kategori_buku_id', $category->id);

        // Filter by price
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('harga', '>=', $request->min_price);
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('judul', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('judul', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $books = $query->paginate(9)->withQueryString();

        return view('frontend.category', compact('pageName', 'category', 'categories', 'books'));
    }

    /**
     * Display product detail
     */
    public function productDetail($slug)
    {
        $book = Buku::where('slug', $slug)->where('status', 1)->firstOrFail();
        $pageName = $book->judul;
        $categories = KategoriBuku::all();

        // Get related books
        $related_books = Buku::where('status', 1)
            ->where('id', '!=', $book->id)
            ->where('kategori_buku_id', $book->kategori_buku_id)
            ->take(4)
            ->get();

        return view('frontend.product_detail', compact('pageName', 'book', 'related_books', 'categories'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        $pageName = 'Hubungi Kami';
        return view('frontend.contact', compact('pageName'));
    }
}
