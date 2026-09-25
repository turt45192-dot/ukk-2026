<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori; // Jangan lupa import model Kategori di sini

class AlatController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data alat beserta relasi kategorinya
        $data = Alat::with('kategori')
            ->orderBy('id_alat', 'desc')
            ->paginate(5);

        return view('alat.index', compact('data'));
    }

    public function create(Request $request)
    {
        // Mengambil semua data kategori untuk isi opsi dropdown
        $kategori = Kategori::all();

        return view('alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|numeric',
            'nama_alat'   => 'required|string|max:255',
            'kode_alat'   => 'required|string|unique:alat,kode_alat',
            'kondisi'     => 'required|string|max:50',
            'jumlah'      => 'required|numeric',
            'lokasi'      => 'required|string|max:255',
        ]);

        Alat::create([
            'id_kategori' => $request->id_kategori,
            'nama_alat'   => $request->nama_alat,
            'kode_alat'   => $request->kode_alat,
            'kondisi'     => $request->kondisi,
            'jumlah'      => $request->jumlah,
            'lokasi'      => $request->lokasi,
        ]);

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil ditambahkan');
    }

    public function edit($alat)
    {
        $data_alat = Alat::where('id_alat', $alat)->first();
        $kategori = Kategori::all(); // Ambil semua kategori untuk dropdown di halaman edit

        return view('alat.edit', compact('data_alat', 'kategori'));
    }

    public function update(Request $request, $alat)
    {
        $request->validate([
            'id_kategori' => 'required|numeric',
            'nama_alat'   => 'required|string|max:255',
            'kode_alat'   => 'required|string|unique:alat,kode_alat,' . $alat . ',id_alat',
            'kondisi'     => 'required|string|max:50',
            'jumlah'      => 'required|numeric',
            'lokasi'      => 'required|string|max:255',
        ]);

        $data_alat = Alat::where('id_alat', $alat)->first();
        $data_alat->update([
            'id_kategori' => $request->id_kategori,
            'nama_alat'   => $request->nama_alat,
            'kode_alat'   => $request->kode_alat,
            'kondisi'     => $request->kondisi,
            'jumlah'      => $request->jumlah,
            'lokasi'      => $request->lokasi,
        ]);

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $alat = Alat::where('id_alat', $id)->first();
        if ($alat) {
            $alat->delete();
        }

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil dihapus.');
    }
}