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
          <li class="dropdown"><a href="#"><span>STORE</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li class="dropdown"><a href="#"><span>DEPOK</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">KRUKUT</a></li>
                  <li><a href="#">SAWANGAN</a></li>
                </ul>
              </li>
              <li><a href="#">COOMING SOON</a></li>
            </ul>
          </li>
          <li class="dropdown d-xl-none">
            <a href="#" class="mobile-cart-link">
              <div class="mobile-cart-info">
                <i class="bi bi-cart3"></i>
                <div class="mobile-cart-text">
                  <span>Keranjang</span>
                  @if(session('cart') && count(session('cart')) > 0)
                    @php $total = 0 @endphp
                    @foreach(session('cart') as $id => $details)
                      @php $total += $details['harga'] * $details['qty'] @endphp
                    @endforeach
                    <small class="mobile-cart-total">Rp {{ number_format($total, 0, ',', '.') }}</small>
                  @else
                    <small class="mobile-cart-total">Kosong</small>
                  @endif
                </div>
              </div>
              <span class="mobile-cart-badge">{{ count((array) session('cart')) }}</span>
              <i class="bi bi-chevron-down toggle-dropdown"></i>
            </a>
            
            <ul class="mobile-cart-dropdown">
              <li>
                <div class="cart-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Keranjang Belanja</span>
                    <span class="badge bg-danger">{{ count((array) session('cart')) }} item</span>
                  </div>
                </div>
              </li>

              @if(session('cart') && count(session('cart')) > 0)
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                  @php $total += $details['harga'] * $details['qty'] @endphp
                  <li>
                    <div class="cart-item">
                      <img src="{{ !empty($details['gambar']) ? url('gambar-menu/'.$details['gambar']) : url('admin/img/nophoto.jpg') }}" 
                           alt="{{ $details['nama_item'] }}" class="cart-item-img">
                      <div class="cart-item-info">
                        <div class="cart-item-name">{{ $details['nama_item'] }}</div>
                        <div class="cart-item-price">Rp {{ number_format($details['harga'], 0, ',', '.') }}</div>
                        <div class="cart-item-quantity">Qty: {{ $details['qty'] }}</div>
                      </div>
                    </div>
                  </li>
                @endforeach

                <li>
                  <div class="cart-total">
                    <div class="cart-total-price">
                      Total: Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('cart') }}" class="btn-cart-view">Lihat Keranjang</a>
                  </div>
                </li>
              @else
                <li>
                  <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <p>Keranjang belanja kosong</p>
                    <a href="{{ route('menu') }}" class="btn-cart-view">Mulai Belanja</a>
                  </div>
                </li>
              @endif
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-actions d-none d-xl-flex">
        <div class="header-cart">
          <a href="#" class="cart-btn">
            <i class="bi bi-cart3"></i>
            <span class="cart-badge">{{ count((array) session('cart')) }}</span>
          </a>
          
          <div class="cart-dropdown">
            <div class="cart-header">
              <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Keranjang Belanja</span>
                <span class="badge bg-danger">{{ count((array) session('cart')) }} item</span>
              </div>
            </div>

            <div class="cart-content">
              @if(session('cart') && count(session('cart')) > 0)
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                  @php $total += $details['harga'] * $details['qty'] @endphp
                  <div class="cart-item">
                    <img src="{{ !empty($details['gambar']) ? url('gambar-menu/'.$details['gambar']) : url('admin/img/nophoto.jpg') }}" 
                         alt="{{ $details['nama_item'] }}" class="cart-item-img">
                    <div class="cart-item-info">
                      <div class="cart-item-name">{{ $details['nama_item'] }}</div>
                      <div class="cart-item-price">Rp {{ number_format($details['harga'], 0, ',', '.') }}</div>
                      <div class="cart-item-quantity">Qty: {{ $details['qty'] }}</div>
                    </div>
                  </div>
                @endforeach

                <div class="cart-total">
                  <div class="cart-total-price">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                  </div>
                  <a href="{{ url('cart') }}" class="btn-cart-view">Lihat Keranjang</a>
                </div>
              @else
                <div class="empty-cart">
                  <i class="bi bi-cart-x"></i>
                  <p>Keranjang belanja kosong</p>
                  <a href="{{ route('menu') }}" class="btn-cart-view">Mulai Belanja</a>
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

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  @include('sweetalert::alert')

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>