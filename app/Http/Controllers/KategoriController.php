<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return Kategori::with('barangs')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($request->all());
        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        return Kategori::with('barangs')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori->update($request->all());
        return response()->json($kategori, 200);
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return response()->json(['message' => 'Kategori deleted'], 200);
    }
}
