<?php

namespace App\Models;

use Sakuci\Database\Model;

class Aspirasi extends Model
{
    protected static ?string $table = 'aspirasis';

    protected array $fillable = [
        'nama'
    ];
}
