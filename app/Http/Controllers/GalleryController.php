<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::take(6)->latest()->get();

        return view('gallery', compact([
            'galleries',
        ]));
    }
}
