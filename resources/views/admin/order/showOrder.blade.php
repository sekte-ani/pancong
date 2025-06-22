@extends('admin.layouts.index', ['title' => 'Order', 'page_heading' => 'Detail Pesanan'])

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
                    </form>
                </div>
            </div>

            @if($order->catatan)
            <div class="row mb-4">
                <div class="col-12">
                    <h5>Catatan Pesanan:</h5>
                    <p class="bg-light p-3 rounded">{{ $order->catatan }}</p>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h4>Detail Pesanan</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Harga Satuan</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->menu->nama_item }}</strong>
                                    <small class="text-muted d-block">Menu Regular</small>
                                </td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                            @foreach($order->customOrderItems as $customItem)
                            <tr>
                                <td>
                                    <strong>{{ $customItem->display_name }}</strong>
                                    <small class="text-muted d-block">Custom Menu</small>
                                    <div class="mt-1">
                                        <small class="text-info">Base: {{ $customItem->baseMenu->nama_item }}</small>
                                        @if($customItem->selected_addons_details->isNotEmpty())
                                            <div class="mt-1">
                                                <small class="text-success">Add-ons:</small>
                                                @foreach($customItem->selected_addons_details as $addon)
                                                    <span class="badge bg-light text-dark me-1">
                                                        {{ $addon['nama_addon'] }} ({{ $addon['qty'] }}x)
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>Rp {{ number_format($customItem->base_price + $customItem->addons_price, 0, ',', '.') }}</div>
                                    <small class="text-muted">
                                        Base: Rp {{ number_format($customItem->base_price, 0, ',', '.') }}<br>
                                        Add-ons: Rp {{ number_format($customItem->addons_price, 0, ',', '.') }}
                                    </small>
                                </td>
                                <td>{{ $customItem->qty }}</td>
                                <td>Rp {{ number_format($customItem->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <th colspan="3">Total Pesanan</th>
                                <th>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.order') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>
</section>
@endsection