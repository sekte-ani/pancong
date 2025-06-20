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
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::middleware('auth')->group(function(){
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/my-orders', [OrderController::class, 'myOrders']);
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
    Route::get('/editGallery/{gallery:slug}', [AdminController::class, 'editGallery'])->name('admin.editGallery');
    Route::put('/updateGallery/{id}', [AdminController::class, 'updateGallery'])->name('admin.updateGallery');
    Route::delete('/deleteGallery/{gallery:slug}', [AdminController::class, 'destroyGallery'])->name('admin.deleteGallery');

    Route::get('/menu', [AdminController::class, 'indexMenu'])->name('admin.menu');
    Route::get('/showMenu/{menu}', [AdminController::class, 'showMenu'])->name('admin.showMenu');
    Route::get('/createMenu', [AdminController::class, 'createMenu'])->name('admin.createMenu');
    Route::post('/storeMenu', [AdminController::class, 'storeMenu'])->name('admin.storeMenu');
    Route::get('/editMenu/{menu}', [AdminController::class, 'editMenu'])->name('admin.editMenu');
    Route::put('/updateMenu/{id}', [AdminController::class, 'updateMenu'])->name('admin.updateMenu');
    Route::delete('/deleteMenu/{menu}', [AdminController::class, 'destroyMenu'])->name('admin.deleteMenu');

    Route::get('/pesanan', [AdminController::class, 'indexOrder'])->name('admin.order');
    Route::get('/showPesanan/{order}', [AdminController::class, 'showOrder'])->name('admin.showOrder');
    Route::patch('/pesanan/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
});