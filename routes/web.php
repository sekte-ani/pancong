<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CustomMenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// AUTH
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// GUEST
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/search', [MenuController::class, 'search'])->name('menu.search');
Route::get('/menu/category', [MenuController::class, 'getByCategory'])->name('menu.category');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/api/stats', [AboutController::class, 'apiStats'])->name('api.stats');
Route::get('/lokasi', [LocationController::class, 'index'])->name('location');
Route::get('/api/stores', [LocationController::class, 'apiStores'])->name('api.stores');

// CUSTOM MENU
Route::middleware(['auth'])->group(function () {
    Route::post('/custom-menu/add-to-cart', [CustomMenuController::class, 'addToCart'])->name('custom.menu.add');
    Route::put('/custom-menu/update-cart', [CustomMenuController::class, 'updateCart'])->name('custom.menu.update');
});

// CART
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');
Route::middleware('auth')->group(function(){
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/cart/check-item', [CartController::class, 'checkItemInCart'])->name('cart.check');
});

// ORDER
Route::middleware('auth')->group(function(){
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'storeOrder'])->name('checkout.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/order/{order}', [OrderController::class, 'showOrder'])->name('order.show');
    Route::get('/order/{order}/status', [OrderController::class, 'getOrderStatus'])->name('order.status');
});

// ADMIN
Route::get('/admin', function(){
    return redirect('/admin/dashboard');
});

Route::prefix('/admin')->middleware(['auth', 'verified', 'admin'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('admin.index');

    Route::get('/kategori', [AdminController::class, 'indexCategory'])->name('admin.category');
    Route::get('/createKategori', [AdminController::class, 'createCategory'])->name('admin.createCategory');
    Route::post('/storeKategori', [AdminController::class, 'storeCategory'])->name('admin.storeCategory');
    Route::get('/editKategori/{category}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::put('/updateKategori/{id}', [AdminController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('/deleteKategori/{category}', [AdminController::class, 'destroyCategory'])->name('admin.deleteCategory');

    Route::get('/gallery', [AdminController::class, 'indexGallery'])->name('admin.gallery');
    Route::get('/createGallery', [AdminController::class, 'createGallery'])->name('admin.createGallery');
    Route::post('/storeGallery', [AdminController::class, 'storeGallery'])->name('admin.storeGallery');
    Route::get('/editGallery/{gallery}', [AdminController::class, 'editGallery'])->name('admin.editGallery');
    Route::put('/updateGallery/{id}', [AdminController::class, 'updateGallery'])->name('admin.updateGallery');
    Route::delete('/deleteGallery/{gallery}', [AdminController::class, 'destroyGallery'])->name('admin.deleteGallery');

    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/menu', [AdminController::class, 'indexMenu'])->name('admin.menu');
    Route::get('/showMenu/{menu}', [AdminController::class, 'showMenu'])->name('admin.showMenu');
    Route::get('/createMenu', [AdminController::class, 'createMenu'])->name('admin.createMenu');
    Route::post('/storeMenu', [AdminController::class, 'storeMenu'])->name('admin.storeMenu');
    Route::get('/editMenu/{menu}', [AdminController::class, 'editMenu'])->name('admin.editMenu');
    Route::put('/updateMenu/{id}', [AdminController::class, 'updateMenu'])->name('admin.updateMenu');
    Route::delete('/deleteMenu/{menu}', [AdminController::class, 'destroyMenu'])->name('admin.deleteMenu');

    Route::get('/addon', [AdminController::class, 'indexAddon'])->name('admin.addon');
    Route::get('/addon/create', [AdminController::class, 'createAddon'])->name('admin.createAddon');
    Route::post('/addon/store', [AdminController::class, 'storeAddon'])->name('admin.storeAddon');
    Route::get('/addon/{addon}', [AdminController::class, 'showAddon'])->name('admin.showAddon');
    Route::get('/addon/{addon}/edit', [AdminController::class, 'editAddon'])->name('admin.editAddon');
    Route::put('/addon/{addon}', [AdminController::class, 'updateAddon'])->name('admin.updateAddon');
    Route::delete('/addon/{addon}', [AdminController::class, 'destroyAddon'])->name('admin.destroyAddon');

    Route::get('/orders', [AdminController::class, 'indexOrder'])->name('admin.order');
    Route::get('/order/{order}', [AdminController::class, 'showOrder'])->name('admin.showOrder');
    Route::patch('/order/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::delete('/order/{order}', [AdminController::class, 'deleteOrder'])->name('admin.deleteOrder');

    Route::get('/order/{order}/print', [AdminController::class, 'printOrder'])->name('order.print');
    Route::get('/order/{order}/quick-print', [AdminController::class, 'quickPrintOrder'])->name('order.quick-print');
    Route::post('/orders/print-summary', [AdminController::class, 'printOrdersSummary'])->name('orders.print-summary');
});