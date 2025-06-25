@include('layouts.navbar')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - {{ $companyInfo['name'] }}</title>
    <style>
        .hero-about {
            background: #ffffff;
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-about h1 {
            color: #ce1212;
        }

        .hero-about p {
            color: #000000;
        }
        
        .hero-about::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translateX(-100px) translateY(-100px); }
            100% { transform: translateX(100px) translateY(100px); }
        }
        
        .story-section {
            position: relative;
            padding: 80px 0;
        }
        
        .story-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .stats-counter {
            background: grey;
            color: white;
            padding: 60px 0;
            margin: 80px 0;
            border-radius: 20px;
        }
        
        .stat-item {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            display: block;
        }
    </style>
</head>
<body>
    <section class="hero-about text-center">
        <div class="container position-relative">
            <h1 class="display-3 fw-bold mb-4">🥞 Tentang {{ $companyInfo['name'] }}</h1>
            <p class="lead fs-4 mb-5">{{ $companyInfo['tagline'] }}</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <p class="fs-5">{{ $companyInfo['description'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="story-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="story-card">
                        <h2 class="text-center mb-4">📖 Cerita Kami</h2>
                        <p class="lead text-center mb-4">{{ $companyInfo['story'] }}</p>
                        <p class="text-muted">{{ $companyInfo['story_detail'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="stats-counter">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 stat-item">
                        <span class="stat-number" data-target="{{ $stats['total_customers'] }}">0</span>
                        <p>Pelanggan Setia</p>
                    </div>
                    <div class="col-md-3 stat-item">
                        <span class="stat-number" data-target="{{ $stats['total_orders'] }}">0</span>
                        <p>Pesanan Terlayani</p>
                    </div>
                    <div class="col-md-3 stat-item">
                        <span class="stat-number" data-target="{{ $stats['total_flavors'] }}">0</span>
                        <p>Varian Rasa</p>
                    </div>
                    <div class="col-md-3 stat-item">
                        <span class="stat-number" data-target="{{ $stats['years_experience'] }}">0</span>
                        <p>Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                let current = 0;
                const increment = target / 100;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
            });
        }
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const statsSection = document.querySelector('.stats-counter');
        if (statsSection) {
            observer.observe(statsSection);
        }
        
        setInterval(() => {
            fetch('/api/stats')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('[data-target="{{ $stats['total_customers'] }}"]').setAttribute('data-target', data.total_customers);
                    document.querySelector('[data-target="{{ $stats['total_orders'] }}"]').setAttribute('data-target', data.total_orders);
                    document.querySelector('[data-target="{{ $stats['total_flavors'] }}"]').setAttribute('data-target', data.total_flavors);
                })
                .catch(error => console.log('Error updating stats:', error));
        }, 300000);
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>