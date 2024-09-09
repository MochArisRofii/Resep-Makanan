<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'quantity',
        'unit',
        'resep_id',
        'position'
    ];

    public function resep()
    {
        // Bahan "dimiliki oleh" satu Resep
        // Menghubungkan kolom 'resep_id' di tabel 'bahans' dengan kolom 'id' di tabel 'reseps'
        return $this->belongsTo(Resep::class);
    }
}
