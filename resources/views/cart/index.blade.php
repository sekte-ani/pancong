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
                                <div class="row cart-item align-items-center py-3 border-bottom" data-item="{{ $item['id_item'] }}">
                                    <div class="col-md-2 col-3">
                                        @if($item['type'] === 'regular')
                                            <img src="{{ $item['gambar'] ? asset('gambar-menu/'.$item['gambar']) : asset('assets/img/menu/menu-item-2.png') }}" 
                                                class="img-fluid rounded" alt="{{ $item['nama_item'] }}">
                                        @else
                                            <div class="custom-menu-icon bg-light rounded d-flex align-items-center justify-content-center" 
                                                style="width: 80px; height: 80px;">
                                                <i class="bi bi-plus-square text-primary" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-4 col-9">
                                        <h6 class="mb-1">{{ $item['display_name'] ?? $item['nama_item'] }}</h6>
                                        
                                        @if($item['type'] === 'custom')
                                            <small class="text-muted d-block">Custom Menu</small>
                                            <small class="text-muted">{{ $item['base_menu_name'] }}</small>
                                            
                                            @if(!empty($item['selected_addons']))
                                                <div class="mt-1">
                                                    <small class="text-success">Add-ons:</small>
                                                    @foreach($item['selected_addons'] as $addon)
                                                        <span class="badge bg-light text-dark me-1 mb-1">
                                                            {{ $addon['nama_addon'] }} ({{ $addon['qty'] }}x)
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    Base: Rp {{ number_format($item['base_price'], 0, ',', '.') }} | 
                                                    Add-ons: Rp {{ number_format($item['addons_price'], 0, ',', '.') }}
                                                </small>
                                            </div>
                                        @else
                                            <small class="text-muted">{{ $item['kategori'] ?? 'Menu Regular' }}</small>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-2 col-4">
                                        <p class="fw-bold mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="col-md-2 col-4">
                                        <div class="input-group input-group-sm" style="width: 100px;">
                                            <button class="btn btn-outline-secondary qty-btn" type="button" 
                                                    data-action="decrease" data-item="{{ $item['id_item'] }}" data-type="{{ $item['type'] }}">-</button>
                                            <input type="number" class="form-control text-center qty-input" 
                                                value="{{ $item['qty'] }}" min="1" max="99" 
                                                data-item="{{ $item['id_item'] }}" data-type="{{ $item['type'] }}">
                                            <button class="btn btn-outline-secondary qty-btn" type="button" 
                                                    data-action="increase" data-item="{{ $item['id_item'] }}" data-type="{{ $item['type'] }}">+</button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-4">
                                        <p class="fw-bold mb-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                        <button class="btn btn-sm btn-outline-danger remove-item mt-1" 
                                                data-item="{{ $item['id_item'] }}" data-type="{{ $item['type'] }}">
                                            <i class="bi bi-trash"></i> Hapus
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