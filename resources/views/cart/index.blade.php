@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Keranjang Belanja</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container my-2">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-cart3"></i> Keranjang Belanja
                </h2>
            </div>
        </div>

        @if(count($cartItems) > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Items dalam Keranjang ({{ count($cartItems) }})</h5>
                            <button class="btn btn-outline-danger btn-sm" id="clearCartBtn">
                                <i class="bi bi-trash"></i> Kosongkan Keranjang
                            </button>
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                                <div class="row align-items-center border-bottom py-3 cart-item" data-item="{{ $item['id_item'] }}">
                                    <div class="col-md-2">
                                        <img src="{{ $item['gambar'] ? asset('gambar-menu/'.$item['gambar']) : 'https://picsum.photos/seed/pancong/100/100' }}" 
                                            class="img-fluid rounded" alt="{{ $item['nama_item'] }}" style="height: 80px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-0">{{ $item['nama_item'] }}</h6>
                                        <small class="text-muted">{{ $item['kategori'] }}</small>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-0 fw-bold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary btn-sm update-qty" 
                                                    data-item="{{ $item['id_item'] }}" data-action="decrease">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" class="form-control form-control-sm text-center qty-input" 
                                                value="{{ $item['qty'] }}" min="0" max="99" 
                                                data-item="{{ $item['id_item'] }}">
                                            <button class="btn btn-outline-secondary btn-sm update-qty" 
                                                    data-item="{{ $item['id_item'] }}" data-action="increase">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-outline-danger btn-sm remove-item" data-item="{{ $item['id_item'] }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="cartSubtotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Items:</span>
                                <span id="cartItemCount">{{ array_sum(array_column($cartItems, 'qty')) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong id="cartTotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                            </div>
                            
                            <div class="d-grid gap-2">
                                @if(Route::has('checkout'))
                                    <a href="{{ route('checkout') }}" class="btn btn-danger btn-lg" id="checkoutBtn">
                                        <i class="bi bi-credit-card"></i> Checkout
                                    </a>
                                @else
                                    <button class="btn btn-danger btn-lg" onclick="alert('Fitur checkout coming soon!')">
                                        <i class="bi bi-credit-card"></i> Checkout
                                    </button>
                                @endif
                                <a href="{{ route('menu') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                        <h4 class="mt-3">Keranjang Belanja Kosong</h4>
                        <p class="text-muted mb-4">Belum ada item yang ditambahkan ke keranjang</p>
                        <a href="{{ route('menu') }}" class="btn btn-cart-view btn-lg">
                            <i class="bi bi-basket"></i> Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-cart text-primary me-2"></i>
                <strong class="me-auto">Keranjang</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Keranjang berhasil diupdate!
            </div>
        </div>
    </div>

<script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>