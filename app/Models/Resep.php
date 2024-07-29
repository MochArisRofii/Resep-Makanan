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
        return $this->belongsTo(User::class);
    }

    public function bahans()
    {
        return $this->hasMany(Bahan::class);
    }
}
