<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        $menus = Menu::count();
        $categories = Category::count();
        $orders = Order::count();
        $orderToday = Order::today()->count();
        $income = Order::today()->status('Paid')->sum('total_harga');

        return view('admin.index', compact([
            'menus',
            'categories',
            'orders',
            'orderToday',
            'income',
        ]));
    }

    // CATEGORY START
    public function indexCategory()
    {
        $categories = Category::with('menus')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.category.createCategory');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori'
        ]);

        Category::create($request->all());

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.category.editCategory', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.category')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->menus()->count() > 0) {
            return redirect()->route('admin.category')->with('error', 'Kategori tidak bisa dihapus karena masih memiliki item!');
        }

        $category->delete();
        return redirect()->route('admin.category')->with('success', 'Kategori berhasil dihapus!');
    }
    // CATEGORY END

    // GALLERY START
    public function indexGallery()
    {
        $gallery = Gallery::latest()->paginate(10);

        return view('admin.gallery.index', compact([
            'gallery',
        ]));
    }

    public function createGallery()
    {
        return view('admin.gallery.createGallery');
    }

    public function storeGallery(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'img' => 'image|file|max:5120|mimes:jpeg,png,jpg,gif,webp',
            'url' => 'required|url',
        ]);

        if($request->file('img')){
            $image = $request->file('img');
            $imageName = str_replace([' ', '/'], '_', $request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img-galleries'), $imageName);
            $validatedData['img'] = 'img-galleries/' . $imageName;
        }

        Gallery::create($validatedData);

        return redirect('/admin/gallery')->with('success', 'Berhasil Menambahkan Album Baru');
    }

    public function editGallery(Gallery $gallery)
    {
        Gallery::findOrFail($gallery->id);

        return view('admin.gallery.editGallery', compact([
            'gallery',
        ]));
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:galeries,slug,'.$id,
            'img' => 'image|file|max:5120|mimes:jpeg,png,jpg,gif,webp',
            'url' => 'required|url',
        ]);

        if($request->file('img')){
            if($request->oldImage){
                $oldImagePath = public_path($request->oldImage);
                if(File::exists($oldImagePath)){
                    File::delete($oldImagePath);
                }
            }
            $image = $request->file('img');
            $imageName = str_replace([' ', '/'], '_', $request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img-galleries'), $imageName);
            $validatedData['img'] = 'img-galleries/' . $imageName;
        }

        $gallery->update($validatedData);

        return redirect('/admin/gallery')->with('success', 'Berhasil Mengedit Album');
    }

    public function destroyGallery(Gallery $gallery)
    {
        Gallery::findOrFail($gallery->id);
        $gallery->delete();

        return redirect('/admin/gallery')->with('success', 'Berhasil Menghapus Album');
    }
    // GALLERY END

    // MENU START
    public function indexMenu()
    {
        $menus = Menu::with('category')->orderBy('id_item', 'asc')->paginate(10);

        return view('admin.menu.index', compact([
            'menus',      
        ]));
    }

    public function showMenu(Menu $menu)
    {
        $menu = Menu::findOrFail($menu->id);

        return view('admin.menu.showMenu', compact([
            'menu',
        ]));
    }

    public function createMenu()
    {
        $categories = Category::all();

        return view('admin.menu.createMenu', compact([
            'categories',
        ]));
    }

    public function storeMenu(Request $request)
    {
        $validatedData = $request->validate([
            'nama_item' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:categories,id',
            'gambar' => 'image|file|max:5120|mimes:jpeg,png,jpg',
        ]);

        if($request->file('gambar')){
            $image = $request->file('gambar');
            $imageName = Str::slug($request->nama_item) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar-menu'), $imageName);
            $validatedData['gambar'] = 'gambar-menu/' . $imageName;
        }

        Menu::create($validatedData);

        return redirect('/admin/menu')->with('success', 'Berhasil Menambahkan Menu Baru');
    }

    public function editMenu(Menu $menu)
    {
        $menu = Menu::with('category')->findOrFail($menu->id_item);
        $categories = Category::all();

        return view('admin.menu.editMenu', compact([
            'menu',
            'categories',
        ]));
    }

    public function updateMenu(Request $request, $id_item)
    {
        $menu = Menu::findOrFail($id_item);

        $validatedData = $request->validate([
            'nama_item' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:categories,id',
            'gambar' => 'image|file|max:5120|mimes:jpeg,png,jpg',
        ]);

        if($request->file('gambar')){
            if($request->oldImage){
                $oldImagePath = public_path($request->oldImage);
                if(File::exists($oldImagePath)){
                    File::delete($oldImagePath);
                }
            }
            $image = $request->file('gambar');
            $imageName = Str::slug($request->nama_item) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar-menu'), $imageName);
            $validatedData['gambar'] = 'gambar-menu/' . $imageName;
        }

        $menu->update($validatedData);

        return redirect('/admin/menu')->with('success', 'Berhasil Mengedit Menu');
    }

    public function destroyMenu(Menu $menu)
    {
        $activeOrder = $menu->orderItems()
            ->whereHas('order', function($query) {
                $query->whereIn('status', ['Pending', 'Paid', 'Process']);
            })->count();

        if ($activeOrder > 0) {
            return redirect()->route('admin.menu')->with('error', 'Item tidak bisa dihapus karena masih ada pesanan aktif!');
        }

        if ($menu->gambar && file_exists(public_path('gambar-menu/' . $menu->gambar))) {
            unlink(public_path('gambar-menu/' . $menu->gambar));
        }

        $menu->delete();

        return redirect('/admin/menu')->with('success', 'Berhasil Menghapus Menu');
    }
    // MENU END

    // ORDER START
    public function indexOrder(Request $request)
    {
        $order = Order::with(['user', 'orderItems.menu'])->latest('waktu_pesanan');
        
        if ($request->has('status') && $request->status != '') {
            $order->where('status', $request->status);
        }

        if ($request->has('tanggal') && $request->tanggal != '') {
            $order->whereDate('waktu_pesanan', $request->tanggal);
        }

        $orders = $order->paginate(15);
        
        return view('admin.order.index', compact([
            'orders',
        ]));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'orderItems.menu']);
        return view('admin.order.show', compact([
            'order',
        ]));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Paid,Process,Ready,Done'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }
    // ORDER END
}
