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

        $menu = Menu::with('category')->find($request->menu_id);
        
        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan!'
            ], 404);
        }

        $cart = Session::get('cart', []);
        
        if (isset($cart[$menu->id_item])) {
            $cart[$menu->id_item]['qty'] += $request->qty;
        } else {
            $cart[$menu->id_item] = [
                'id_item' => $menu->id_item,
                'nama_item' => $menu->nama_item,
                'harga' => $menu->harga,
                'gambar' => $menu->gambar,
                'kategori' => $menu->category->nama_kategori,
                'qty' => $request->qty
            ];
        }

        Session::put('cart', $cart);

        $totalMenus = array_sum(array_column($cart, 'qty'));
        $totalPrice = 0;
        foreach ($cart as $cartItem) {
            $totalPrice += $cartItem['harga'] * $cartItem['qty'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan ke keranjang!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalPrice,
            'data' => [
                'name' => $menu->nama_item,
                'qty' => $cart[$menu->id_item]['qty']
            ]
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id_item',
            'qty' => 'required|integer|min:0|max:99'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->menu_id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang!'
            ], 404);
        }

        if ($request->qty == 0) {
            unset($cart[$request->menu_id]);
        } else {
            $cart[$request->menu_id]['qty'] = $request->qty;
        }

        Session::put('cart', $cart);

        $totalMenus = array_sum(array_column($cart, 'qty'));
        $totalPrice = 0;
        foreach ($cart as $cartItem) {
            $totalPrice += $cartItem['harga'] * $cartItem['qty'];
        }

        $subtotal = $request->qty > 0 ? 
            $cart[$request->menu_id]['harga'] * $request->qty : 0;

        return response()->json([
            'success' => true,
            'message' => $request->qty == 0 ? 'Item dihapus dari keranjang!' : 'Keranjang berhasil diupdate!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalPrice,
            'item_subtotal' => $subtotal
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id_item'
        ]);

        $cart = Session::get('cart', []);
        
        if (!isset($cart[$request->menu_id])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang!'
            ], 404);
        }

        $menuName = $cart[$request->menu_id]['nama_item'];
        unset($cart[$request->menu_id]);
        Session::put('cart', $cart);

        $totalMenus = array_sum(array_column($cart, 'qty'));
        $totalPrice = 0;
        foreach ($cart as $cartItem) {
            $totalPrice += $cartItem['harga'] * $cartItem['qty'];
        }

        return response()->json([
            'success' => true,
            'message' => $menuName . ' dihapus dari keranjang!',
            'cart_count' => $totalMenus,
            'cart_total' => $totalPrice
        ]);
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($cart as $menu) {
            $subtotal = $menu['harga'] * $menu['qty'];
            $cartItems[] = array_merge($menu, ['subtotal' => $subtotal]);
            $totalPrice += $subtotal;
        }

        return view('cart.index', compact([
            'cartItems',
            'totalPrice'
        ]));
    }

    public function clearCart()
    {
        Session::forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan!',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    public function getCartSummary()
    {
        $cart = Session::get('cart', []);
        
        $totalMenus = array_sum(array_column($cart, 'qty'));
        $totalPrice = 0;
        
        foreach ($cart as $menu) {
            $totalPrice += $menu['harga'] * $menu['qty'];
        }

        $cartPreview = [];
        $count = 0;
        foreach ($cart as $menu) {
            if ($count < 5) {
                $cartPreview[] = [
                    'nama_item' => $menu['nama_item'],
                    'qty' => $menu['qty'],
                    'harga' => $menu['harga'],
                    'gambar' => $menu['gambar']
                ];
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'cart_count' => $totalMenus,
            'cart_total' => $totalPrice,
            'cart_preview' => $cartPreview,
            'has_more' => count($cart) > 5
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
}
