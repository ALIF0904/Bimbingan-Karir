<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'nama', 'tipe', 'nomor', 'atas_nama', 'is_active'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
    