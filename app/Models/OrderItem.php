<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_pesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id_item');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total = $model->qty * $model->harga;
        });

        static::saved(function ($model) {
            $model->order->calculateTotal();
        });

        static::deleted(function ($model) {
            if ($model->order) {
                $model->order->calculateTotal();
            }
        });
    }
}
