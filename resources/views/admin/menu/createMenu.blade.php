@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Insert Menu Data'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeMenu') }}" enctype="multipart/form-data">
        @csrf
            {{-- Nama --}}
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" autofocus value="{{ old('nama') }}" name="nama" id="name" placeholder="Masukkan nama menu" class="form-control @error('nama') is-invalid @enderror">
              @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            {{-- Slug --}}
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="slug" placeholder="Slug akan digenerate.." value="{{ old('slug') }}" readonly class="form-control @error('slug') is-invalid @enderror" id="slug" required>
              @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <input type="text" autofocus value="{{ old('deskripsi') }}" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi menu" class="form-control @error('deskripsi') is-invalid @enderror">
              @error('deskripsi')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="harga_jual" class="form-label">Harga Jual</label>
              <input type="text" autofocus value="{{ old('harga_jual') }}" name="harga_jual" id="harga_jual" placeholder="Masukkan harga menu" class="form-control @error('harga_jual') is-invalid @enderror">
              @error('harga_jual')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="stok" class="form-label">Stok</label>
              <input type="text" autofocus value="{{ old('stok') }}" name="stok" id="stok" placeholder="Masukkan stok menu" class="form-control @error('stok') is-invalid @enderror">
              @error('stok')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            {{-- Menu Image --}}
            <div class="mb-3">
              <label for="img" class="form-label">Gambar Menu</label>
              <img class="img-preview img-fluid mb-3 col-sm-5">
              <input class="form-control @error('gambar') is-invalid @enderror" onchange="previewImage()" type="file" name="gambar" id="img" accept="image/png, image/jpg, image/jpeg" required>
              @error('gambar')
                {{ $message }}
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.menu') }}">Back</a>
        </form>
			
		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>
		{{-- Paginator --}}
		{{-- {{ $data->withQueryString()->links() }} --}}
  </div>
</div>

</section>

<script>
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch('/admin/checkSlugName?name=' + name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });

    function previewImage(){
        const image = document.querySelector('#img');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
          imgPreview.src = oFREvent.target.result;
        }
      }
</script>

@endsection



