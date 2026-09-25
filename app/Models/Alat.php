<?php

namespace App\Models;

use Sakuci\Database\Model;

class Alat extends Model
{
    protected static ?string $table = 'alat';
    protected string $primaryKey = 'id_alat';

    protected array $fillable = [
        'nama_alat',
        'kode_alat',
        'kondisi',
        'jumlah',
        'lokasi',
        'id_kategori'
    ];

    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}