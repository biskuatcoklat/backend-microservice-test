<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'harga', 'kategori_id','gambar'];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
