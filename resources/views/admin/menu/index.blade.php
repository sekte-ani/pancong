@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Data Menu Item'])

@section('content')
@include('sweetalert::alert')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <a href="{{ route('admin.createMenu') }}" class="btn btn-success me-2 py-2">
                + Tambah Menu
            </a>
            
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th class="col-sm-1">No</th>
                        <th class="col-md-2">Nama Item</th>
                        <th class="col-md-2">Kategori</th>
                        <th class="col-md-2">Harga</th>
                        <th class="col-sm-1">Gambar</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($menus as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->nama_item }}</td>
                    <td>{{ $m->category->nama_kategori }}</td>
                    <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($m->gambar)
                            <img src="{{ asset($m->gambar) }}" 
                                 style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" 
                                 class="card-img" alt="...">
                        @else
                            <img src="https://picsum.photos/seed/nophoto" 
                                 style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" 
                                 class="card-img" alt="...">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.showMenu', $m) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="{{ route('admin.editMenu', $m) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus item ini?')" 
                              action="{{ route('admin.deleteMenu', $m) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>

            {{ $menus->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection