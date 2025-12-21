<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tentukan tabel manual karena namanya 'kategoris'
    protected $table = 'kategoris';

    protected $fillable = ['nama'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
