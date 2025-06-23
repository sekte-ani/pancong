@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
  <title>Checkout - Pancong Lumer</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <section class="checkout section" style="margin-top: 120px;">
    <div class="container">
      <div class="section-title text-center mb-5">
        <h2>Checkout Pesanan</h2>
        <p>Review pesanan Anda dan lengkapi data pemesanan</p>
      </div>

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="row">
        <div class="col-lg-8 mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-light">
              <h5 class="mb-0"><i class="bi bi-basket"></i> Review Pesanan</h5>
            </div>
            <div class="card-body">
              @if(!empty($cart))
                <h6 class="text-muted mb-3">Menu Regular</h6>
                @foreach($cart as $item)
                  <div class="row mb-3 border-bottom pb-3">
                    <div class="col-2">
                      <img src="{{ $item['gambar'] ? asset('gambar-menu/' . $item['gambar']) : asset('admin/img/nophoto.jpg') }}" 
                           alt="{{ $item['nama_item'] }}" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                      <h6 class="mb-1">{{ $item['nama_item'] }}</h6>
                      <p class="text-muted mb-0">Qty: {{ $item['qty'] }}</p>
                    </div>
                    <div class="col-4 text-end">
                      <p class="mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                      <p class="fw-bold">Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                  </div>
                @endforeach
              @endif

              @if(!empty($customCart))
                <h6 class="text-muted mb-3 {{ !empty($cart) ? 'mt-4' : '' }}">Pancong Custom</h6>
                @foreach($customCart as $item)
                  <div class="row mb-3 border-bottom pb-3">
                    <div class="col-2">
                      <img src="{{ asset('admin/img/nophoto.jpg') }}" 
                           alt="Custom Pancong" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                      <h6 class="mb-1">{{ $item['display_name'] }}</h6>
                      <p class="text-muted mb-0">Qty: {{ $item['qty'] }}</p>
                      @if(!empty($item['selected_addons']))
                        <small class="text-info">
                          Addons: 
                          @foreach($item['selected_addons'] as $addon)
                            {{ $addon['nama_addon'] }}{{ $addon['qty'] > 1 ? ' ('. $addon['qty'] .'x)' : '' }}{{ !$loop->last ? ', ' : '' }}
                          @endforeach
                        </small>
                      @endif
                    </div>
                    <div class="col-4 text-end">
                      <p class="mb-0">Rp {{ number_format($item['total_price'], 0, ',', '.') }}</p>
                      <p class="fw-bold">Rp {{ number_format($item['total_price'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-light">
              <h5 class="mb-0"><i class="bi bi-person"></i> Data Pemesanan</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                
                <div class="mb-3">
                  <label class="form-label">Nama Pelanggan</label>
                  <input type="text" class="form-control" value="{{ auth()->user()->nama }}" readonly>
                </div>

                <div class="mb-3">
                  <label class="form-label">No. Telepon</label>
                  <input type="text" class="form-control" value="{{ auth()->user()->no_telepon ?? 'Belum diatur' }}" readonly>
                  @if(!auth()->user()->no_telepon)
                    <small class="text-warning">Silakan update no. telepon di profil Anda</small>
                  @endif
                </div>

                <div class="mb-3">
                  <label for="no_meja" class="form-label">No. Meja <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('no_meja') is-invalid @enderror" 
                         id="no_meja" name="no_meja" value="{{ old('no_meja') }}" 
                         placeholder="Contoh: A1, B2, dll" required>
                  @error('no_meja')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="catatan" class="form-label">Catatan (Opsional)</label>
                  <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                           placeholder="Catatan tambahan untuk pesanan...">{{ old('catatan') }}</textarea>
                </div>

                <hr>
                
                <div class="mb-3">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Total Item:</span>
                    <span>{{ $totalItems }} item</span>
                  </div>
                  <div class="d-flex justify-content-between mb-3">
                    <strong>Total Harga:</strong>
                    <strong class="text-danger">Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                  </div>
                </div>

                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-danger btn-lg" id="submitOrderBtn">
                    <i class="bi bi-check-circle"></i> Buat Pesanan
                  </button>
                  <a href="{{ route('cart') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                  </a>
                </div>
              </form>
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
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('submitOrderBtn');
      submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
      submitBtn.disabled = true;
    });
  </script>
</body>
</html>