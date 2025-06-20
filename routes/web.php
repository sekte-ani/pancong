<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
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

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/about', function () {
//     return view('about');
// });

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Route::get('/bestseller', function () {
//     return view('layouts.bestseller');
// });

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/admin', function(){
    return redirect('/admin/dashboard');
});

Route::prefix('/admin')->middleware(['auth', 'verified', 'admin'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('admin.index');

    Route::get('/gallery', [AdminController::class, 'indexGallery'])->name('admin.gallery');
    Route::get('/createGallery', [AdminController::class, 'createGallery'])->name('admin.createGallery');
    Route::post('/storeGallery', [AdminController::class, 'storeGallery'])->name('admin.storeGallery');
    Route::get('/editGallery/{gallery:slug}', [AdminController::class, 'editGallery'])->name('admin.editGallery');
    Route::put('/updateGallery/{id}', [AdminController::class, 'updateGallery'])->name('admin.updateGallery');
    Route::delete('/deleteGallery/{gallery:slug}', [AdminController::class, 'destroyGallery'])->name('admin.deleteGallery');

    Route::get('/menu', [AdminController::class, 'indexMenu'])->name('admin.menu');
    Route::get('/showMenu/{menu:slug}', [AdminController::class, 'showMenu'])->name('admin.showMenu');
    Route::get('/createMenu', [AdminController::class, 'createMenu'])->name('admin.createMenu');
    Route::post('/storeMenu', [AdminController::class, 'storeMenu'])->name('admin.storeMenu');
    Route::get('/editMenu/{menu:slug}', [AdminController::class, 'editMenu'])->name('admin.editMenu');
    Route::put('/updateMenu/{id}', [AdminController::class, 'updateMenu'])->name('admin.updateMenu');
    Route::delete('/deleteMenu/{menu:slug}', [AdminController::class, 'destroyMenu'])->name('admin.deleteMenu');

    Route::get('/checkSlugArticle', [AdminController::class, 'checkSlugArticle']);
    Route::get('/checkSlugName', [AdminController::class, 'checkSlugName']);
    Route::get('/checkSlugTitle', [AdminController::class, 'checkSlugTitle']);
});