<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $stores = [
            [
                'id' => 1,
                'name' => 'Pancong Lumer Krukut',
                'address' => 'Jl. Raya Krukut No. 25, Krukut, Depok, Jawa Barat 16515',
                'phone' => '021-1234567',
                'whatsapp' => '6281234567890',
                'instagram' => '@panconglumer_krukut',
                'latitude' => -6.3751,
                'longitude' => 106.8650,
                'status' => 'active',
                'hours' => [
                    'open' => '08:00',
                    'close' => '22:00'
                ],
                'detailed_hours' => [
                    0 => ['open' => '09:00', 'close' => '21:00'],
                    1 => ['open' => '08:00', 'close' => '22:00'],
                    2 => ['open' => '08:00', 'close' => '22:00'],
                    3 => ['open' => '08:00', 'close' => '22:00'],
                    4 => ['open' => '08:00', 'close' => '22:00'],
                    5 => ['open' => '08:00', 'close' => '23:00'],
                    6 => ['open' => '08:00', 'close' => '23:00'],
                ],
                'color' => '#ce1212'
            ],
            [
                'id' => 2,
                'name' => 'Pancong Lumer Sawangan',
                'address' => 'Jl. Sawangan Raya No. 88, Sawangan, Depok, Jawa Barat 16511',
                'phone' => '021-1234568',
                'whatsapp' => '6281234567891',
                'instagram' => '@panconglumer_sawangan',
                'latitude' => -6.4025,
                'longitude' => 106.7942,
                'status' => 'active',
                'hours' => [
                    'open' => '08:00',
                    'close' => '22:00'
                ],
                'detailed_hours' => [
                    0 => ['open' => '09:00', 'close' => '21:00'],
                    1 => ['open' => '08:00', 'close' => '22:00'],
                    2 => ['open' => '08:00', 'close' => '22:00'],
                    3 => ['open' => '08:00', 'close' => '22:00'],
                    4 => ['open' => '08:00', 'close' => '22:00'],
                    5 => ['open' => '08:00', 'close' => '23:00'],
                    6 => ['open' => '08:00', 'close' => '23:00'],
                ],
                'color' => '#ce1212'
            ]
        ];

        return view('location', compact([
            'stores',
        ]));
    }
}
