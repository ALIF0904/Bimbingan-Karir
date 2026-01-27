<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTiket extends Model
{
    use HasFactory;

    // Tentukan tabel manual karena namanya 'typetiket'
    protected $table = 'typetiket';

    protected $fillable = ['tipe_tiket'];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
