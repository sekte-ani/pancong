@extends('admin.layouts.index', ['title' => 'Kategori', 'page_heading' => 'Edit Kategori'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <form method="post" action="{{ route('admin.updateCategory', $category->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" autofocus value="{{ old('nama_kategori', $category->nama_kategori) }}" 
                           name="nama_kategori" id="nama_kategori" 
                           placeholder="Masukkan nama kategori" 
                           class="form-control @error('nama_kategori') is-invalid @enderror">
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-danger" href="{{ route('admin.category') }}">Kembali</a>
            </form>
        </div>
    </div>
</section>
@endsection