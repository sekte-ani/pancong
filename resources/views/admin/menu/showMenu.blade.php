@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Detail Menu Item'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <div class="row">
                <div class="col-md-4">
                    @if ($menu->gambar)
                        <img src="{{ asset('gambar-menu/'.$menu->gambar) }}" 
                             class="img-fluid rounded" alt="{{ $menu->nama_item }}">
                    @else
                        <img src="https://picsum.photos/seed/nophoto/400/300" 
                             class="img-fluid rounded" alt="No Photo">
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $menu->nama_item }}</h3>
                    <p><strong>Kategori:</strong> {{ $menu->category->nama_kategori }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <p><strong>Ditambahkan:</strong> {{ $menu->created_at->format('d F Y, H:i') }}</p>
                    <p><strong>Terakhir Update:</strong> {{ $menu->updated_at->format('d F Y, H:i') }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.editMenu', $menu) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit Item
                        </a>
                        <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection