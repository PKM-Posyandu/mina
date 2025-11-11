<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorPosyandu extends Model
{
    use HasFactory;

    protected $table = 'indikator_posyandu';

    protected $fillable = [
        'kategori',
        'label',
        'metrik',
        'subkategori',
        'nilai',
    ];
}

