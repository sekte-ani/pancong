<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'harga_addon' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_addons', 'addon_id', 'menu_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
