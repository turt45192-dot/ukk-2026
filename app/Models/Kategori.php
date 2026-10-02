<?php

namespace App\Models;

use Sakuci\Database\Model;

class Kategori extends Model
{
    protected static ?string $table = 'kategori';
    protected string $primaryKey = 'id_kategori';

    protected array $fillable = [
        'kode_kategori',
        'nama_kategori',
        'keterangan'
    ];

    /**
     * Relasi One-to-Many ke Model Alat
     * Satu kategori memiliki banyak alat
     */
    public function alat()
    {
        return $this->hasMany(Alat::class, 'id_kategori', 'id_kategori');
    }
}