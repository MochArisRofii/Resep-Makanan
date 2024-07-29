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
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}
