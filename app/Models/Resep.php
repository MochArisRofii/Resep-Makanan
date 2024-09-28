<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'user_id',
        'photo'
    ];

    public function user()
    {
        // Mendefinisikan hubungan 'belongsTo' antara model ini dengan model User.
        // Setiap instance dari model ini (misalnya Resep) dimiliki oleh satu pengguna (User).
        // Dalam konteks ini, sebuah resep dibuat oleh satu pengguna, sehingga hubungan ini
        // menunjukkan bahwa Resep "dimiliki oleh" pengguna.
        return $this->belongsTo(User::class);
    }

    public function bahans()
    {
        // Mendefinisikan hubungan 'hasMany' antara model ini dengan model Bahan.
        // Setiap instance dari model ini (misalnya Resep) dapat memiliki banyak bahan (Bahan).
        // Dalam konteks ini, sebuah resep mungkin memiliki banyak bahan yang digunakan 
        // dalam resep tersebut, sehingga hubungan ini menunjukkan bahwa satu Resep 
        // "memiliki banyak" Bahan.
        return $this->hasMany(Bahan::class);
    }
    
}
