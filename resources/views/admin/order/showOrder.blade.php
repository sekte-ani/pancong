@extends('admin.layouts.index', ['title' => 'Detail Pesanan', 'page_heading' => 'Detail Pesanan #'.$order->id_pesanan])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Informasi Pesanan</h4>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID Pesanan:</strong></td>
                            <td>#{{ $order->id_pesanan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Pelanggan:</strong></td>
                            <td>{{ $order->user->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Telepon:</strong></td>
                            <td>{{ $order->user->no_telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Meja:</strong></td>
                            <td>{{ $order->no_meja ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Pesanan:</strong></td>
                            <td>{{ $order->waktu_pesanan->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->status == 'Pending' ? 'warning' : 
                                    ($order->status == 'Paid' ? 'info' :
                                    ($order->status == 'Process' ? 'primary' :
                                    ($order->status == 'Ready' ? 'success' : 'secondary')))
                                }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @if($order->catatan)
                        <tr>
                            <td><strong>Catatan:</strong></td>
                            <td>{{ $order->catatan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Update Status</h4>
                    <form method="POST" action="{{ route('admin.updateOrderStatus', $order->id_pesanan) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <select name="status" class="form-control">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Paid" {{ $order->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Process" {{ $order->status == 'Process' ? 'selected' : '' }}>Process</option>
                                <option value="Ready" {{ $order->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Done" {{ $order->status == 'Done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <a href="{{ route('admin.order') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

            <!-- Order Items -->
            <h4>Detail Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Regular Menu Items -->
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->menu->gambar ? asset('gambar-menu/' . $item->menu->gambar) : asset('admin/img/nophoto.jpg') }}" 
                                             alt="{{ $item->menu->nama_item }}" class="me-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 class="mb-0">{{ $item->menu->nama_item }}</h6>
                                            <small class="text-muted">Menu Regular</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <!-- Custom Menu Items -->
                        @foreach($order->customOrderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->menu->gambar ? asset('gambar-menu/' . $item->menu->gambar) : asset('admin/img/nophoto.jpg') }}" 
                                             alt="Custom Pancong" class="me-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 class="mb-0">{{ $item->display_name }}</h6>
                                            <small class="text-muted">Pancong Custom</small>
                                            @if($item->selected_addons_details->count() > 0)
                                                <br><small class="text-info">
                                                    Base: {{ $item->baseMenu->nama_item }}<br>
                                                    Addons: 
                                                    @foreach($item->selected_addons_details as $addon)
                                                        {{ $addon['nama_addon'] }}{{ $addon['qty'] > 1 ? ' ('. $addon['qty'] .'x)' : '' }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format(($item->base_price + $item->addons_price), 0, ',', '.') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <!-- Total -->
                        <tr class="table-warning">
                            <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                            <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection