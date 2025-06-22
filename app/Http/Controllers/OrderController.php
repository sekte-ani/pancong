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
    public function processCheckout(Request $request)
    {
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
                'status' => 'Pending',
                'total_harga' => 0
            ]);
            
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id_pesanan,
                    'menu_id' => $item['id_item'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga']
                ]);
            }
            
            foreach ($customCart as $item) {
                CustomOrderItem::create([
                    'order_id' => $order->id_pesanan,
                    'base_menu_id' => $item['base_menu_id'],
                    'qty' => $item['qty'],
                    'base_price' => $item['base_price'],
                    'addons_price' => $item['addons_price'],
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
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan!');
        }
    }
}
