@include('layouts.navbar')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Kami - Pancong Lumer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section {
            background: #ffffff;
            color: white;
            padding: 60px 0 30px;
        }
        
        .location-card {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border: none;
            overflow: hidden;
            margin-bottom: 20px;
            height: auto;
        }
        
        .location-card:hover {
            transform: translateY(-3px);
        }
        
        .location-header {
            color: white;
            padding: 15px;
            position: relative;
        }
        
        .location-header h4 {
            color: #ffffff;
            font-size: 1.3rem;
            margin-bottom: 8px;
        }
        
        .map-container {
            height: 180px;
            background: #f8f9fa;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .map-container i {
            font-size: 2rem !important;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .contact-icon {
            width: 32px;
            height: 32px;
            background: #ce1212;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .contact-icon i {
            font-size: 14px;
        }
        
        .contact-item div {
            font-size: 0.9rem;
            line-height: 1.3;
        }
        
        .contact-item strong {
            display: block;
            margin-bottom: 2px;
        }
        
        .hours-table {
            font-size: 0.8rem;
            margin-top: 8px;
        }
        
        .hours-table td {
            padding: 4px 8px;
        }
        
        .hours-table .today {
            background: #e3f2fd;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .location-card {
                margin-bottom: 15px;
            }
            
            .map-container {
                height: 150px;
            }
            
            .hero-section {
                padding: 40px 0 20px;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">📍 Lokasi Kami</h1>
            <p class="lead mb-0">Temukan outlet Pancong Lumer terdekat!</p>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="row">
                @foreach($stores as $index => $store)
                <div class="col-lg-6 col-xl-6">
                    <div class="location-card card">
                        <div class="location-header text-center" style="background: linear-gradient(45deg, {{ $store['color'] }}, {{ $store['color'] }}99);">
                            <h4 class="mb-2">🏪 {{ $store['name'] }}</h4>
                        </div>
                        
                        <div class="card-body p-3">
                            <div class="map-container" onclick="openMaps({{ $store['latitude'] }}, {{ $store['longitude'] }}, '{{ addslashes($store['address']) }}')">
                                <div class="d-flex align-items-center justify-content-center h-100 flex-column text-muted">
                                    <i class="bi bi-geo-alt-fill" style="color: {{ $store['color'] }};"></i>
                                    <p class="mt-1 mb-0 small">Klik untuk Google Maps</p>
                                </div>
                            </div>
                            
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div>
                                        <strong>Alamat</strong>
                                        {{ $store['address'] }}
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div>
                                        <strong>Telepon</strong>
                                        <a href="tel:{{ $store['phone'] }}" class="text-decoration-none" style="color:#000000;">{{ $store['phone'] }}</a>
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div>
                                        <strong>Jam Operasional</strong>
                                        @php
                                            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                            $today = date('w');
                                            
                                            $hasDetailedHours = isset($store['detailed_hours']);
                                        @endphp
                                        <table class="table table-sm hours-table">
                                            @foreach($days as $index => $day)
                                                @php
                                                    $dayHours = $store['detailed_hours'][$index];
                                                    $isToday = $index === $today;
                                                    
                                                    $currentHour = date('H');
                                                    $openHour = (int) substr($dayHours['open'], 0, 2);
                                                    $closeHour = (int) substr($dayHours['close'], 0, 2);
                                                    $isOpenNow = $isToday && $currentHour >= $openHour && $currentHour < $closeHour;
                                                @endphp
                                                <tr class="{{ $isToday ? 'today fw-bold' : '' }}">
                                                    <td style="width: 10%">
                                                        {{ $day }}
                                                    </td>
                                                    <td>
                                                        {{ $dayHours['open'] }} - {{ $dayHours['close'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        function openMaps(lat, lng, address) {
            if (lat && lng) {
                window.open(`https://www.google.com/maps/search/?api=1&query=${lat},${lng}`, '_blank');
            } else {
                window.open(`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`, '_blank');
            }
        }
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>