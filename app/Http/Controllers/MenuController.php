<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Addon;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request){
        $query = Menu::with('category');

        if ($request->has('category') && $request->category != ''){
            $query->where('kategori_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_item', 'like', '%' . $request->search . '%');
        }

        $menus = $query->get();
        $categories = Category::withCount('menus')->get();

        $baseMenus = Menu::canBeBase()->with('category')->get();
        $addons = Addon::active()->get();
        
        $menusByCategory = $menus->groupBy('category.nama_kategori');
        
        return view('menu.index', compact([
            'menus',
            'categories',
            'menusByCategory',
            'baseMenus',
            'addons'
        ]));
    }

    public function getByCategory(Request $request)
    {
        $kategoriId = $request->get('kategori_id');
        
        $menus = Menu::with('category')
                    ->when($kategoriId, function($query) use ($kategoriId) {
                        return $query->where('kategori_id', $kategoriId);
                    })
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $menus->map(function($item) {
                return [
                    'id_item' => $item->id_item,
                    'nama_item' => $item->nama_item,
                    'harga' => $item->harga,
                    'harga_formatted' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                    'gambar' => $item->gambar ? asset('gambar-menu/' . $item->gambar) : asset('img/logo_pancong.png'),
                    'kategori' => $item->category->nama_kategori
                ];
            })
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('search', '');
        
        if (strlen($search) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal 2 karakter untuk pencarian'
            ]);
        }

        $menus = Menu::with('category')
                    ->where('nama_item', 'like', '%' . $search . '%')
                    ->take(10)
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $menus->map(function($item) {
                return [
                    'id_item' => $item->id_item,
                    'nama_item' => $item->nama_item,
                    'harga' => $item->harga,
                    'harga_formatted' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                    'gambar' => $item->gambar ? asset('admin/img/' . $item->gambar) : asset('img/logo_pancong.png'),
                    'kategori' => $item->kategori->nama_kategori
                ];
            })
        ]);
    }
}
