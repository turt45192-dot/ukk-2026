<?php

namespace App\Models;

use Sakuci\Database\Model;

class Aspirasi extends Model
{
    protected static ?string $table = 'aspirasis';
    
    protected string $primaryKey = 'id_aspirasi';

    protected array $fillable = [
        'id_kategori',
        'judul',
        'deskripsi',
        'foto',
        'status'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}