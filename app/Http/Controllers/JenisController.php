<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index(Request $request)
    {
        $jenis = Jenis::query()
            ->when($request->search, function ($query, $search) {
                $query->where("nama", "like", "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("jenis.index", compact("jenis"));
    }

    public function create()
    {
        return view("jenis.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
        ]);

        Jenis::create($request->all());

        return redirect()->route("jenis.index")->with("success", "Jenis berhasil ditambahkan.");
    }

    public function edit(Jenis $jenis)
    {
        return view("jenis.edit", compact("jenis"));
    }

    public function update(Request $request, Jenis $jenis)
    {
        $request->validate([
            "nama" => "required|string|max:255",
        ]);

        $jenis->update($request->all());

        return redirect()->route("jenis.index")->with("success", "Jenis berhasil diupdate.");
    }

    public function destroy(Jenis $jenis)
    {
        $jenis->delete();

        return redirect()->route("jenis.index")->with("success", "Jenis berhasil dihapus.");
    }
};