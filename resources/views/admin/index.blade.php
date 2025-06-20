@extends('admin.layouts.index', ['title' => 'Dashboard', 'page_heading' => 'Dashboard - '. auth()->user()->nama])
	

@section('content')
@include('sweetalert::alert')
<section class="row">
    <h1>Halo {{ auth()->user()->nama }}</h1>
</section>




@endsection


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Article</title>
</head>
<body>
    @include('sweetalert::alert')
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-2 p-6 text-right z-10">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            @endauth
        </div>
        <div class="sm:fixed sm:top-0 sm:right-2 p-6 text-right z-10">
            <a href="{{ route('admin.index') }}" class="button btn-primary">Home</a>
            <a href="{{ route('admin.article') }}" class="button btn-primary">Article</a>
            <a href="{{ route('admin.category') }}" class="button btn-primary">Category</a>
            <a href="{{ route('admin.position') }}" class="button btn-primary">Position</a>
            <a href="{{ route('admin.teacher') }}" class="button btn-primary">Teacher</a>
            <a href="{{ route('admin.activity') }}" class="button btn-primary">Activity</a>
            <a href="{{ route('admin.gallery') }}" class="button btn-primary">Album</a>
            <a href="{{ route('admin.employee') }}" class="button btn-primary">Employee</a>
            <a href="{{ route('admin.announce') }}" class="button btn-primary">Announcement</a>
            <a href="{{ route('admin.message') }}" class="button btn-primary">Message</a>
        </div>
    @endif
    <h1>Ini {{ Auth::user()->name }}</h1>
    <hr>
    <h4>Hari Ini: {{ $todayVisits }}</h4><br>
    <h4>Bulan Ini: {{ $monthVisits }}</h4><br>
    <h4>Total Kunjungan: {{ $totalVisits }}</h4><br>
</body>
</html> --}}