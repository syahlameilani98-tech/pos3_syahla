<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('penjualan.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $sale = Penjualan::where('user_id', Auth::id())
                    ->where('status', 'OPEN')
                    ->firstOrFail();

                $product = Produk::lockForUpdate()->findOrFail($request->product_id);

                // Cek stok
                if ($product->stok < $request->quantity) {
                    throw new Exception('Stok produk tidak mencukupi.');
                }

                // Kurangi stok produk
                $product->decrement('stok', $request->quantity);

                // Cek apakah item sudah ada di keranjang/transaksi ini
                $item = ItemPenjualan::where('penjualan_id', $sale->id)
                    ->where('produk_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($item) {
                    // Update kuantitas item yang sudah ada
                    $item->kuantitas += $request->quantity;
                } else {
                    // Buat item penjualan baru
                    $item = new ItemPenjualan([
                        'penjualan_id' => $sale->id,
                        'produk_id'    => $product->id,
                        'kuantitas'    => $request->quantity,
                        'harga_satuan' => $product->harga_jual,
                    ]);
                }

                // Hitung subtotal setelah kuantitas fix
                $item->subtotal = $item->kuantitas * $item->harga_satuan;
                $item->save();

                // Update total pembayaran pada header penjualan
                $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
                $sale->save();
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request, $itempenjualan) {
                $produk = $itempenjualan->produk()->lockForUpdate()->first();
                $selisih = $request->quantity - $itempenjualan->kuantitas;

                // Jika qty bertambah -> kurangi stok
                if ($selisih > 0) {
                    if ($produk->stok < $selisih) {
                        throw new Exception('Stok produk tidak mencukupi.');
                    }
                    $produk->decrement('stok', $selisih);
                }

                // Jika qty berkurang -> kembalikan stok
                if ($selisih < 0) {
                    $produk->increment('stok', abs($selisih));
                }

                // Update kuantitas dan subtotal item
                $itempenjualan->update([
                    'kuantitas' => $request->quantity,
                    'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
                ]);

                // Update total pembayaran penjualan
                $itempenjualan->penjualan->update([
                    'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
                ]);
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Kuantitas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);
        
        DB::transaction(function () use ($itempenjualan) {
            $produk = $itempenjualan->produk;
            $sale = $itempenjualan->penjualan;

            // Kembalikan stok
            $produk->increment('stok', $itempenjualan->kuantitas);

            // Hapus item
            $itempenjualan->delete();

            // Update total pembayaran
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Item berhasil dihapus');
    }
}