@extends('admin.layouts.index', ['title' => 'Gallery', 'page_heading' => 'Data Gallery'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		
        <a href="{{ route('admin.createGallery') }}" class="btn btn-success me-2 py-2" >
            + Insert Data
        </a>
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
        {{ session('success') }}
        </div>
        @endif
		<!-- Table untuk memanggil data dari database -->
		<table class="table">
            <thead>
                <tr>
                    <th class="col-sm-1">No</th>
                    <th class="col-md-2">Judul</th>
                    <th class="col-sm-1">Gambar</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gallery as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->judul }}</td>
                    <td>
                        @if ($a->gambar)
                            <img src="{{ asset($a->gambar) }}" 
                                 style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" 
                                 class="card-img" alt="...">
                        @else
                            <img src="https://picsum.photos/seed/nophoto" style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" class="card-img" alt="...">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.editGallery', $a) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteGallery', $a) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
		</table>
			
	
		<div class="d-flex align-items-end flex-column p-2 mb-2">
		
		</div>
		
		{{ $gallery->withQueryString()->links() }}
  </div>
</div>

</section>
@endsection


