<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;

class AspirasiController extends Controller
{
    // TAMPILKAN DAFTAR ASPIRASI
    public function index(Request $request)
    {
        $data = Aspirasi::with('kategori')
            ->orderBy('id_aspirasi', 'desc')
            ->paginate(10);

        return view('aspirasi.index', compact('data'));
    }

    // FORM TAMBAH
    public function create()
    {
        $kategori = Kategori::all();
        return view('aspirasi.create', compact('kategori'));
    }

    // SIMPAN DATA + UPLOAD FOTO
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|numeric',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $namaFoto = null;

        // Proses Upload File
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['foto'];
            $namaFoto = time() . '_' . basename($file['name']);
            
            // Menggunakan \public_path() atau path absolut server
            $targetDir = function_exists('public_path') ? \public_path('uploads/aspirasi/') : __DIR__ . '/../../public/uploads/aspirasi/';
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file($file['tmp_name'], $targetDir . $namaFoto);
        }

        Aspirasi::create([
            'id_kategori' => $request->id_kategori,
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $namaFoto,
            'status'      => 'Pending',
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->first();
        $kategori = Kategori::all();

        return view('aspirasi.edit', compact('aspirasi', 'kategori'));
    }

    // UPDATE DATA + FOTO
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required|numeric',
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $aspirasi = Aspirasi::where('id_aspirasi', $id)->first();
        $namaFoto = $aspirasi->foto;

        $targetDir = function_exists('public_path') ? \public_path('uploads/aspirasi/') : __DIR__ . '/../../public/uploads/aspirasi/';

        // Proses Update File
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Hapus foto lama jika ada di server
            if ($aspirasi->foto && file_exists($targetDir . $aspirasi->foto)) {
                unlink($targetDir . $aspirasi->foto);
            }

            $file = $_FILES['foto'];
            $namaFoto = time() . '_' . basename($file['name']);
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Pindahkan file baru
            move_uploaded_file($file['tmp_name'], $targetDir . $namaFoto);
        }

        $aspirasi->update([
            'id_kategori' => $request->id_kategori,
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $namaFoto,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui');
    }

    // HAPUS DATA & FOTO
    public function destroy(Request $request, $id)
    {
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->first();
        $targetDir = function_exists('public_path') ? \public_path('uploads/aspirasi/') : __DIR__ . '/../../public/uploads/aspirasi/';

        if ($aspirasi) {
            if ($aspirasi->foto && file_exists($targetDir . $aspirasi->foto)) {
                unlink($targetDir . $aspirasi->foto);
            }
            $aspirasi->delete();
        }

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dihapus');
    }

       // FUNGSI TANGGAPI OLEH ADMIN
    public function tanggapi(Request $request, $id_aspirasi)
    {
        $aspirasi = Aspirasi::where('id_aspirasi', $id_aspirasi)->first();

        if ($aspirasi) {
            // Simpan isi tanggapan dan ubah status menjadi Selesai
            $aspirasi->tanggapan = $request->tanggapan;
            $aspirasi->status = 'Selesai';
            $aspirasi->save();

            return redirect('/aspirasi')->with('success', 'Tanggapan berhasil dikirim dan status diperbarui menjadi Selesai.');
        }

        return redirect('/aspirasi')->with('error', 'Data aspirasi tidak ditemukan.');
    }
}