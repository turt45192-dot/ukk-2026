<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data = Kategori::orderBy('id_kategori','desc')
        
        ->paginate(10);
        return view('kategori.index', compact('data'));
    }
    public function create(Request $request)
    {
        return view('kategori.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        Kategori::create([
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
}
