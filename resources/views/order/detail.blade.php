@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Detail Pesanan - Pancong Lumer</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <section class="order-detail section">
    <div class="container">
      <div class="section-title text-center mb-5">
        <h2><i class="bi bi-receipt"></i> Detail Pesanan #{{ $order->id_pesanan }}</h2>
        <p>Informasi lengkap pesanan Anda</p>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Pesanan #{{ $order->id_pesanan }}</h4>
        <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="row">
        <div class="col-lg-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-light">
              <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
              <table class="table table-borderless table-sm">
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
                <tr>
                  <td><strong>Waktu Pesanan:</strong></td>
                  <td>{{ $order->waktu_pesanan->format('d F Y') }}, {{ $order->created_at->format('H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Nama:</strong></td>
                  <td>{{ $order->user->nama }}</td>
                </tr>
                <tr>
                  <td><strong>No. Telepon:</strong></td>
                  <td>{{ $order->user->no_telepon ?? '-' }}</td>
                </tr>
                @if($order->no_meja)
                <tr>
                  <td><strong>No. Meja:</strong></td>
                  <td>{{ $order->no_meja }}</td>
                </tr>
                @endif
                @if($order->catatan)
                <tr>
                  <td><strong>Catatan:</strong></td>
                  <td>{{ $order->catatan }}</td>
                </tr>
                @endif
              </table>

              <div class="mt-4">
                <h6>Progress Pesanan</h6>
                <div class="order-timeline">
                  <div class="timeline-item {{ $order->status == 'Pending' ? 'active' : ($order->status != 'Pending' ? 'completed' : '') }}">
                    <i class="bi bi-clock"></i> Pending
                  </div>
                  <div class="timeline-item {{ $order->status == 'Paid' ? 'active' : (in_array($order->status, ['Process', 'Ready', 'Done']) ? 'completed' : '') }}">
                    <i class="bi bi-credit-card"></i> Paid
                  </div>
                  <div class="timeline-item {{ $order->status == 'Process' ? 'active' : (in_array($order->status, ['Ready', 'Done']) ? 'completed' : '') }}">
                    <i class="bi bi-gear"></i> Process
                  </div>
                  <div class="timeline-item {{ $order->status == 'Ready' ? 'active' : ($order->status == 'Done' ? 'completed' : '') }}">
                    <i class="bi bi-check-circle"></i> Ready
                  </div>
                  <div class="timeline-item {{ $order->status == 'Done' ? 'active completed' : '' }}">
                    <i class="bi bi-flag"></i> Done
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-light">
              <h5 class="mb-0">Detail Pesanan</h5>
            </div>
            <div class="card-body">
              @if($order->orderItems->count() > 0)
                <h6 class="text-muted mb-3">Menu Regular</h6>
                @foreach($order->orderItems as $item)
                  <div class="row mb-3 border-bottom pb-3">
                    <div class="col-2">
                      <img src="{{ $item->menu->gambar ? asset($item->menu->gambar) : asset('assets/img/menu/menu-item-2.png') }}" 
                           alt="{{ $item->menu->nama_item }}" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                      <h6 class="mb-1">{{ $item->menu->nama_item }}</h6>
                      <p class="text-muted mb-0">{{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-4 text-end">
                      <h6 class="mb-0">Rp {{ number_format($item->total, 0, ',', '.') }}</h6>
                    </div>
                  </div>
                @endforeach
              @endif

              @if($order->customOrderItems->count() > 0)
                <h6 class="text-muted mb-3 {{ $order->orderItems->count() > 0 ? 'mt-4' : '' }}">Pancong Custom</h6>
                @foreach($order->customOrderItems as $item)
                  <div class="row mb-3 border-bottom pb-3">
                    <div class="col-2">
                      <img src="{{ asset('assets/img/menu/menu-item-2.png') }}" 
                           alt="Custom Pancong" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                      <h6 class="mb-1">{{ $item->display_name }}</h6>
                      <p class="text-muted mb-1">{{ $item->qty }} x Rp {{ number_format(($item->base_price + $item->addons_price), 0, ',', '.') }}</p>
                      @if($item->selected_addons_details->count() > 0)
                        <small class="text-info">
                          Base: {{ $item->baseMenu->nama_item }}<br>
                          Addons: 
                          @foreach($item->selected_addons_details as $addon)
                            {{ $addon['nama_addon'] }}{{ $addon['qty'] > 1 ? ' ('. $addon['qty'] .'x)' : '' }}{{ !$loop->last ? ', ' : '' }}
                          @endforeach
                        </small>
                      @endif
                    </div>
                    <div class="col-4 text-end">
                      <h6 class="mb-0">Rp {{ number_format($item->total_price, 0, ',', '.') }}</h6>
                    </div>
                  </div>
                @endforeach
              @endif

              <div class="row mt-4">
                <div class="col-8"></div>
                <div class="col-4">
                  <div class="border-top pt-3">
                    <div class="d-flex justify-content-between">
                      <strong>Total Pembayaran:</strong>
                      <strong class="text-danger">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    @if($order->status !== 'Done')
      setInterval(function() {
        if (!document.hidden) {
          checkOrderStatus();
        }
      }, 30000);
    @endif

    function checkOrderStatus() {
      $.get('{{ route("order.status", $order->id_pesanan) }}')
        .done(function(response) {
          if (response.success && response.status !== '{{ $order->status }}') {
            location.reload();
          }
        })
        .fail(function() {
          console.log('Failed to check order status');
        });
    }
  </script>
</body>
</html>