<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id_item',
            'qty' => 'required|integer|min:1|max:99'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->menu_id])) {
            $cart[$request->menu_id]['qty'] += $request->qty;
        } else {
            $cart[$request->menu_id] = [
                'id_item' => $menu->id_item,
                'nama_item' => $menu->nama_item,
                'harga' => $menu->harga,
                'qty' => $request->qty,
                'gambar' => $menu->gambar
            ];
        }
        
        Session::put('cart', $cart);
        
        $customCart = Session::get('custom_cart', []);
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
            'message' => 'Item berhasil ditambahkan ke keranjang!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalCartPrice
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|string',
            'qty' => 'required|integer|min:0|max:99'
        ]);

        $cart = Session::get('cart', []);
        
        if ($request->qty == 0) {
            unset($cart[$request->menu_id]);
        } else {
            if (isset($cart[$request->menu_id])) {
                $cart[$request->menu_id]['qty'] = $request->qty;
            }
        }
        
        Session::put('cart', $cart);
        
        $customCart = Session::get('custom_cart', []);
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
            'message' => 'Keranjang berhasil diupdate!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalCartPrice
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|string'
        ]);

        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        if (isset($cart[$request->menu_id])) {
            unset($cart[$request->menu_id]);
            Session::put('cart', $cart);
        }
        
        if (isset($customCart[$request->menu_id])) {
            unset($customCart[$request->menu_id]);
            Session::put('custom_cart', $customCart);
        }
        
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
            'message' => 'Item berhasil dihapus dari keranjang!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalCartPrice
        ]);
    }

    public function getCartSummary()
    {
        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        $totalMenus = array_sum(array_column($cart, 'qty'));
        $totalPrice = 0;
        
        foreach ($cart as $menu) {
            $totalPrice += $menu['harga'] * $menu['qty'];
        }
        
        $totalCustomMenus = array_sum(array_column($customCart, 'qty'));
        $totalCustomPrice = 0;
        
        foreach ($customCart as $customMenu) {
            $totalCustomPrice += $customMenu['total_price'] * $customMenu['qty'];
        }
        
        $grandTotalMenus = $totalMenus + $totalCustomMenus;
        $grandTotalPrice = $totalPrice + $totalCustomPrice;

        $cartPreview = [];
        $count = 0;
        
        foreach ($cart as $menu) {
            if ($count < 5) {
                $cartPreview[] = [
                    'type' => 'regular',
                    'nama_item' => $menu['nama_item'],
                    'qty' => $menu['qty'],
                    'harga' => $menu['harga'],
                    'gambar' => $menu['gambar'] ?? null
                ];
                $count++;
            }
        }
        
        foreach ($customCart as $customMenu) {
            if ($count < 5) {
                $cartPreview[] = [
                    'type' => 'custom',
                    'nama_item' => $customMenu['display_name'] ?? 'Custom Pancong',
                    'qty' => $customMenu['qty'],
                    'harga' => $customMenu['total_price'],
                    'total_price' => $customMenu['total_price'],
                    'base_price' => $customMenu['base_price'] ?? 0,
                    'addons_price' => $customMenu['addons_price'] ?? 0,
                    'gambar' => null
                ];
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'cart_count' => $grandTotalMenus,
            'cart_total' => $grandTotalPrice,
            'cart_preview' => $cartPreview,
            'has_more' => (count($cart) + count($customCart)) > 5,
            'regular_count' => $totalMenus,
            'custom_count' => $totalCustomMenus,
            'regular_total' => $totalPrice,
            'custom_total' => $totalCustomPrice
        ]);
    }

    public function checkItemInCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $menuId = $request->get('menu_id');
        
        $qty = isset($cart[$menuId]) ? $cart[$menuId]['qty'] : 0;
        
        return response()->json([
            'success' => true,
            'in_cart' => $qty > 0,
            'qty' => $qty
        ]);
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($cart as $menu) {
            $subtotal = $menu['harga'] * $menu['qty'];
            $cartItems[] = array_merge($menu, [
                'type' => 'regular',
                'subtotal' => $subtotal,
                'item_total' => $subtotal,
                'base_price' => $menu['harga'],
                'addons_price' => 0
            ]);
            $totalPrice += $subtotal;
        }
        
        foreach ($customCart as $customMenu) {
            $subtotal = $customMenu['total_price'] * $customMenu['qty'];
            $cartItems[] = [
                'type' => 'custom',
                'id_item' => $customMenu['id'],
                'nama_item' => $customMenu['display_name'] ?? 'Custom Pancong',
                'harga' => $customMenu['total_price'],
                'qty' => $customMenu['qty'],
                'subtotal' => $subtotal,
                'item_total' => $subtotal,
                'base_menu_name' => $customMenu['base_menu_name'] ?? '',
                'selected_addons' => $customMenu['selected_addons'] ?? [],
                'base_price' => $customMenu['base_price'] ?? 0,
                'addons_price' => $customMenu['addons_price'] ?? 0,
                'gambar' => null
            ];
            $totalPrice += $subtotal;
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function clearCart()
    {
        Session::forget(['cart', 'custom_cart']);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan!',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }
}
