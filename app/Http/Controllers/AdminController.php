<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Addon;
use App\Models\Order;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomOrderItem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
            'judul' => 'required',
            'gambar' => 'image|file|max:5120|mimes:jpeg,png,jpg',
        ]);

        if($request->file('gambar')){
            $image = $request->file('gambar');
            $imageName = str_replace([' ', '/'], '_', $request->judul) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('foto-galleries'), $imageName);
            $validatedData['gambar'] = 'foto-galleries/' . $imageName;
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
            'judul' => 'required',
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
            $imageName = str_replace([' ', '/'], '_', $request->judul) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('foto-galleries'), $imageName);
            $validatedData['gambar'] = 'foto-galleries/' . $imageName;
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
        $order = Order::with(['user', 'orderItems.menu', 'customOrderItems.baseMenu'])->latest('waktu_pesanan');
        
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
        $order->load(['user', 'orderItems.menu', 'customOrderItems.baseMenu']);
        return view('admin.order.showOrder', compact([
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

    public function deleteOrder(Order $order)
    {
        try {
            $order->orderItems()->delete();
            $order->customOrderItems()->delete();
            
            $order->delete();
            
            return redirect()->route('admin.order')->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
    // ORDER END

    // ADDON MANAGEMENT START
    public function indexAddon()
    {
        $addons = Addon::latest()->paginate(10);
        return view('admin.addon.index', compact('addons'));
    }

    public function createAddon()
    {
        return view('admin.addon.createAddon');
    }

    public function storeAddon(Request $request)
    {
        $validatedData = $request->validate([
            'nama_addon' => 'required|string|max:100',
            'harga_addon' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        Addon::create($validatedData);

        return redirect()->route('admin.addon')->with('success', 'Berhasil Menambahkan Add-on Baru');
    }

    public function showAddon(Addon $addon)
    {
        return view('admin.addon.showAddon', compact('addon'));
    }

    public function editAddon(Addon $addon)
    {
        return view('admin.addon.editAddon', compact('addon'));
    }

    public function updateAddon(Request $request, Addon $addon)
    {
        $validatedData = $request->validate([
            'nama_addon' => 'required|string|max:100',
            'harga_addon' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        $addon->update($validatedData);

        return redirect()->route('admin.addon')->with('success', 'Berhasil Mengedit Add-on');
    }

    public function destroyAddon(Addon $addon)
    {
        $activeUsage = CustomOrderItem::whereJsonContains('selected_addons', ['id' => $addon->id])
            ->whereHas('order', function($query) {
                $query->whereIn('status', ['Pending', 'Paid', 'Process']);
            })->count();

        if ($activeUsage > 0) {
            return redirect()->route('admin.addon')->with('error', 'Add-on tidak bisa dihapus karena masih digunakan di pesanan aktif!');
        }

        $addon->delete();

        return redirect()->route('admin.addon')->with('success', 'Berhasil Menghapus Add-on');
    }
    // ADDON MANAGEMENT END

    // USER MANAGEMENT START
    public function indexUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        $users = $query->where('role', 'user')->withCount('orders')->withSum('orders as total_spent', 'total_harga')->latest()->paginate(15);

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('role', 'user')->count(),
            'admin_count' => User::where('role', 'admin')->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function showUser(User $user)
    {
        $user->load(['orders' => function($query) {
            $query->with(['orderItems.menu', 'customOrderItems.baseMenu'])
                  ->latest()
                  ->take(10);
        }]);

        $userStats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->sum('total_harga'),
            'average_order' => $user->orders()->avg('total_harga') ?? 0,
            'last_order' => $user->orders()->latest()->first(),
            'favorite_items' => $this->getUserFavoriteItems($user),
            'orders_by_status' => $user->orders()
                                      ->selectRaw('status, count(*) as count')
                                      ->groupBy('status')
                                      ->pluck('count', 'status')
                                      ->toArray(),
        ];

        return view('admin.users.showUser', compact('user', 'userStats'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.editUser', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:20|unique:users,username,' . $user->id_akun . ',id_akun',
            'email' => 'required|email|unique:users,email,' . $user->id_akun . ',id_akun',
            'no_telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,user',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validatedData['password'] = Hash::make($request->password);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')
                        ->with('success', 'User berhasil diupdate!');
    }

    public function destroyUser(User $user)
    {
        if ($user->orders()->exists()) {
            return redirect()->back()
                            ->with('error', 'User tidak dapat dihapus karena memiliki riwayat pesanan!');
        }

        if ($user->role === 'admin') {
            return redirect()->back()
                            ->with('error', 'Admin account tidak dapat dihapus!');
        }

        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', 'User berhasil dihapus!');
    }

    private function getUserFavoriteItems(User $user)
    {
        $regularItems = $user->orders()
                           ->with('orderItems.menu')
                           ->get()
                           ->pluck('orderItems')
                           ->flatten()
                           ->groupBy('menu.nama_item')
                           ->map(function($items) {
                               return [
                                   'name' => $items->first()->menu->nama_item,
                                   'count' => $items->sum('qty'),
                                   'total_spent' => $items->sum('total')
                               ];
                           })
                           ->sortByDesc('count')
                           ->take(5);

        return $regularItems;
    }
    // USER MANAGEMENT END

    // PRINT ORDER START
    public function printOrder(Order $order)
    {
        $order->load(['user', 'orderItems.menu', 'customOrderItems.baseMenu']);
        
        // Jika ada DomPDF, gunakan ini:
        // $pdf = Pdf::loadView('admin.order.print', compact('order'))
        //           ->setPaper([0, 0, 226.77, 800], 'portrait'); // 58mm thermal paper
        // return $pdf->download('receipt-' . $order->id_pesanan . '.pdf');
        
        // Untuk sekarang, langsung return view untuk browser print
        return view('admin.order.print', compact('order'));
    }

    public function quickPrintOrder(Order $order)
    {
        $order->load(['user', 'orderItems.menu', 'customOrderItems.baseMenu']);
        return view('admin.order.print', compact('order'));
    }
    // PRINT ORDER END
}
