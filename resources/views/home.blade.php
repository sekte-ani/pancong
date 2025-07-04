{{-- source 1 --}}
{{-- source 2 --}}

@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container">
        <div class="row gy-4 justify-content-center justify-content-lg-between">
          <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Mau Pancong Apa Hari ini?</h1>
            <p data-aos="fade-up" data-aos-delay="100">Kreasikan pancong lumer-mu bersama kami!</p>
            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
              <a href="#book-a-table" class="btn-get-started">Bikin Pancong</a>
              {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>BEST SELLER!</span></a> --}}
              {{-- <a href="{{ route('bestseller') }}" class="btn-watch-video d-flex align-items-center">
                <i class="bi bi-play-circle"></i><span>BEST SELLER!</span>
              </a> --}}
            </div>
          </div>
          <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section>
    
    </main>
</body>
</html>