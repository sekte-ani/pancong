@extends('admin.layouts.index', ['title' => 'Detail User', 'page_heading' => 'Detail User - ' . $user->nama])

@section('content')
<section class="row">
    <!-- User Info Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                <h5 class="mb-0">👤 Informasi User</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto" 
                         style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                    </div>
                </div>
                
                <table class="table table-borderless table-sm">
                    <tr><td><strong>Nama:</strong></td><td>{{ $user->nama }}</td></tr>
                    <tr><td><strong>Username:</strong></td><td>@{{ $user->username }}</td></tr>
                    <tr><td><strong>Email:</strong></td><td>{{ $user->email }}</td></tr>
                    <tr><td><strong>Telepon:</strong></td><td>{{ $user->no_telepon ?? '-' }}</td></tr>
                    <tr><td><strong>Role:</strong></td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-warning">Admin</span>
                            @else
                                <span class="badge bg-info">Customer</span>
                            @endif
                        </td>
                    </tr>
                    <tr><td><strong>Bergabung:</strong></td><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                </table>
                
                <div class="text-center mt-3">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="col-md-8">
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h4>{{ $userStats['total_orders'] }}</h4>
                        <small>Total Pesanan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h4>Rp {{ number_format($userStats['total_spent'], 0, ',', '.') }}</h4>
                        <small>Total Belanja</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h4>Rp {{ number_format($userStats['average_order'], 0, ',', '.') }}</h4>
                        <small>Rata-rata Order</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body">
                        <h4>{{ $userStats['last_order'] ? $userStats['last_order']->waktu_pesanan->diffForHumans() : 'Belum ada' }}</h4>
                        <small>Order Terakhir</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📦 Pesanan Terakhir</h5>
            </div>
            <div class="card-body">
                @if($user->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders->take(5) as $order)
                                <tr>
                                    <td><strong>#{{ $order->id_pesanan }}</strong></td>
                                    <td>{{ $order->waktu_pesanan->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $order->orderItems->count() + $order->customOrderItems->count() }} item(s)
                                    </td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $order->status == 'Done' ? 'success' : 
                                            ($order->status == 'Process' ? 'primary' : 'warning') 
                                        }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                        <p class="mt-2">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection