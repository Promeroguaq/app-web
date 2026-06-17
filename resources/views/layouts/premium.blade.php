<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Descubre Colombia') | Turismo Premium</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: {
                            50: '#faf9f6',
                            100: '#f8f5f0',
                            200: '#f0ebe3',
                            300: '#e8e1d6',
                        },
                        forest: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#10b981',
                            600: '#059669',
                            800: '#065f46',
                            900: '#0f2d1a',
                        },
                        midnight: {
                            900: '#111827',
                            800: '#1f2937',
                        },
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    borderRadius: {
                        '3xl': '24px',
                        '4xl': '32px',
                        '5xl': '40px',
                    },
                    boxShadow: {
                        'premium': '0 10px 40px rgba(0,0,0,0.12)',
                        'premium-lg': '0 20px 60px rgba(0,0,0,0.15)',
                        'cinematic': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                    },
                }
            }
        }
    </script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F7F3EA;
            color: #111827;
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        
        /* Premium Sidebar */
        .sidebar {
            width: 80px;
            min-height: 100vh;
            background: linear-gradient(180deg, #07111F 0%, #081927 50%, #03101A 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            box-shadow: 12px 0 40px rgba(0,0,0,0.25);
            border-right: 1px solid rgba(255,255,255,0.1);
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(37,99,235,0.18), transparent 35%);
            pointer-events: none;
        }
        
        .sidebar:hover {
            width: 240px;
        }
        
        .sidebar-logo {
            width: 80px;
            height: 64px;
            background: white;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2.5rem;
            flex-shrink: 0;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255,255,255,0.6);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        @media (min-width: 768px) {
            .sidebar-logo {
                width: 112px;
                height: 96px;
            }
        }
        
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
            padding: 0 1rem;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 20px;
            color: rgba(255,255,255,0.65) !important;
            text-decoration: none;
            transition: all 0.3s ease-out;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }

        .nav-item i {
            font-size: 1.25rem;
            min-width: 24px;
            text-align: center;
            color: rgba(255,255,255,0.8) !important;
        }

        .nav-item span {
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease-out;
            font-weight: 500;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.75) !important;
        }

        .sidebar:hover .nav-item span {
            opacity: 1;
            transform: translateX(0);
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: white !important;
            transform: translateX(4px);
        }

        .nav-item:hover i {
            color: white !important;
        }

        .nav-item.active {
            background: rgba(255,255,255,0.05);
            color: white !important;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 28px;
            width: 3px;
            background: linear-gradient(to bottom, #67e8f9, #3b82f6);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 14px rgba(59, 130, 246, 0.55);
        }

        .nav-item.active i {
            color: white !important;
        }

        .nav-item.active span {
            opacity: 1;
            transform: translateX(0);
            color: white !important;
        }

        .nav-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 16px;
            background: rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease-out;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .nav-item:hover .nav-icon-wrapper {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.1);
        }

        .nav-item.active .nav-icon-wrapper {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.15), 0 8px 20px rgba(0,0,0,0.22);
        }
        
        /* Main Content */
        .main {
            margin-left: 80px;
            min-height: 100vh;
            background: #f8f5f0;
        }
        
        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 32px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        /* Cinematic Card */
        .cinematic-card {
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .cinematic-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
        }
        
        /* Glass Badge */
        .glass-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Hero Section */
        .hero-section {
            height: 70vh;
            min-height: 500px;
            max-height: 700px;
            border-radius: 32px;
            overflow: hidden;
            position: relative;
            margin-bottom: 3rem;
            width: 100%;
        }
        
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 40%, transparent 100%);
        }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar:hover {
                width: 220px;
            }
            
            .main {
                margin-left: 70px;
            }
            
            .hero-section {
                height: 60vh;
                min-height: 450px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .nav-item {
                color: white !important;
            }

            .nav-item span {
                opacity: 1 !important;
                transform: translateX(0) !important;
            }

            .main {
                margin-left: 0;
                padding: 1rem;
            }

            .hero-section {
                height: auto;
                min-height: 350px;
                max-height: 500px;
                border-radius: 20px;
                margin-bottom: 1.5rem;
            }

            .glass-card, .cinematic-card {
                border-radius: 20px;
            }

            .glass-badge {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                height: 45vh;
                min-height: 350px;
                border-radius: 20px;
            }
            
            .main {
                padding: 1rem;
            }
            
            .glass-card, .cinematic-card {
                border-radius: 20px;
            }
            
            .sidebar {
                width: 100%;
                border-radius: 0;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
            z-index: 1001;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex;
                bottom: 5rem;
            }
        }

        @media (max-width: 480px) {
            .mobile-menu-btn {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
                bottom: 4.5rem;
            }
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .mobile-overlay.show {
            display: block;
        }

        /* Hide scrollbar for horizontal scroll */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/logo.JPG') }}" alt="Rutas por Colombia" class="w-[90%] h-[90%] object-contain object-center">
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}" style="color: white !important;">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-home" style="color: white !important;"></i>
                </div>
                <span style="color: white !important;">Inicio</span>
            </a>
            <a href="/departamentos" class="nav-item {{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('puntos-interes*') || request()->is('playas*') ? 'active' : '' }}" style="color: white !important;">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-map-marked-alt" style="color: white !important;"></i>
                </div>
                <span style="color: white !important;">Destinos</span>
            </a>
            <a href="/categorias" class="nav-item {{ request()->is('categorias*') ? 'active' : '' }}" style="color: white !important;">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-th-large" style="color: white !important;"></i>
                </div>
                <span style="color: white !important;">Categorías</span>
            </a>
            <a href="/eventos" class="nav-item {{ request()->is('eventos*') || request()->is('fiestas*') ? 'active' : '' }}" style="color: white !important;">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-calendar-alt" style="color: white !important;"></i>
                </div>
                <span style="color: white !important;">Eventos</span>
            </a>
            <a href="/alojamiento" class="nav-item {{ request()->is('alojamiento*') || request()->is('hoteles*') ? 'active' : '' }}" style="color: white !important;">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-bed" style="color: white !important;"></i>
                </div>
                <span style="color: white !important;">Alojamiento</span>
            </a>
        </nav>
    </aside>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <main class="main">
        <div class="w-full max-w-full overflow-x-hidden px-3 sm:px-4 md:px-8 lg:px-14 py-4 sm:py-6 md:py-10 lg:py-14">
            @yield('content')
        </div>
    </main>

    <script>
        // Mobile menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (mobileMenuBtn && sidebar && mobileOverlay) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                mobileOverlay.classList.toggle('show');
            });

            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('show');
            });

            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                });
            });
        }

        // Animate elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.cinematic-card, .glass-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>
