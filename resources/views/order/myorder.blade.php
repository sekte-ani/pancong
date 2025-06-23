@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Riwayat Pesanan - Pancong Lumer</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <section class="my-orders section">
    <div class="container">
      <div class="section-title text-center mb-5">
        <h2><i class="bi bi-clock-history"></i> Riwayat Pesanan</h2>
        <p>Pantau status pesanan dan lihat riwayat pembelian Anda</p>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Pesanan Saya</h4>
        <a href="{{ route('menu') }}" class="btn btn-danger">
          <i class="bi bi-plus"></i> Pesan Lagi
        </a>
      </div>

      @if($orders->count() > 0)
        @foreach($orders as $order)
          <div class="card mb-3 shadow-sm order-card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-2 col-6">
                  <h6 class="mb-1">Pesanan #{{ $order->id_pesanan }}</h6>
                  <small class="text-muted">{{ $order->waktu_pesanan->format('d M Y, H:i') }}</small>
                </div>
                <div class="col-md-3 col-6">
                  <span class="badge bg-{{ 
                    $order->status == 'Pending' ? 'warning' : 
                    ($order->status == 'Paid' ? 'info' :
                    ($order->status == 'Process' ? 'primary' :
                    ($order->status == 'Ready' ? 'success' : 'secondary')))
                  }}">
                    {{ $order->status }}
                  </span>
                  @if($order->no_meja)
                    <br><small class="text-muted">Meja: {{ $order->no_meja }}</small>
                  @endif
                </div>
                <div class="col-md-4 col-12 mt-2 mt-md-0">
                  <div class="order-items">
                    @foreach($order->orderItems->take(2) as $item)
                      <small class="d-block">{{ $item->menu->nama_item }} ({{ $item->qty }}x)</small>
                    @endforeach
                    @foreach($order->customOrderItems->take(2) as $item)
                      <small class="d-block text-info">{{ $item->display_name }} ({{ $item->qty }}x)</small>
                    @endforeach
                    @if($order->orderItems->count() + $order->customOrderItems->count() > 2)
                      <small class="text-muted">+{{ $order->orderItems->count() + $order->customOrderItems->count() - 2 }} item lainnya</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-2 col-6 text-center">
                  <h6 class="mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h6>
                </div>
                <div class="col-md-1 col-6 text-end">
                  <a href="{{ route('order.show', $order->id_pesanan) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Detail
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
          {{ $orders->withQueryString()->links() }}
        </div>
      @else
        <div class="text-center py-5">
          <i class="bi bi-inbox text-muted" style="font-size: 5rem;"></i>
          <h4 class="mt-3">Belum Ada Pesanan</h4>
          <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan</p>
          <a href="{{ route('menu') }}" class="btn btn-danger btn-lg">
            <i class="bi bi-basket"></i> Mulai Pesan
          </a>
        </div>
      @endif
    </div>
  </section>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>