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
            background: #FCFBF8;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            box-shadow: 4px 0 24px rgba(0,0,0,0.08);
            border-right: 1px solid rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(16,185,129,0.06), transparent 40%);
            pointer-events: none;
        }
        
        .sidebar:hover {
            width: 240px;
        }
        
        .sidebar-logo {
            width: 100%;
            max-width: 70px;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            flex-shrink: 0;
            padding: 0 0.5rem;
        }

        .sidebar-logo img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        @media (min-width: 768px) {
            .sidebar-logo {
                max-width: 90px;
                margin-bottom: 2.5rem;
            }
        }
        
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
            padding: 0 0.75rem;
        }

        .nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            color: #64748b;
            text-transform: uppercase;
            padding: 0 0.5rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .nav-label {
                font-size: 0.7rem;
                padding: 0 0.75rem;
            }
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 12px;
            color: #334155 !important;
            text-decoration: none;
            transition: all 0.25s ease-out;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
            min-height: 44px;
        }

        .nav-item i {
            font-size: 1.1rem;
            min-width: 20px;
            text-align: center;
            color: #64748b !important;
            transition: color 0.25s ease-out;
        }

        .nav-item span {
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.25s ease-out;
            font-weight: 500;
            font-size: 0.875rem;
            color: #1e293b !important;
        }

        .sidebar:hover .nav-item span {
            opacity: 1;
            transform: translateX(0);
        }

        .nav-item:hover {
            background: #f1f5f9;
            color: #0f172a !important;
            transform: translateX(2px);
        }

        .nav-item:hover i {
            color: #0ea5e9 !important;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #0c4a6e 0%, #1e3a5f 100%);
            color: white !important;
            box-shadow: 0 4px 12px rgba(12, 74, 110, 0.2);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 24px;
            width: 3px;
            background: #10b981;
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.4);
        }

        .nav-item.active i {
            color: rgba(255,255,255,0.9) !important;
        }

        .nav-item.active span {
            opacity: 1;
            transform: translateX(0);
            color: white !important;
        }

        .nav-item:focus-visible {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        .nav-icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.25s ease-out;
        }

        .nav-item:hover .nav-icon-wrapper {
            background: #cbd5e1;
        }

        .nav-item.active .nav-icon-wrapper {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.1);
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

            .nav-item {
                min-height: 40px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                background: #FCFBF8;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .nav-item {
                color: #334155 !important;
            }

            .nav-item span {
                opacity: 1 !important;
                transform: translateX(0) !important;
            }

            .nav-item i {
                color: #64748b !important;
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

            .nav-label {
                opacity: 1;
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
            <img src="{{ asset('assets/logo.JPG') }}" alt="Rutas por Colombia">
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">NAVEGACIÓN</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-home"></i>
                </div>
                <span>Inicio</span>
            </a>
            <a href="/departamentos" class="nav-item {{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('puntos-interes*') || request()->is('playas*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <span>Destinos</span>
            </a>
            <a href="/categorias" class="nav-item {{ request()->is('categorias*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-th-large"></i>
                </div>
                <span>Categorías</span>
            </a>
            <a href="/eventos" class="nav-item {{ request()->is('eventos*') || request()->is('fiestas*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span>Eventos</span>
            </a>
            <a href="/alojamiento" class="nav-item {{ request()->is('alojamiento*') || request()->is('hoteles*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-bed"></i>
                </div>
                <span>Alojamiento</span>
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
