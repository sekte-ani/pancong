@extends('admin.layouts.index', ['title' => 'Message', 'page_heading' => 'Detail Message'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <a class="btn btn-success" href="{{ route('admin.message') }}"><span data-feather="arrow-left"></span>Back to all my messages</a>
            <form class="d-inline" action="{{ route('admin.deleteMessage', ['message' => $message->slug]) }}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Aare you sure?')"><span data-feather="x-circle"></span>Delete</button>
            </form>


            <section class="row mt-5">
                <h5>Email: {{ $message->email }}</h5>
                <h5>Phone: {{ $message->phone }}</h5>
                <p>{{ date('d M Y h:i:sa', $message->created_at->timestamp) }}</p>
                <h5 class="mt-4">Pesan</h5>
                <p class="mb-3 w-50">{{ $message->message }}</p>
            </section>
            <a target="_blank" href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $message->email }}" class="btn btn-primary mb-5 " href="">Balas Pesan</a>
        </div>
    </div>
</div>
@endsection
