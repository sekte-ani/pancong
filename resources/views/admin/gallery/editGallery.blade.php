@extends('admin.layouts.index', ['title' => 'Gallery', 'page_heading' => 'Update Gallery'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
    @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.updateGallery', ['id' => $gallery->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" autofocus value="{{ old('judul', $gallery->judul) }}" name="judul" id="title" placeholder="Masukkan judul tulisan Anda" class="form-control @error('judul') is-invalid @enderror">
              @error('judul')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="book_cover" class="form-label">Foto</label>

              @if (!empty($gallery->gambar))
              <input type="hidden" name="oldImage" value="{{ $gallery->gambar }}">
              <img src="{{ asset($gallery->gambar) }}"  class="img-preview img-fluid mb-3 col-sm-5 d-block">
              @else
              <img class="img-preview img-fluid mb-3 col-sm-5">
              @endif
              <input class="form-control @error('gambar') is-invalid @enderror" onchange="previewImage()" type="file" id="img" name="gambar" accept="image/png, image/jpg, image/jpeg" >
              @error('gambar')
                {{ $message }}
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
            <a class="btn btn-danger" href="{{ route('admin.gallery') }}">Back</a>
        </form>
    </div>
  </div>
</section>
<script>
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



