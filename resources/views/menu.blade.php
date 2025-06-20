@include('layouts.navbar')

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
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

          <div class="row gy-5">

            <div class="container my-5">
              <div class="row justify-content-center g-4">

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="{{ asset('assets/img/menu/menu-item-2.png') }}" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 2 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 3 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>

                {{-- produk 1 --}}
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                  <div class="card" style="width: 16rem; position: relative;">
                    <img src="assets/img/menu/menu-item-2.png" class="card-img-top" alt="Aut Luia">
                    <div class="card-body p-3">
                      <h6 class="card-title mb-1">Aut Luia</h6>
                      <p class="card-text text-muted small mb-1">
                        Lorem, deren, trataro, filede, nerada
                      </p>
                      <p class="card-text fw-bold small">$14.95</p>
                    </div>
                    <div
                      class="position-absolute bottom-0 end-0 m-2 d-flex align-items-center bg-white rounded-pill shadow-sm px-2 py-1">
                      <button class="btn btn-sm btn-outline-secondary btn-minus px-2 py-0">-</button>
                      <span class="mx-2 count">0</span>
                      <button class="btn btn-sm btn-outline-secondary btn-plus px-2 py-0">+</button>
                      <i class="bi bi-cart ms-2"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Starter Menu Content -->

            <div class="tab-pane fade" id="menu-breakfast">

              <div class="tab-header text-center">
                <p>Menu</p>
                <h3>BIKIN SENDIRI</h3>
              </div>

              <div class="row gy-5">
              </div>
            </div>
          </div>
        </div>
        <script>
          document.querySelectorAll('.card').forEach(card => {
            const minusBtn = card.querySelector('.btn-minus');
            const plusBtn = card.querySelector('.btn-plus');
            const countSpan = card.querySelector('.count');

            let count = 0;

            plusBtn.addEventListener('click', (e) => {
              e.preventDefault();
              count++;
              countSpan.textContent = count;
            });

            minusBtn.addEventListener('click', (e) => {
              e.preventDefault();
              if (count > 0) {
                count--;
                countSpan.textContent = count;
              }
            });
          });
        </script>
      </div>
    </div>
  </section><!-- /Menu Section -->
</body>

</html>