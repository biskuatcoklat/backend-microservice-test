<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return Barang::with('kategori')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $barang = Barang::create($request->all());
        return response()->json($barang->load('kategori'), 201);
    }

    public function show($id)
    {
        return Barang::with('kategori')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
        ]);

        $barang->update($request->all());
        return response()->json($barang->load('kategori'), 200);
    }
    
    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json(['message' => 'Barang deleted'], 200);
    }

}
