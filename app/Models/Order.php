<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';

    protected $guarded = [
        'id_pesanan'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'waktu_pesanan' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pelanggan_id', 'id_akun');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id_pesanan');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'order_items', 'order_id', 'menu_id')
                    ->withPivot('qty', 'harga', 'total')
                    ->withTimestamps();
    }

    public function calculateTotal()
    {
        $total = $this->orderItems()->sum('total');
        $this->update(['total_harga' => $total]);
        return $total;
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('waktu_pesanan', today());
    }
}
