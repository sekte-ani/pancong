


@extends('admin.layouts.index', ['title' => 'Message', 'page_heading' => 'Data Message'])


@section('content')
@include('sweetalert::alert')

    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
    {{ session('success') }}
    </div>
    @endif


    <div class="table-responsive">
    @foreach ($message as $item)
		<div class="card border">
			<h5 class="card-header">{{ $item->email }} - <span class="{{ $item->status == '1' ? '' : 'text-danger' }}">{{ $item->status == '1' ? 'Sudah Dibaca' : 'Belum Dibaca' }}</span></h5>
			<div class="card-body">
				<p class="card-text">{{ $item->subject }}</p>
				@if ($item->status == '0')
                    <form action="{{ route('admin.readMessage', ['message' => $item->slug]) }}">
                        @method('put')
                        @csrf
                        <button class="btn btn-primary">Baca Pesan</button>
                    </form>
                @else
                    <a class="btn btn-primary" href='{{ route('admin.showMessage', ['message' => $item->slug])  }}'>Baca Pesan</a>
                @endif
				{{-- <a href="#" class="btn btn-primary">Baca Pesan</a> --}}
			</div>
		</div>
	@endforeach
    </div>
    <div class="d-flex justify-content-center">
            {{ $message->links() }}
        </div>

        <script>
        window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted || 
                                ( typeof window.performance != "undefined" && 
                                    window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
        });
    </script>
@endsection





{{-- @extends('admin.layouts.index', ['title' => 'Message', 'page_heading' => 'Data Message'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

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
                    <th class="col-md-2">Email</th>
                    <th class="col-md-2">Phone</th>
                    <th class="col-sm-3">Message</th>
                    <th class="col-sm-1">Status</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($message as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->phone }}</td>
                    <td>{{ $m->message }}</td>
                    <td>{{ $m->status }}</td>
                    <td>
                        <form class="d-inline" action="{{ route('admin.readMessage', ['message' => $m->slug]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></button>
                        </form>                        
                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteMessage', ['message' => $m->slug]) }}" method="POST">
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
		
		{{ $message->withQueryString()->links() }}
  </div>
</div>

</section>
@endsection

 --}}
