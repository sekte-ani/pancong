<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pancong Lumer</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        {{-- <img src="{{ asset('img/logo_pls.png') }}" alt="logo-pancong"> --}}
        {{-- <img src="public/img/logo_pls.png" alt="logo-pancong"> --}}
        <h1 class="sitename">Pancong</h1>
        <span>!</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">HOME</a></li>
          <li><a href="{{ route('menu') }}" class="{{ Route::currentRouteName() == 'menu' ? 'active' : '' }}">MENU</a></li>
          <li><a href="{{ route('gallery') }}" class="{{ Route::currentRouteName() == 'gallery' ? 'active' : '' }}">GALLERY</a></li>
          <li><a href="{{ route('about') }}" class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}">ABOUT</a></li>

          @auth
            <li><a href="{{ route('my.orders') }}" class="{{ request()->routeIs('my.orders*') || request()->routeIs('order.show') ? 'active' : '' }}">
              PESANAN SAYA
              @php
                $activeOrders = \App\Models\Order::where('pelanggan_id', auth()->id())
                                              ->whereIn('status', ['Pending', 'Paid', 'Process', 'Ready'])
                                              ->count();
              @endphp
              @if($activeOrders > 0)
                <span class="badge bg-info ms-1">{{ $activeOrders }}</span>
              @endif
            </a></li>
          @endauth

          <li class="dropdown">
            <a href="#"><span>STORE</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li class="dropdown">
                <a href="#"><span>DEPOK</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul class="w-full">
                  <li>
                    <a href="{{ route('location') }}">
                      <div>
                        <strong>KRUKUT</strong>
                        <small class="d-block text-muted">Jl. Raya Krukut No. 25</small>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('location') }}">
                      <div>
                        <strong>SAWANGAN</strong>
                        <small class="d-block text-muted">Jl. Sawangan Raya No. 88</small>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <hr>
              <li>
                <a href="{{ route('location') }}" class="btn-getstarted text-white text-center justify-content-center">
                  Semua Lokasi
                </a>
              </li>
            </ul>
          </li>
          @php
            $regularCart = session('cart', []);
            $customCart = session('custom_cart', []);

            $totalItems = array_sum(array_column($regularCart, 'qty')) + array_sum(array_column($customCart, 'qty'));

            $totalPrice = 0;
            foreach($regularCart as $item) {
                $totalPrice += $item['harga'] * $item['qty'];
            }
            foreach($customCart as $customItem) {
                $totalPrice += $customItem['total_price'] * $customItem['qty'];
            }

            $hasItems = $totalItems > 0;
          @endphp

          <li class="dropdown d-xl-none">
            <a href="#" class="mobile-cart-link">
              <div class="mobile-cart-info">
                <i class="bi bi-cart3"></i>
                <div class="mobile-cart-text">
                  <span>Keranjang</span>
                  @php 
                    $cart = session('cart', []);
                    $customCart = session('custom_cart', []);
                    $totalRegular = 0;
                    $totalCustom = 0;
                    
                    foreach($cart as $item) {
                      $totalRegular += ($item['harga'] ?? 0) * ($item['qty'] ?? 0);
                    }
                    
                    foreach($customCart as $item) {
                      $totalCustom += ($item['total_price'] ?? 0) * ($item['qty'] ?? 0);
                    }
                    
                    $grandTotal = $totalRegular + $totalCustom;
                    $totalCount = array_sum(array_column($cart, 'qty')) + array_sum(array_column($customCart, 'qty'));
                  @endphp
                  
                  @if($grandTotal > 0)
                    <small class="mobile-cart-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</small>
                  @else
                    <small class="mobile-cart-total">Kosong</small>
                  @endif
                </div>
              </div>
              <span class="mobile-cart-badge">{{ $totalCount }}</span>
              <i class="bi bi-chevron-down toggle-dropdown"></i>
            </a>
            
            <ul class="mobile-cart-dropdown">
              <li>
                <div class="cart-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Keranjang Belanja</span>
                    <span class="badge bg-danger">{{ $totalCount }} item</span>
                  </div>
                </div>
              </li>

              @if($totalCount > 0)
                @foreach($cart as $id => $details)
                  <li>
                    <div class="cart-item">
                      <img src="{{ !empty($details['gambar']) ? url('gambar-menu/'.$details['gambar']) : url('admin/img/nophoto.jpg') }}" 
                           alt="{{ $details['nama_item'] ?? 'Item' }}" class="cart-item-img">
                      <div class="cart-item-info">
                        <div class="cart-item-name">{{ $details['nama_item'] ?? 'Unknown Item' }}</div>
                        <div class="cart-item-price">Rp {{ number_format($details['harga'] ?? 0, 0, ',', '.') }}</div>
                        <div class="cart-item-quantity">Qty: {{ $details['qty'] ?? 0 }}</div>
                      </div>
                    </div>
                  </li>
                @endforeach

                @foreach($customCart as $id => $details)
                  <li>
                    <div class="cart-item">
                      <img src="{{ url('admin/img/custom-pancong.jpg') }}" 
                           alt="{{ $details['display_name'] ?? 'Custom Pancong' }}" class="cart-item-img">
                      <div class="cart-item-info">
                        <div class="cart-item-name">{{ $details['display_name'] ?? 'Custom Pancong' }}</div>
                        <div class="cart-item-price">Rp {{ number_format($details['total_price'] ?? 0, 0, ',', '.') }}</div>
                        <div class="cart-item-quantity">Qty: {{ $details['qty'] ?? 0 }}</div>
                        @if(!empty($details['selected_addons']))
                          <div class="cart-item-addons">
                            <small class="text-muted">
                              Addons: 
                              @foreach(array_slice($details['selected_addons'], 0, 2) as $addon)
                                {{ $addon['nama_addon'] ?? 'Addon' }}{{ !$loop->last ? ', ' : '' }}
                              @endforeach
                              @if(count($details['selected_addons']) > 2)
                                +{{ count($details['selected_addons']) - 2 }} lainnya
                              @endif
                            </small>
                          </div>
                        @endif
                      </div>
                    </div>
                  </li>
                @endforeach

                <li>
                  <div class="cart-total">
                    <div class="cart-total-price">
                      Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('cart') }}" class="btn-cart-view">Lihat Keranjang</a>
                  </div>
                </li>
              @else
                <li>
                  <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <p>Keranjang belanja kosong</p>
                    <a href="{{ route('menu') }}" class="btn-cart-view justify-content-center" style="color: #ffffff;">Mulai Belanja</a>
                  </div>
                </li>
              @endif
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-actions d-none d-xl-flex">
        
        @auth
          <div class="header-orders me-3">
            <a href="{{ route('my.orders') }}" class="orders-btn">
              <i class="bi bi-clock-history"></i>
              @php
                $activeOrders = \App\Models\Order::where('pelanggan_id', auth()->id())
                                              ->whereIn('status', ['Pending', 'Paid', 'Process', 'Ready'])
                                              ->count();
              @endphp
              @if($activeOrders > 0)
                <span class="orders-badge">{{ $activeOrders }}</span>
              @endif
            </a>
          </div>
        @endauth

        <div class="header-cart">
          <a href="#" class="cart-btn">
            <i class="bi bi-cart3"></i>
            <span class="cart-badge">{{ $totalCount }}</span>
          </a>
          
          <div class="cart-dropdown">
            <div class="cart-header">
              <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Keranjang Belanja</span>
                <span class="badge bg-danger">{{ $totalCount }} item</span>
              </div>
            </div>

            <div class="cart-content">
              @if($totalCount > 0)
                @foreach($cart as $id => $details)
                  <div class="cart-item">
                    <img src="{{ !empty($details['gambar']) ? url('gambar-menu/'.$details['gambar']) : url('admin/img/nophoto.jpg') }}" 
                         alt="{{ $details['nama_item'] ?? 'Item' }}" class="cart-item-img">
                    <div class="cart-item-info">
                      <div class="cart-item-name">{{ $details['nama_item'] ?? 'Unknown Item' }}</div>
                      <div class="cart-item-price">Rp {{ number_format($details['harga'] ?? 0, 0, ',', '.') }}</div>
                      <div class="cart-item-quantity">Qty: {{ $details['qty'] ?? 0 }}</div>
                    </div>
                  </div>
                @endforeach

                @foreach($customCart as $id => $details)
                  <div class="cart-item">
                    <img src="{{ url('admin/img/custom-pancong.jpg') }}" 
                         alt="{{ $details['display_name'] ?? 'Custom Pancong' }}" class="cart-item-img">
                    <div class="cart-item-info">
                      <div class="cart-item-name">{{ $details['display_name'] ?? 'Custom Pancong' }}</div>
                      <div class="cart-item-price">Rp {{ number_format($details['total_price'] ?? 0, 0, ',', '.') }}</div>
                      <div class="cart-item-quantity">Qty: {{ $details['qty'] ?? 0 }}</div>
                      @if(!empty($details['selected_addons']))
                        <div class="cart-item-addons">
                          <small class="text-muted">
                            Addons: 
                            @foreach(array_slice($details['selected_addons'], 0, 2) as $addon)
                              {{ $addon['nama_addon'] ?? 'Addon' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                            @if(count($details['selected_addons']) > 2)
                              +{{ count($details['selected_addons']) - 2 }} lainnya
                            @endif
                          </small>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach

                <div class="cart-total">
                  <div class="cart-total-price">
                    Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}
                  </div>
                  <a href="{{ route('cart') }}" class="btn-cart-view">Lihat Keranjang</a>
                </div>
              @else
                <div class="empty-cart">
                  <i class="bi bi-cart-x"></i>
                  <p>Keranjang belanja kosong</p>
                  <a href="{{ route('menu') }}" class="btn-cart-view" style="color: #ffffff;">Mulai Belanja</a>
                </div>
              @endif
            </div>
          </div>
        </div>
        @if (Auth::user())
          <a class="btn-getstarted" href="/logout">Logout</a>
        @else
          <a class="btn-getstarted" href="/login">Login</a>
        @endif
      </div>
    @if (Auth::user())
      <a class="btn-getstarted d-xl-none" href="/logout">Logout</a>
    @else
      <a class="btn-getstarted d-xl-none" href="/login">Login</a>
    @endif
    </div>
  </header>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  @include('sweetalert::alert')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Universal navbar script loaded');
      
      function initMobileNavigation() {
        let mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");
        
        if (!mobileNavToggleBtn) {
          console.warn('Mobile nav toggle button not found');
          return false;
        }
        
        function mobileNavToogle(e) {
          if (e) {
            e.preventDefault();
            e.stopPropagation();
          }
          
          const body = document.querySelector("body");
          if (!body) return;
          
          const isActive = body.classList.contains("mobile-nav-active");
          
          if (isActive) {
            body.classList.remove("mobile-nav-active");
            mobileNavToggleBtn.classList.remove("bi-x");
            mobileNavToggleBtn.classList.add("bi-list");
            body.style.overflow = "";
          } else {
            body.classList.add("mobile-nav-active");
            mobileNavToggleBtn.classList.remove("bi-list");
            mobileNavToggleBtn.classList.add("bi-x");
            body.style.overflow = "hidden";
          }
        }
        
        mobileNavToggleBtn.addEventListener("click", mobileNavToogle);
        mobileNavToggleBtn.addEventListener("touchstart", mobileNavToogle);
        
        document.querySelectorAll("#navmenu a").forEach((navmenu) => {
          navmenu.addEventListener("click", () => {
            if (document.querySelector(".mobile-nav-active")) {
              mobileNavToogle();
            }
          });
        });
        
        return true;
      }
      
      initMobileNavigation();
      
      function initMobileDropdowns() {
        console.log('Initializing mobile dropdowns');
        
        document.querySelectorAll(".navmenu .toggle-dropdown").forEach((element) => {
          element.removeEventListener("click", handleDropdownClick);
        });
        
        document.querySelectorAll(".navmenu .toggle-dropdown").forEach((element) => {
          element.addEventListener("click", handleDropdownClick);
        });
        
        console.log('Found dropdown toggles:', document.querySelectorAll(".navmenu .toggle-dropdown").length);
      }
      
      function handleDropdownClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Dropdown toggle clicked!');
        
        const dropdownItem = this.parentNode;
        const dropdownMenu = this.parentNode.nextElementSibling;
        
        if (dropdownItem && dropdownMenu) {
          dropdownItem.classList.toggle("active");
          dropdownMenu.classList.toggle("dropdown-active");
          
          console.log('Dropdown toggled:', {
            hasActive: dropdownItem.classList.contains("active"),
            hasDropdownActive: dropdownMenu.classList.contains("dropdown-active")
          });
        } else {
          console.warn('Dropdown elements not found:', {
            dropdownItem,
            dropdownMenu
          });
        }
      }
      
      initMobileDropdowns();
      
      setTimeout(initMobileDropdowns, 1000);
    });
  </script>

</body>

</html>