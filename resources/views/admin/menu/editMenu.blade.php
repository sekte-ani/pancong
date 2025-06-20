@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Update Menu'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.updateMenu', ['id' => $menu->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
            {{-- Title --}}
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" autofocus value="{{ old('nama', $menu->nama) }}" name="nama" id="name" placeholder="Masukkan nama menu" class="form-control @error('nama') is-invalid @enderror">
              @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

            </div>
            {{-- Slug --}}
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" name="slug" id="slug" placeholder="Slug akan digenerate.." value="{{ old('slug', $menu->slug) }}" readonly class="form-control @error('slug') is-invalid @enderror" id="slug" required>
              @error('slug')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            {{-- Article Cover --}}
            <div class="mb-3">
              <label for="img" class="form-label">Gambar Menu</label>
              @if (!empty($menu->gambar))
              <input type="hidden" name="oldImage" value="{{ $menu->gambar }}">
              <img src="{{ env('STORAGE_URL') .$menu->gambar }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
              @else
              <img class="img-preview img-fluid mb-3 col-sm-5">
              @endif
              <input class="form-control @error('gambar') is-invalid @enderror" onchange="previewImage()" type="file" id="img" name="gambar" accept="image/png, image/jpg, image/jpeg" >
              @error('gambar')
                {{ $message }}
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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

{{-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> --}}
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



