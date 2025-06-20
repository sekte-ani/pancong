<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.index');
    }

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

    // TEACHER START
    public function indexMenu()
    {
        $menu = Menu::orderBy('id', 'asc')->paginate(10);

        return view('admin.menu.index', compact([
            'menu',      
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
        return view('admin.menu.createMenu');
    }

    public function storeMenu(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'gambar' => 'image|file|max:5120|mimes:jpeg,png,jpg',
        ]);

        if($request->file('gambar')){
            $image = $request->file('gambar');
            $imageName = Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar-menu'), $imageName);
            $validatedData['gambar'] = 'gambar-menu/' . $imageName;
        }

        Menu::create($validatedData);

        return redirect('/admin/menu')->with('success', 'Berhasil Menambahkan Menu Baru');
    }

    public function editMenu(Menu $menu)
    {
        $menu = Menu::findOrFail($menu->id);

        return view('admin.menu.editMenu', compact([
            'menu',
        ]));
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
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
            $imageName = Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar-menu'), $imageName);
            $validatedData['gambar'] = 'gambar-menu/' . $imageName;
        }

        $menu->update($validatedData);

        return redirect('/admin/menu')->with('success', 'Berhasil Mengedit Menu');
    }

    public function destroyMenu(Menu $menu)
    {
        $menu = Menu::findOrFail($menu->id);
        $menu->delete();

        return redirect('/admin/menu')->with('success', 'Berhasil Menghapus Menu');
    }
    // TEACHER END
}
