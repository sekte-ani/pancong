@extends('admin.layouts.index', ['title' => 'Gallery', 'page_heading' => 'Create Gallery'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.storeGallery') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}
            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" autofocus value="{{ old('judul') }}" name="judul" id="title" placeholder="Masukkan judul foto" class="form-control @error('judul') is-invalid @enderror">
              @error('judul')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

            </div>
            {{-- Pictures --}}
            <div class="mb-3">
              <label for="img" class="form-label">Foto</label>
              <img class="img-preview img-fluid mb-3 col-sm-5">
              <input class="form-control @error('gambar') is-invalid @enderror" onchange="previewImage()" type="file" name="gambar" id="img" accept="image/png, image/jpg, image/jpeg" required>
              @error('gambar')
                {{ $message }}
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
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



