@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Menu Data'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		
        <a href="{{ route('admin.createMenu') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">Name</th>
                    <th class="col-md-1">Slug</th>
                    <th class="col-md-3">Deskripsi</th>
                    <th class="col-md-3">Harga Jual</th>
                    <th class="col-sm-1">Img</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($menu as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->nama }}</td>
                <td>{{ $m->slug }}</td>
                <td>{{ $m->deskripsi }}</td>
                <td>{{ $m->harga_jual }}</td>
                <td>
                    @if ($m->gambar)
                        <img src="{{ env('STORAGE_URL') . $m->gambar }}" style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" class="card-img" alt="...">
                    @else
                        <img src="https://picsum.photos/seed/nophoto" style="object-fit: cover; width: 100%; height: 100px; max-width: 200px;" class="card-img" alt="...">
                    @endif
                </td>
                <td>
                    <a href='{{ route('admin.showMenu', ['menu' => $m->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                    <a href="{{ route('admin.editMenu', ['menu' => $m->slug]) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <form class="d-inline" onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" action="{{ route('admin.deleteMenu', ['menu' => $m->slug]) }}" method="POST">
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
		
		{{ $menu->withQueryString()->links() }}
  </div>
</div>

</section>
@endsection


