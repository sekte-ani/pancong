<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomMenuController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base_menu_id' => 'required|exists:menus,id_item',
            'selected_addons' => 'array|max:5',
            'selected_addons.*.id' => 'required|exists:addons,id',
            'selected_addons.*.qty' => 'required|integer|min:1|max:5',
            'qty' => 'required|integer|min:1|max:99'
        ], [
            'selected_addons.max' => 'Maksimal 5 add-ons yang bisa dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $baseMenu = Menu::find($request->base_menu_id);
        $selectedAddons = $request->selected_addons ?? [];
        
        $addonsPrice = 0;
        $addonDetails = [];
        
        if (!empty($selectedAddons)) {
            $addonIds = collect($selectedAddons)->pluck('id')->toArray();
            $addons = Addon::whereIn('id', $addonIds)->get();
            
            foreach ($selectedAddons as $selectedAddon) {
                $addon = $addons->firstWhere('id', $selectedAddon['id']);
                if ($addon) {
                    $addonQty = $selectedAddon['qty'];
                    $addonsPrice += $addon->harga_addon * $addonQty;
                    $addonDetails[] = [
                        'id' => $addon->id,
                        'nama_addon' => $addon->nama_addon,
                        'harga_addon' => $addon->harga_addon,
                        'qty' => $addonQty
                    ];
                }
            }
        }

        $totalPrice = $baseMenu->harga + $addonsPrice;
        
        $customItemId = 'custom_' . uniqid();
        
        $displayName = $baseMenu->nama_item;
        if (!empty($addonDetails)) {
            $addonNames = collect($addonDetails)->take(2)->pluck('nama_addon')->implode(', ');
            $moreCount = count($addonDetails) - 2;
            if ($moreCount > 0) {
                $addonNames .= " +{$moreCount} lainnya";
            }
            $displayName .= ' + ' . $addonNames;
        }
        
        $customItem = [
            'id' => $customItemId,
            'type' => 'custom',
            'base_menu_id' => $baseMenu->id_item,
            'base_menu_name' => $baseMenu->nama_item,
            'display_name' => $displayName,
            'base_price' => $baseMenu->harga,
            'addons_price' => $addonsPrice,
            'total_price' => $totalPrice,
            'qty' => $request->qty,
            'selected_addons' => $addonDetails
        ];

        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        if (isset($customCart[$customItemId])) {
            $customCart[$customItemId]['qty'] += $request->qty;
        } else {
            $customCart[$customItemId] = $customItem;
        }
        
        Session::put('custom_cart', $customCart);
        
        $totalMenus = array_sum(array_column($cart, 'qty')) + 
                     array_sum(array_column($customCart, 'qty'));
        
        $totalCartPrice = 0;
        foreach ($cart as $cartItem) {
            $totalCartPrice += $cartItem['harga'] * $cartItem['qty'];
        }
        foreach ($customCart as $customCartItem) {
            $totalCartPrice += $customCartItem['total_price'] * $customCartItem['qty'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Custom pancong berhasil ditambahkan ke keranjang!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalCartPrice,
            'data' => [
                'name' => $displayName,
                'qty' => $customCart[$customItemId]['qty']
            ]
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string',
            'qty' => 'required|integer|min:0|max:99'
        ]);

        $customCart = Session::get('custom_cart', []);
        
        if (!isset($customCart[$request->item_id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang!'
            ], 404);
        }

        if ($request->qty == 0) {
            unset($customCart[$request->item_id]);
        } else {
            $customCart[$request->item_id]['qty'] = $request->qty;
        }

        Session::put('custom_cart', $customCart);

        $cart = Session::get('cart', []);
        $totalMenus = array_sum(array_column($cart, 'qty')) + 
                     array_sum(array_column($customCart, 'qty'));
        
        $totalCartPrice = 0;
        foreach ($cart as $cartItem) {
            $totalCartPrice += $cartItem['harga'] * $cartItem['qty'];
        }
        foreach ($customCart as $customCartItem) {
            $totalCartPrice += $customCartItem['total_price'] * $customCartItem['qty'];
        }

        return response()->json([
            'success' => true,
            'message' => $request->qty == 0 ? 'Item dihapus dari keranjang!' : 'Keranjang berhasil diupdate!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalCartPrice
        ]);
    }
}
