@extends('admin.layouts.index', ['title' => 'Order', 'page_heading' => 'Management Pesanan'])

@section('content')
@include('sweetalert::alert')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>{{ \App\Models\Order::where('status', 'Pending')->count() }}</h4>
                            <p class="mb-0">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4>{{ \App\Models\Order::where('status', 'Paid')->count() }}</h4>
                            <p class="mb-0">Paid</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>{{ \App\Models\Order::where('status', 'Process')->count() }}</h4>
                            <p class="mb-0">Process</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>{{ \App\Models\Order::where('status', 'Ready')->count() }}</h4>
                            <p class="mb-0">Ready</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Filter Pesanan</h6>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Process" {{ request('status') == 'Process' ? 'selected' : '' }}>Process</option>
                                <option value="Ready" {{ request('status') == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pelanggan</label>
                            <input type="text" name="pelanggan" class="form-control" placeholder="Nama pelanggan..." value="{{ request('pelanggan') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <a href="{{ route('admin.order') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $o)
                    <tr>
                        <td>
                            <strong>#{{ $o->id_pesanan }}</strong>
                            @if($o->no_meja)
                                <br><small class="text-muted">Meja: {{ $o->no_meja }}</small>
                            @endif
                        </td>
                        <td>
                            <div>
                                <strong>{{ $o->user->nama ?? $o->nama }}</strong>
                                @if($o->user->email ?? false)
                                    <br><small class="text-muted">{{ $o->user->email }}</small>
                                @endif
                                @if($o->user->no_telepon ?? false)
                                    <br><small class="text-muted">{{ $o->user->no_telepon }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="order-items-preview">
                                @php
                                    $totalItems = $o->orderItems->count() + $o->customOrderItems->count();
                                @endphp
                                
                                @foreach($o->orderItems->take(2) as $item)
                                    <small class="d-block">{{ $item->menu->nama_item }} ({{ $item->qty }}x)</small>
                                @endforeach
                                
                                @foreach($o->customOrderItems->take(2) as $item)
                                    <small class="d-block text-info">{{ Str::limit($item->display_name, 20) }} ({{ $item->qty }}x)</small>
                                @endforeach
                                
                                @if($totalItems > 2)
                                    <small class="text-muted">+{{ $totalItems - 2 }} item lainnya</small>
                                @endif
                                
                                @if($totalItems == 0)
                                    <small class="text-muted">Tidak ada items</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</strong>
                        </td>
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
                        <td>
                            <div>
                                {{ $o->waktu_pesanan->format('d/m/Y') }}
                                <br><small class="text-muted">{{ $o->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group-vertical" role="group">
                                <a href="{{ route('admin.showOrder', $o) }}" class="btn btn-primary btn-sm mb-1" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>
                                <a href="{{ route('order.quick-print', $o) }}" class="btn btn-sm btn-outline-info" title="Quick Print" onclick="window.open(this.href, 'print-window', 'width=400,height=600'); return false;">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                                <form class="d-inline" method="POST" action="{{ route('admin.updateOrderStatus', $o->id_pesanan) }}" 
                                      onsubmit="return confirm('Update status pesanan #{{ $o->id_pesanan }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" 
                                            style="font-size: 0.8rem;" title="Update Status">
                                        <option value="Pending" {{ $o->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Paid" {{ $o->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="Process" {{ $o->status == 'Process' ? 'selected' : '' }}>Process</option>
                                        <option value="Ready" {{ $o->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                        <option value="Done" {{ $o->status == 'Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <br>Tidak ada pesanan ditemukan
                                @if(request()->hasAny(['status', 'tanggal', 'pelanggan']))
                                    <br><a href="{{ route('admin.order') }}" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bi bi-arrow-clockwise"></i> Reset Filter
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} 
                        dari {{ $orders->total() }} pesanan
                    </div>
                    <div>
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($orders->whereIn('status', ['Pending', 'Paid', 'Process', 'Ready'])->count() > 0)
        setInterval(function() {
            if (!document.hidden) {
                window.location.reload();
            }
        }, 30000);
    @endif
    
    document.querySelectorAll('select[name="status"]').forEach(function(select) {
        select.addEventListener('change', function(e) {
            const orderId = this.closest('form').action.split('/').pop();
            const newStatus = this.value;
            
            if (!confirm(`Update status pesanan #${orderId} menjadi ${newStatus}?`)) {
                e.preventDefault();
                this.selectedIndex = [...this.options].findIndex(opt => opt.hasAttribute('selected'));
            }
        });
    });
});
</script>

@endsection