<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');


        $products = Produk::with('user')
            ->when($keyword, function ($query) use ($keyword) {

                return $query->where('name', 'like', '%' . $keyword . '%')
                             ->orderBy('name');

            }, function ($query) {

                return $query->latest();

            })
            ->paginate(10)
            ->withQueryString();


        return view('produk.index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);


        $dataReq = $request->validated();


        $data = [

            'user_id'     => Auth::id(),
            'name'        => $dataReq['name'],
            'harga_beli'  => $dataReq['purchase_price'],
            'harga_jual'  => $dataReq['selling_price'],
            'stok'        => $dataReq['stock'] ?? 0,

        ];



        if ($request->hasFile('foto')) {

            $data['foto'] = $request->file('foto')
                                   ->store('products', 'public');

        }



        Produk::create($data);



        return redirect()
            ->route('produk.index')
            ->with('success', 'Product created successfully.');
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
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);


        return view('produk.edit', compact('produk'));
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);


        $dataReq = $request->validated();


        $data = [

            'user_id'     => Auth::id(),
            'name'        => $dataReq['name'],
            'harga_beli'  => $dataReq['purchase_price'],
            'harga_jual'  => $dataReq['selling_price'],
            'stok'        => $dataReq['stock'],

        ];



        if ($request->hasFile('foto')) {


            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {

                Storage::disk('public')->delete($produk->foto);

            }


            $data['foto'] = $request->file('foto')
                                   ->store('products', 'public');

        }



        $produk->update($data);



        return redirect()
            ->route('produk.index')
            ->with('success', 'Product updated successfully.');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);



        // Cek apakah produk sudah pernah dipakai transaksi
        if ($produk->itemPenjualan()->exists()) {


            return redirect()
                ->route('produk.index')
                ->with('errors', 'Produk tidak bisa dihapus karena sudah digunakan dalam transaksi penjualan.');

        }



        // Hapus foto produk
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {


            Storage::disk('public')->delete($produk->foto);


        }




        // Hapus data produk
        $produk->delete();




        return redirect()
            ->route('produk.index')
            ->with('success', 'Product deleted successfully.');
    }
}