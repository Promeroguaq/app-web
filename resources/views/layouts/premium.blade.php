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
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode - Complete Application */
        .dark body {
            background: #0f172a;
            color: #f1f5f9;
        }

        .dark .sidebar {
            background: #1e293b;
            border-right-color: rgba(255,255,255,0.1);
        }

        .dark .main {
            background: #0f172a;
        }

        .dark .bg-white {
            background: #1e293b !important;
        }

        .dark .text-midnight-900,
        .dark .text-gray-700,
        .dark .text-gray-900,
        .dark .text-gray-800 {
            color: #f1f5f9 !important;
        }

        .dark .text-gray-500,
        .dark .text-gray-600 {
            color: #94a3b8 !important;
        }

        .dark .border-gray-200,
        .dark .border-gray-300 {
            border-color: rgba(255,255,255,0.1) !important;
        }

        .dark .bg-gray-50 {
            background: #334155 !important;
        }

        .dark .bg-gray-100 {
            background: #1e293b !important;
        }

        .dark input,
        .dark select,
        .dark textarea {
            background: #334155 !important;
            color: #f1f5f9 !important;
            border-color: rgba(255,255,255,0.1) !important;
        }

        .dark input::placeholder,
        .dark select::placeholder,
        .dark textarea::placeholder {
            color: #94a3b8 !important;
        }

        .dark input:focus,
        .dark select:focus,
        .dark textarea:focus {
            border-color: #10b981 !important;
            outline: none;
        }

        .dark .from-[#07111F],
        .dark .to-[#0B1F2A],
        .dark .to-[#063B32] {
            filter: brightness(1.2);
        }

        .dark .bg-gradient-to-br {
            filter: brightness(1.1);
        }

        /* Comfortable Font Size */
        .font-size-comfortable {
            font-size: 110%;
        }

        .font-size-comfortable p,
        .font-size-comfortable span,
        .font-size-comfortable label,
        .font-size-comfortable h3,
        .font-size-comfortable h4,
        .font-size-comfortable h5,
        .font-size-comfortable h6,
        .font-size-comfortable .text-sm,
        .font-size-comfortable .text-base {
            font-size: 1.1em;
        }

        .font-size-comfortable h1,
        .font-size-comfortable h2 {
            font-size: 1.05em;
        }

        /* Reduce Motion */
        .reduce-motion *,
        .reduce-motion *::before,
        .reduce-motion *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }

        .reduce-motion .sidebar {
            transition: none !important;
        }

        .reduce-motion .sidebar:hover {
            width: 80px !important;
        }

        .reduce-motion .hover:-translate-y-[2px],
        .reduce-motion .hover:shadow-lg {
            transform: none !important;
            box-shadow: none !important;
        }

        .reduce-motion .animate-float {
            animation: none !important;
        }

        .reduce-motion .counter-anim {
            animation: none !important;
        }

        /* Feedback Animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-fade-out {
            animation: fade-out 0.3s ease-out forwards;
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
            max-width: 95px;
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
                max-width: 120px;
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

        /* Categories Dropdown */
        .categories-dropdown {
            width: 100%;
        }

        .categories-toggle {
            width: 100%;
            justify-content: flex-start;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0.75rem;
        }

        .categories-toggle:focus-visible {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        .categories-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding-left: 0.5rem;
        }

        .categories-submenu.open {
            max-height: 1000px;
            transition: max-height 0.5s ease-in;
        }

        .category-group {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .category-group-title {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            padding: 0.25rem 0.75rem 0.25rem 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-item-sub {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            gap: 0.5rem;
            min-height: 36px;
        }

        .nav-item-sub i {
            min-width: 16px;
        }

        .nav-item-sub span {
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .nav-item-sub {
                padding: 0.75rem;
                font-size: 0.875rem;
            }

            .nav-item-sub span {
                font-size: 0.875rem;
            }
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
                width: 72px;
            }

            .sidebar:hover {
                width: 72px;
            }

            /* Collapsed rail mode - icon only */
            .sidebar .nav-label,
            .sidebar .category-group-title,
            .sidebar .nav-item span,
            .sidebar .categories-toggle span,
            .sidebar .categories-toggle .fa-chevron-down {
                display: none;
            }

            .sidebar .nav-item,
            .sidebar .categories-toggle {
                justify-content: center;
                padding: 0.75rem;
            }

            .sidebar .nav-icon-wrapper {
                margin-right: 0;
            }

            .sidebar .categories-submenu {
                display: none;
            }

            .sidebar .categories-toggle:hover .categories-submenu {
                display: block;
                position: absolute;
                left: 72px;
                top: 0;
                width: 220px;
                background: #FCFBF8;
                border-radius: 0 16px 16px 0;
                box-shadow: 4px 0 20px rgba(0,0,0,0.1);
                z-index: 50;
                padding: 1rem;
            }

            .main {
                margin-left: 72px;
            }

            .hero-section {
                height: 60vh;
                min-height: 450px;
            }

            .nav-item {
                min-height: 48px;
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

            <!-- Categorías Dropdown -->
            <div class="categories-dropdown">
                <button
                    type="button"
                    class="nav-item categories-toggle {{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('capitales*') || request()->is('regiones*') || request()->is('puntos-interes*') || request()->is('gastronomia*') || request()->is('agencias') || request()->is('fiestas-y-ferias*') ? 'active' : '' }}"
                    aria-expanded="{{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('capitales*') || request()->is('regiones*') || request()->is('puntos-interes*') || request()->is('gastronomia*') || request()->is('agencias') || request()->is('fiestas-y-ferias*') ? 'true' : 'false' }}"
                    aria-controls="categories-submenu"
                >
                    <div class="nav-icon-wrapper">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <span>Categorías</span>
                    <i class="fas fa-chevron-down text-xs ml-auto transition-transform duration-200 {{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('capitales*') || request()->is('regiones*') || request()->is('puntos-interes*') || request()->is('gastronomia*') || request()->is('agencias') || request()->is('fiestas-y-ferias*') ? 'rotate-180' : '' }}"></i>
                </button>

                <div
                    id="categories-submenu"
                    class="categories-submenu {{ request()->is('departamentos*') || request()->is('municipios*') || request()->is('capitales*') || request()->is('regiones*') || request()->is('puntos-interes*') || request()->is('gastronomia*') || request()->is('agencias') || request()->is('fiestas-y-ferias*') ? 'open' : '' }}"
                >
                    <!-- Geográficas -->
                    <div class="category-group">
                        <div class="category-group-title">Geográficas</div>
                        <a href="{{ route('departamentos.index') }}" class="nav-item nav-item-sub {{ request()->is('departamentos*') ? 'active' : '' }}">
                            <i class="fas fa-map text-xs text-gray-400"></i>
                            <span>Departamentos</span>
                        </a>
                        <a href="{{ route('municipios.index') }}" class="nav-item nav-item-sub {{ request()->is('municipios*') ? 'active' : '' }}">
                            <i class="fas fa-city text-xs text-gray-400"></i>
                            <span>Municipios</span>
                        </a>
                        <a href="{{ route('capitales.index') }}" class="nav-item nav-item-sub {{ request()->is('capitales*') ? 'active' : '' }}">
                            <i class="fas fa-building text-xs text-gray-400"></i>
                            <span>Capitales</span>
                        </a>
                        <a href="{{ route('regiones') }}" class="nav-item nav-item-sub {{ request()->is('regiones*') ? 'active' : '' }}">
                            <i class="fas fa-globe-americas text-xs text-gray-400"></i>
                            <span>Regiones</span>
                        </a>
                    </div>

                    <!-- Naturaleza y aventura -->
                    <div class="category-group">
                        <div class="category-group-title">Naturaleza y aventura</div>
                        <a href="{{ route('puntos-interes.islas') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/islas*') ? 'active' : '' }}">
                            <i class="fas fa-umbrella-beach text-xs text-gray-400"></i>
                            <span>Islas</span>
                        </a>
                        <a href="{{ route('puntos-interes.deportes-aventura') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/deportes-aventura*') ? 'active' : '' }}">
                            <i class="fas fa-hiking text-xs text-gray-400"></i>
                            <span>Deportes de aventura</span>
                        </a>
                        <a href="{{ route('puntos-interes.ciclismo') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/ciclismo*') ? 'active' : '' }}">
                            <i class="fas fa-biking text-xs text-gray-400"></i>
                            <span>Ciclismo</span>
                        </a>
                        <a href="{{ route('puntos-interes.termales') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/termales*') ? 'active' : '' }}">
                            <i class="fas fa-hot-tub text-xs text-gray-400"></i>
                            <span>Termales</span>
                        </a>
                        <a href="{{ route('puntos-interes.playas') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/playas*') ? 'active' : '' }}">
                            <i class="fas fa-water text-xs text-gray-400"></i>
                            <span>Playas</span>
                        </a>
                        <a href="{{ route('puntos-interes.reservas-naturales') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/reservas-naturales*') ? 'active' : '' }}">
                            <i class="fas fa-tree text-xs text-gray-400"></i>
                            <span>Reservas naturales</span>
                        </a>
                        <a href="{{ route('puntos-interes.actividades-parques') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/actividades-parques*') ? 'active' : '' }}">
                            <i class="fas fa-campground text-xs text-gray-400"></i>
                            <span>Actividades en parques</span>
                        </a>
                        <a href="{{ route('puntos-interes.desiertos-lagunas') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/desiertos-lagunas*') ? 'active' : '' }}">
                            <i class="fas fa-sun text-xs text-gray-400"></i>
                            <span>Desiertos y lagunas</span>
                        </a>
                    </div>

                    <!-- Cultura -->
                    <div class="category-group">
                        <div class="category-group-title">Cultura</div>
                        <a href="{{ route('puntos-interes.museos') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/museos*') ? 'active' : '' }}">
                            <i class="fas fa-landmark text-xs text-gray-400"></i>
                            <span>Museos</span>
                        </a>
                        <a href="{{ route('puntos-interes.iglesias') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/iglesias*') ? 'active' : '' }}">
                            <i class="fas fa-church text-xs text-gray-400"></i>
                            <span>Iglesias</span>
                        </a>
                        <a href="{{ route('puntos-interes.parques-tematicos') }}" class="nav-item nav-item-sub {{ request()->is('puntos-interes/parques-tematicos*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt text-xs text-gray-400"></i>
                            <span>Parques temáticos</span>
                        </a>
                        <a href="{{ route('fiestas-ferias.index') }}" class="nav-item nav-item-sub {{ request()->is('fiestas-y-ferias*') ? 'active' : '' }}">
                            <i class="fas fa-music text-xs text-gray-400"></i>
                            <span>Fiestas y ferias</span>
                        </a>
                    </div>

                    <!-- Sabores y servicios -->
                    <div class="category-group">
                        <div class="category-group-title">Sabores y servicios</div>
                        <a href="{{ route('gastronomia') }}" class="nav-item nav-item-sub {{ request()->is('gastronomia*') ? 'active' : '' }}">
                            <i class="fas fa-utensils text-xs text-gray-400"></i>
                            <span>Gastronomía</span>
                        </a>
                        <a href="{{ route('agencias') }}" class="nav-item nav-item-sub {{ request()->is('agencias') ? 'active' : '' }}">
                            <i class="fas fa-briefcase text-xs text-gray-400"></i>
                            <span>Agencias</span>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('configuracion') }}" class="nav-item {{ request()->is('configuracion*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-cog"></i>
                </div>
                <span>Configuración</span>
            </a>
        </nav>

        <!-- Lema editorial inferior -->
        <div class="mt-auto px-3 pb-6">
            <div class="relative">
                <!-- Línea decorativa -->
                <div class="h-px bg-slate-200 mb-3"></div>
                <!-- Lema principal -->
                <p class="text-xs font-medium tracking-wide leading-relaxed text-slate-600 text-center">
                    Colombia se descubre paso a paso
                </p>
                <!-- Decoración minimalista de puntos de ruta -->
                <div class="flex justify-center gap-1 mt-2 opacity-30">
                    <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                    <div class="w-1 h-1 rounded-full bg-slate-400"></div>
                    <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                </div>
            </div>
        </div>
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
        // Mobile menu with sessionStorage persistence
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const STORAGE_KEY = 'rutas-colombia.mobile-sidebar-open';

        // Restore sidebar state from sessionStorage on page load
        function restoreSidebarState() {
            const wasOpen = sessionStorage.getItem(STORAGE_KEY) === 'true';
            if (wasOpen && window.innerWidth <= 768) {
                sidebar.classList.add('show');
                mobileOverlay.classList.add('show');
            }
        }

        // Save sidebar state to sessionStorage
        function saveSidebarState(isOpen) {
            sessionStorage.setItem(STORAGE_KEY, isOpen ? 'true' : 'false');
        }

        // Close sidebar (used by overlay, close button, Escape)
        function closeSidebar() {
            sidebar.classList.remove('show');
            mobileOverlay.classList.remove('show');
            saveSidebarState(false);
        }

        // Open sidebar
        function openSidebar() {
            sidebar.classList.add('show');
            mobileOverlay.classList.add('show');
            saveSidebarState(true);
        }

        if (mobileMenuBtn && sidebar && mobileOverlay) {
            // Restore state on load
            restoreSidebarState();

            // Toggle sidebar with hamburger button
            mobileMenuBtn.addEventListener('click', () => {
                const isOpen = sidebar.classList.contains('show');
                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            // Close sidebar when clicking overlay
            mobileOverlay.addEventListener('click', closeSidebar);

            // Close sidebar with Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });

            // IMPORTANT: Do NOT close sidebar when clicking nav items
            // Links will navigate naturally, and sidebar state persists via sessionStorage
        }

        // Categories dropdown toggle
        const categoriesToggle = document.querySelector('.categories-toggle');
        const categoriesSubmenu = document.getElementById('categories-submenu');

        if (categoriesToggle && categoriesSubmenu) {
            categoriesToggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = categoriesSubmenu.classList.contains('open');
                categoriesSubmenu.classList.toggle('open');
                categoriesToggle.setAttribute('aria-expanded', !isOpen);
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
