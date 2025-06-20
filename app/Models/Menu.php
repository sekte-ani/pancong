<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_item';

    protected $guarded = [
        'id_item'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_id', 'id_item');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'detail_pesanans', 'id_item', 'id_pesanan')
                    ->withPivot('qty', 'harga', 'total')
                    ->withTimestamps();
    }
}
