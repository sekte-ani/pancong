@extends('admin.layouts.index', ['title' => 'Order', 'page_heading' => 'Management Pesanan'])

@section('content')
@include('sweetalert::alert')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Process" {{ request('status') == 'Process' ? 'selected' : '' }}>Process</option>
                        <option value="Ready" {{ request('status') == 'Ready' ? 'selected' : '' }}>Ready</option>
                        <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.order') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>No Meja</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu Pesan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($orders as $o)
                <tr>
                    <td>#{{ $o->id_pesanan }}</td>
                    <td>{{ $o->nama }}</td>
                    <td>{{ $o->no_meja ?? '-' }}</td>
                    <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $o->status == 'Pending' ? 'warning' : 
                            ($o->status == 'Paid' ? 'info' :
                            ($o->status == 'Process' ? 'primary' :
                            ($o->status == 'Ready' ? 'success' : 'secondary')))
                        }}">
                            {{ $o->status }}
                        </span>
                    </td>
                    <td>{{ $o->waktu_pesanan->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.showOrder', $o) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        
                        <form class="d-inline" method="POST" action="{{ route('admin.updateOrderStatus', $o->id_pesanan) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline" style="width: auto;">
                                <option value="Pending" {{ $o->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Paid" {{ $o->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Process" {{ $o->status == 'Process' ? 'selected' : '' }}>Process</option>
                                <option value="Ready" {{ $o->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Done" {{ $o->status == 'Done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>

            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection