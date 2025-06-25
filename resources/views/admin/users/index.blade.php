@extends('admin.layouts.index', ['title' => 'Kelola Users', 'page_heading' => 'Kelola Users'])

@section('content')
<section class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $stats['total_users'] }}</h3>
                        <p class="mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $stats['active_users'] }}</h3>
                        <p class="mb-0">Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $stats['admin_count'] }}</h3>
                        <p class="mb-0">Admin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $stats['new_this_month'] }}</h3>
                        <p class="mb-0">New This Month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('users.index') }}" id="filterForm">
                            <label class="form-label">Cari User</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama, email, username..."
                                   onchange="document.getElementById('filterForm').submit()">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Kontak</th>
                                    <th>Role</th>
                                    <th>Bergabung</th>
                                    <th>Statistik Pesanan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" 
                                                 style="width: 40px; height: 40px; font-weight: bold;">
                                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $user->nama }}</h6>
                                                <small class="text-muted">@{{ $user->username }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $user->email }}</div>
                                        @if($user->no_telepon)
                                            <small class="text-muted">{{ $user->no_telepon }}</small>
                                        @else
                                            <small class="text-warning">Telepon belum diisi</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge" style="background: linear-gradient(45deg, #fd79a8, #fdcb6e); color: white;">
                                                Admin
                                            </span>
                                        @else
                                            <span class="badge" style="background: linear-gradient(45deg, #74b9ff, #0984e3); color: white;">
                                                Customer
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $user->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $user->orders_count }} pesanan</strong><br>
                                        <small class="text-muted">
                                            Rp {{ number_format($user->total_spent ?? 0, 0, ',', '.') }} total
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.show', $user) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($user->role != 'admin' && $user->orders_count == 0)
                                                <form action="{{ route('users.destroy', $user) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <span class="text-muted">
                            Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} user
                        </span>
                        {{ $users->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">Tidak ada user ditemukan</h5>
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection