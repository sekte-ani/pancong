<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $companyInfo = [
            'name' => 'Pancong Lumer',
            'tagline' => 'Perjalanan kami menciptakan pancong terlezat dengan cita rasa autentik Indonesia',
            'description' => 'Dari sebuah warung kecil hingga menjadi brand pancong terdepan, kami berkomitmen menghadirkan kelezatan yang tak terlupakan di setiap gigitan.',
            'story' => 'Berawal dari kecintaan terhadap jajanan tradisional Indonesia, Pancong Lumer lahir dari impian sederhana untuk menghadirkan pancong berkualitas tinggi.',
            'story_detail' => 'Di tahun 2020, di tengah pandemi yang mengubah banyak hal, kami memulai perjalanan dengan satu gerobak sederhana dan resep turun temurun keluarga. Dengan dedikasi tinggi dan inovasi berkelanjutan, kini Pancong Lumer telah menjadi pilihan utama pecinta pancong di seluruh Jabodetabek.',
            'founding_year' => 2020,
        ];

        $stats = [
            'total_customers' => User::where('role', 'user')->count(),
            'total_orders' => Order::count(),
            'total_flavors' => Menu::count() + 15,
            'years_experience' => now()->year - $companyInfo['founding_year'],
        ];

        return view('about', compact([
            'companyInfo',
            'stats',
        ]));
    }

    public function apiStats()
    {
        $stats = [
            'total_customers' => User::where('role', 'user')->count(),
            'total_orders' => Order::count(),
            'total_flavors' => Menu::count() + 15,
            'years_experience' => now()->year - 2020,
        ];

        return response()->json($stats);
    }
}
