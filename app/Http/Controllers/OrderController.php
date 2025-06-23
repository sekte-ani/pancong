<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        if (empty($cart) && empty($customCart)) {
            return redirect()->route('menu')->with('error', 'Keranjang kosong!');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['harga'] * $item['qty'];
        }
        foreach ($customCart as $item) {
            $totalPrice += $item['total_price'] * $item['qty'];
        }

        $allItems = array_merge($cart, $customCart);
        $totalItems = array_sum(array_column($cart, 'qty')) + array_sum(array_column($customCart, 'qty'));

        return view('order.checkout', compact('cart', 'customCart', 'allItems', 'totalPrice', 'totalItems'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'no_meja' => 'required|string|max:10',
            'catatan' => 'nullable|string|max:255'
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $cart = Session::get('cart', []);
        $customCart = Session::get('custom_cart', []);
        
        if (empty($cart) && empty($customCart)) {
            return redirect()->route('menu')->with('error', 'Keranjang kosong!');
        }
        
        try {
            DB::beginTransaction();
            
            $order = Order::create([
                'pelanggan_id' => auth()->id(),
                'waktu_pesanan' => now(),
                'no_meja' => $request->no_meja,
                'catatan' => $request->catatan,
                'status' => 'Pending',
                'total_harga' => 0
            ]);
            
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id_pesanan,
                    'menu_id' => $item['id_item'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'total' => $item['harga'] * $item['qty']
                ]);
            }
            
            foreach ($customCart as $item) {
                CustomOrderItem::create([
                    'order_id' => $order->id_pesanan,
                    'base_menu_id' => $item['base_menu_id'],
                    'qty' => $item['qty'],
                    'base_price' => $item['base_price'],
                    'addons_price' => $item['addons_price'],
                    'total_price' => $item['total_price'] * $item['qty'],
                    'selected_addons' => $item['selected_addons']
                ]);
            }
            
            $order->calculateTotal();
            
            Session::forget(['cart', 'custom_cart']);
            
            DB::commit();
            
            return redirect()->route('order.show', $order->id_pesanan)
                            ->with('success', 'Pesanan berhasil dibuat!');
                            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function myOrders()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $orders = Order::where('pelanggan_id', auth()->id())
                      ->with(['orderItems.menu', 'customOrderItems.baseMenu'])
                      ->orderBy('waktu_pesanan', 'desc')
                      ->paginate(10);

        return view('order.myorder', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($order->pelanggan_id !== auth()->id()) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load(['user', 'orderItems.menu', 'customOrderItems.baseMenu']);
        
        return view('order.detail', compact('order'));
    }

    public function processCheckout(Request $request)
    {
        return $this->storeOrder($request);
    }
}
