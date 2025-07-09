@extends('admin.layouts.index', ['title' => 'Kategori', 'page_heading' => 'Data Kategori'])

@section('content')
@include('sweetalert::alert')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <a href="{{ route('admin.createCategory') }}" class="btn btn-success me-2 py-2">
                + Tambah Kategori
            </a>
            
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th class="col-sm-1">No</th>
                        <th class="col-md-4">Nama Kategori</th>
                        <th class="col-md-2">Jumlah Item</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($categories as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->nama_kategori }}</td>
                    <td>{{ $c->menus->count() }} menu</td>
                    <td>
                        <a href="{{ route('admin.editCategory', $c) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus kategori ini?')" 
                              action="{{ route('admin.deleteCategory', $c) }}" method="POST">
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

            {{ $categories->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection