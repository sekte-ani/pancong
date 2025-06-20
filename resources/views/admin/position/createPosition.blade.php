@extends('admin.layouts.index', ['title' => 'Position', 'page_heading' => 'Create Position'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        
		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.storePosition') }}" enctype="multipart/form-data">
            @csrf
            {{-- Title --}}
            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="name" class="form-label">Nama Posisi</label>
              <input type="text" autofocus value="{{ old('name') }}" name="name" id="name" placeholder="Masukkan Nama Posisi" class="form-control @error('name') is-invalid @enderror">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

            <div class="mt-3" style="margin-top: 10px;">
                <button type="submit" class="btn btn-primary">Create</button>
                <a class="btn btn-danger" href="{{ route('admin.position') }}">Back</a>
            </div>
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

@endsection



