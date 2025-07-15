<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Keranjang;
use App\Models\RekeningPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Keranjang::with('buku')
            ->where('user_id', Auth::id())
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->subtotal;
        }

        return view('customer.cart', [
            'pageName' => 'Keranjang Belanja',
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Check if the book exists and has enough stock
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < $request->jumlah) {
            Alert::error('Gagal', 'Stok buku tidak mencukupi');
            return redirect()->back();
        }

        // Check if the item already exists in cart
        $existingCartItem = Keranjang::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->first();

        if ($existingCartItem) {
            // Update quantity if already in cart
            $existingCartItem->update([
                'jumlah' => $existingCartItem->jumlah + $request->jumlah
            ]);
        } else {
            // Create new cart item
            Keranjang::create([
                'user_id' => Auth::id(),
                'buku_id' => $request->buku_id,
                'jumlah' => $request->jumlah
            ]);
        }

        Alert::success('Berhasil', 'Buku berhasil ditambahkan ke keranjang');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cartItem = Keranjang::findOrFail($id);

        // Check if user owns this cart item
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        // Check if book has enough stock
        $buku = Buku::findOrFail($cartItem->buku_id);
        if ($buku->stok < $request->jumlah) {
            Alert::error('Gagal', 'Stok buku tidak mencukupi');
            return redirect()->back();
        }

        $cartItem->update([
            'jumlah' => $request->jumlah
        ]);

        Alert::success('Berhasil', 'Jumlah item berhasil diperbarui');
        return redirect()->route('customer.cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Keranjang::findOrFail($id);

        // Check if user owns this cart item
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        Alert::success('Berhasil', 'Item berhasil dihapus dari keranjang');
        return redirect()->route('customer.cart.index');
    }

    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cartItems = Keranjang::with('buku')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            Alert::info('Info', 'Keranjang Anda kosong');
            return redirect()->route('frontend.products');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->subtotal;
        }

        $rekening = RekeningPembayaran::where('status', 'aktif')->get();

        return view('customer.checkout', [
            'pageName' => 'Checkout',
            'cartItems' => $cartItems,
            'total' => $total,
            'rekening' => $rekening
        ]);
    }
}
