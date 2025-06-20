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
              <label for="title" class="form-label">Title</label>
              <input type="text" autofocus value="{{ old('title') }}" name="title" id="title" placeholder="Masukkan judul tulisan Anda" class="form-control @error('title') is-invalid @enderror">
              @error('title')
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
            {{-- Pictures --}}
            <div class="mb-3">
              <label for="img" class="form-label">Foto Album</label>
              <img class="img-preview img-fluid mb-3 col-sm-5">
              <input class="form-control @error('img') is-invalid @enderror" onchange="previewImage()" type="file" name="img" id="img" accept="image/png, image/gif, image/jpeg, image/webp" required>
              @error('img')
                {{ $message }}
              @enderror
            </div>
            <div class="mb-3">
              <label for="url" class="form-label">Url</label>
              <input type="url" autofocus value="{{ old('url') }}" name="url" id="url" placeholder="Masukkan Link GDrive" class="form-control @error('url') is-invalid @enderror">
              @error('url')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.gallery') }}">Back</a>
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
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function(){
        fetch('/admin/checkSlugTitle?title=' + title.value)
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



