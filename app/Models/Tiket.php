<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'event_id',
        'type_tiket_id',    
        'harga',
        'stok',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'detail_orders')->withPivot('jumlah', 'subtotal_harga');
    }
    public function typeTiket()
    {
        return $this->belongsTo(TypeTiket::class, 'type_tiket_id');
    }

    
}