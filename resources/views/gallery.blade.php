@include('layouts.navbar')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Pancong Lumer</title>
    <style>
        .hero-section {
            background: #ffffff;
            color: white;
            padding: 60px 0 40px;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #ce1212;
        }

        .hero-section p {
            color: #000000;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .gallery-section {
            padding: 50px 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .gallery-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .gallery-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .gallery-caption {
            padding: 20px;
            text-align: center;
        }

        .gallery-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }

            .gallery-image {
                height: 200px;
            }

            .gallery-section {
                padding: 30px 0;
            }
        }
    </style>
</head>
<body>
    <section class="hero-section">
        <div class="container">
            <h1>📸 Galeri Kami</h1>
            <p>Koleksi foto Pancong Lumer</p>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container">
            @if($galleries->count() > 0)
                <div class="gallery-grid">
                    @foreach($galleries as $gallery)
                        <div class="gallery-item">
                            <img src="{{ $gallery->gambar ? asset($gallery->gambar) : asset('admin/img/nophoto.jpg') }}" 
                                 alt="{{ $gallery->judul }}" 
                                 class="gallery-image">
                            
                            <div class="gallery-caption">
                                <h3 class="gallery-title">{{ $gallery->judul }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $galleries->withQueryString()->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    <h3>Belum Ada Foto</h3>
                    <p>Galeri masih kosong. Silakan kembali lagi nanti!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house"></i> Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>