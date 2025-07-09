<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'addons_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'selected_addons' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_pesanan');
    }

    public function baseMenu()
    {
        return $this->belongsTo(Menu::class, 'base_menu_id', 'id_item');
    }

    public function getSelectedAddonsDetailsAttribute()
    {
        if (empty($this->selected_addons)) {
            return collect();
        }

        $addonIds = collect($this->selected_addons)->pluck('id')->toArray();
        $addons = Addon::whereIn('id', $addonIds)->get();

        return $addons->map(function($addon) {
            $selectedAddon = collect($this->selected_addons)->firstWhere('id', $addon->id);
            return [
                'id' => $addon->id,
                'nama_addon' => $addon->nama_addon,
                'harga_addon' => $addon->harga_addon,
                'qty' => $selectedAddon['qty'] ?? 1
            ];
        });
    }

    public function getDisplayNameAttribute()
    {
        $baseName = $this->baseMenu->nama_item ?? 'Pancong Custom';
        
        if (empty($this->selected_addons)) {
            return $baseName;
        }

        $addonNames = collect($this->selected_addons)->map(function($addon) {
            $qty = $addon['qty'] > 1 ? " ({$addon['qty']}x)" : '';
            return $addon['nama_addon'] . $qty;
        })->take(5)->implode(', ');

        return $baseName . ' + ' . $addonNames;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = ($model->base_price + $model->addons_price) * $model->qty;
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
