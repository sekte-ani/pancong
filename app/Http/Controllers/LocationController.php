<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $storesDepok = [
            [
                'id' => 1,
                'name' => 'Pancong Lumer Krukut',
                'address' => 'Jl. Raya Krukut No. 25, Krukut, Depok, Jawa Barat 16515',
                'phone' => '021-1234567',
                'latitude' => -6.37000,
                'longitude' => 106.79011,
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
                'address' => 'Jl. Raya sawangan, parung bingung, Depan SWR Car Wash, Sebelah Teh Manis Solo, Sawangan, Kec. Parung, Bingung, Jawa Barat 16511',
                'phone' => '085894128304',
                'latitude' => -6.40725,
                'longitude' => 106.75553,
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

        $storesJkt = [
            [
                'id' => 1,
                'name' => 'Pancong Lumer Pondok Labu',
                'address' => 'Jl. Komp. Timah No.1, RT.1/RW.3, Pd. Labu, Kec. Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12450',
                'phone' => '021-1234567',
                'latitude' => -6.31394,
                'longitude' => 106.80228,
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
            'storesDepok',
            'storesJkt',
        ]));
    }
}
