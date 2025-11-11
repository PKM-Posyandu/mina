<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nomor_whatsapp',
        'kategori_pengaduan',
        'isi_pengaduan',
        'alamat_lengkap',
        'rt',
        'bukti',
        'is_resolved',
    ];
}
