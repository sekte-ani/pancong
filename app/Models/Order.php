<?php

namespace App\Models;

use App\Models\CustomOrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        $regularTotal = $this->orderItems()->sum('total');
        $customTotal = $this->customOrderItems()->sum('total_price');
        
        $grandTotal = $regularTotal + $customTotal;
        $this->update(['total_harga' => $grandTotal]);
        
        return $grandTotal;
    }

    public function getAllItemsAttribute()
    {
        $regularItems = $this->orderItems()->with('menu')->get()->map(function($item) {
            return [
                'type' => 'regular',
                'id' => $item->id,
                'name' => $item->menu->nama_item,
                'qty' => $item->qty,
                'price' => $item->harga,
                'total' => $item->total,
                'details' => null
            ];
        });

        $customItems = $this->customOrderItems()->with('baseMenu')->get()->map(function($item) {
            return [
                'type' => 'custom',
                'id' => $item->id,
                'name' => $item->display_name,
                'qty' => $item->qty,
                'price' => $item->base_price + $item->addons_price,
                'total' => $item->total_price,
                'details' => [
                    'base_menu' => $item->baseMenu->nama_item,
                    'addons' => $item->selected_addons_details
                ]
            ];
        });

        return $regularItems->concat($customItems);
    }

    public function customOrderItems()
    {
        return $this->hasMany(CustomOrderItem::class, 'order_id', 'id_pesanan');
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
