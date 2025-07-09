@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  
  <script>
    window.userAuth = {{ auth()->check() ? 'true' : 'false' }};
    window.loginUrl = "{{ route('login') }}";
    window.cartAddUrl = "{{ route('cart.add') }}";
    window.cartSummaryUrl = "{{ route('cart.summary') }}";
  </script>
</head>

<body>
  <!-- Menu Section -->
  <section id="menu" class="menu section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <p>
        <span>Yuk Pilih Menu!</span><br>
        <span class="description-title">Bisa Buat Kreasi Sendiri Juga Loh!</span>
      </p>
    </div><!-- End Section Title -->

    <div class="container">
      <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <li class="nav-item">
          <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-starters">
            <h4>ALL ITEM</h4>
          </a>
        </li><!-- End tab nav item -->

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-breakfast">
            <h4>BIKIN SENDIRI</h4>
          </a><!-- End tab nav item -->
        </li>
      </ul>

      <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

        <div class="tab-pane fade active show" id="menu-starters">

          <div class="tab-header text-center">
            <p>Menu</p>
            <h3>ALL ITEM</h3>
          </div>

          <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
              <div class="filter-sidebar">
                <div class="sidebar-header">
                  <h6 class="mb-3">
                    <i class="bi bi-funnel me-2"></i>Filter Kategori
                  </h6>
                </div>
                <div class="filter-list">
                  <div class="filter-item active" data-kategori="">
                    <i class="bi bi-grid-3x3-gap me-2"></i>
                    <span>Semua Menu</span>
                    <small class="text-muted ms-auto">({{ $menus->count() }})</small>
                  </div>
                  {{-- @foreach($categories as $c) --}}
                    <div class="filter-item" data-kategori="{{ $categories->id }}">
                      <i class="bi bi-tag me-2"></i>
                      <span>{{ $categories->nama_kategori }}</span>
                      <small class="text-muted ms-auto">({{ $categories->menus_count }})</small>
                    </div>
                  {{-- @endforeach --}}
                </div>
              </div>
            </div>

            <div class="col-lg-9 col-md-8">
              <div class="row gy-4">
                <div class="container-fluid">
                  <div class="row justify-content-start g-3" id="menuGrid">
                    @foreach ($menus as $m)
                      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 menu-item" data-kategori="{{ $m->kategori_id }}" data-name="{{ strtolower($m->nama_item) }}">
                        <div class="card" style="width: 100%; position: relative;" data-menu-id="{{ $m->id_item }}">
                          <img src="{{ $m->gambar ? asset($m->gambar) : asset('assets/img/menu/menu-item-2.png') }}" class="card-img-top" alt="{{ $m->nama_item }}">
                          <div class="card-body p-3" style="padding-bottom: 3.5rem !important;">
                            <h6 class="card-title mb-1">{{ $m->nama_item }}</h6>
                            <p class="card-text text-muted small mb-1">
                              {{ $m->category->nama_kategori }}
                            </p>
                            <p class="card-text fw-bold small mb-0">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                          </div>
                          <div class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                            <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0" data-menu-id="{{ $m->id_item }}">-</button>
                            <span class="mx-2 count" data-menu-id="{{ $m->id_item }}">0</span>
                            <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0" data-menu-id="{{ $m->id_item }}">+</button>
                            <i class="bi bi-cart ms-2 cart-icon" data-menu-id="{{ $m->id_item }}" style="cursor: pointer;"></i>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              <div id="emptyState" class="text-center py-5" style="display: none;">
                <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">Tidak ada menu ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci atau filter kategori</p>
                <button class="btn btn-outline-primary btn-sm" onclick="resetAll()">
                  <i class="bi bi-arrow-clockwise me-1"></i>Reset
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="menu-breakfast">
          <div class="tab-header text-center">
            <p>Menu</p>
            <h3>BIKIN SENDIRI</h3>
          </div>
          
          <div class="row">
            <div class="col-12 mb-4">
              <div class="card">
                <div class="card-header" style="background-color: #ce1212">
                  <h5 class="mb-0 text-white"><i class="bi bi-1-circle me-2"></i>Pilih Pancong Polos</h5>
                </div>
                <div class="card-body">
                  <div class="row" id="baseMenuContainer">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 mb-4">
              <div class="card">
                <div class="card-header" style="background-color: #ce1212">
                  <h5 class="mb-0 text-white"><i class="bi bi-2-circle me-2"></i>Pilih Add-ons (Maksimal 5)</h5>
                </div>
                <div class="card-body">
                  <div class="row" id="addonsContainer">
                  </div>
                  <div class="mt-3">
                    <small class="text-muted">Add-ons terpilih: <span id="selectedAddonsCount">0</span>/5</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 mb-4">
              <div class="card">
                <div class="card-header" style="background-color: #ce1212">
                  <h5 class="mb-0 text-white"><i class="bi bi-3-circle me-2"></i>Konfirmasi Pesanan</h5>
                </div>
                <div class="card-body">
                  <form id="customMenuForm">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="customQty" class="form-label">Jumlah</label>
                          <div class="input-group" style="max-width: 120px;">
                            <button class="btn btn-outline-secondary" type="button" id="qtyMinus">-</button>
                            <input type="number" class="form-control text-center" id="customQty" name="qty" 
                                  value="1" min="1" max="99" required>
                            <button class="btn btn-outline-secondary" type="button" id="qtyPlus">+</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="custom-summary">
                          <h6>Ringkasan Pesanan:</h6>
                          <div id="summaryContent">
                            <p class="text-muted">Pilih base menu terlebih dahulu</p>
                          </div>
                          <hr>
                          <div class="d-flex justify-content-between">
                            <strong>Total: </strong>
                            <strong id="totalPrice">Rp 0</strong>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-12">
                        <button type="submit" class="btn btn-success btn-lg w-100" id="addToCartBtn" disabled>
                          <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Menu Section -->

  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast" role="alert">
      <div class="toast-body" id="toastMessage">Item berhasil ditambahkan!</div>
    </div>
  </div>

  <script>
    window.baseMenus = @json($baseMenus ?? []);
    window.addons = @json($addons ?? []);

    if (window.baseMenus) {
        window.baseMenus.forEach(menu => {
            menu.harga = parseFloat(menu.harga) || 0;
        });
    }

    if (window.addons) {
        window.addons.forEach(addon => {
            addon.harga_addon = parseFloat(addon.harga_addon) || 0;
        });
    }
  </script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script>
    $(document).ready(function() {
      setTimeout(function() {
        
        $('.btn-plus, .btn-minus').off();
        $(document).off('click', '.btn-plus');
        $(document).off('click', '.btn-minus');
        $(document).off('click.quantity', '.btn-plus, .btn-minus');
        
        $(document).on('click.menu-final', '.btn-plus', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          const menuId = $(this).data('menu-id');
          const quantitySpan = $(`.count[data-menu-id="${menuId}"]`);
          const currentQty = parseInt(quantitySpan.text()) || 0;
          
          if (currentQty < 99) {
            quantitySpan.text(currentQty + 1);
            console.log(`📊 Quantity: ${currentQty} → ${currentQty + 1}`);
          }
        });
        
        $(document).on('click.menu-final', '.btn-minus', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          const menuId = $(this).data('menu-id');
          const quantitySpan = $(`.count[data-menu-id="${menuId}"]`);
          const currentQty = parseInt(quantitySpan.text()) || 0;
          
          if (currentQty > 0) {
            quantitySpan.text(currentQty - 1);
            console.log(`📊 Quantity: ${currentQty} → ${currentQty - 1}`);
          }
        });
      }, 500);
    });
  </script>
</body>

</html>