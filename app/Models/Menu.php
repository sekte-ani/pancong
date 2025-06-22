<?php

namespace App\Models;

use App\Models\Addon;
use App\Models\CustomOrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'menu_addons', 'menu_id', 'addon_id');
    }

    public function customOrderItems()
    {
        return $this->hasMany(CustomOrderItem::class, 'base_menu_id', 'id_item');
    }

    public function scopeCanBeBase($query)
    {
        return $query->whereHas('category', function($q) {
            $q->where('nama_kategori', 'LIKE', '%polos%')
            ->orWhere('nama_kategori', 'LIKE', '%original%');
        });
    }
}
