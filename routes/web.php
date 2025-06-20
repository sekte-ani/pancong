<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () { return view('home'); })->name('home');
Route::get('/menu', function () { return view('menu'); })->name('menu');
Route::get('/gallery', function () { return view('gallery'); })->name('gallery');
Route::get('/about', function () { return view('about'); })->name('about');

// Route::get('/bestseller', function () {
//     return view('layouts.bestseller');
// });

Route::get('/login', function () {
    return view('save.login');
});