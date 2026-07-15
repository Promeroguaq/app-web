<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo App - @yield('title', 'Inicio')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500;600;700;900&family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Reset y Variables */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* Colors */
            --sidebar-bg: #0f2d1a;
            --sidebar-active: #10b981;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-text-inactive: rgba(255,255,255,0.6);
            --sidebar-text-active: white;
            
            --topbar-bg: rgba(255,255,255,0.8);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-foreground: #0f172a;
            
            --card-bg: white;
            --card-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --card-shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            
            --badge-bg: rgba(255,255,255,0.9);
            --star-color: #f59e0b;
            
            /* Spacing */
            --sidebar-width: 224px;
            --topbar-height: 56px;
            --content-padding-mobile: 16px;
            --content-padding-desktop: 32px;
            --max-content-width: 1280px;
            
            /* Transitions */
            --transition-fast: 150ms;
            --transition-normal: 300ms;
            --transition-slow: 500ms;
        }
        
        /* Tipografía */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        .font-serif {
            font-family: 'Fraunces', serif;
        }
        
        .font-sans {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Escalas de texto */
        .text-xs { font-size: 0.75rem; line-height: 1rem; } /* 10-12px */
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; } /* 14px */
        .text-base { font-size: 1rem; line-height: 1.5rem; } /* 16px */
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; } /* 18px */
        .text-2xl { font-size: 1.5rem; line-height: 2rem; } /* 24px */
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; } /* 30px */
        .text-5xl { font-size: 3rem; line-height: 1; } /* 48px */
        .text-6xl { font-size: 3.75rem; line-height: 1; } /* 60px */
        
        /* Layout General */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 50;
            transform: translateX(0);
            transition: transform var(--transition-normal) ease;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        
        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: #10b981;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .sidebar-logo-name {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
        }
        
        .sidebar-menu {
            padding: 16px 0;
        }
        
        .sidebar-menu-item {
            display: block;
            width: 100%;
            padding: 12px 20px;
            color: var(--sidebar-text-inactive);
            text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all var(--transition-normal);
            position: relative;
        }
        
        .sidebar-menu-item:hover {
            color: var(--sidebar-text-active);
            background: var(--sidebar-hover);
        }
        
        .sidebar-menu-item.active {
            color: var(--sidebar-text-active);
            background: var(--sidebar-active);
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.06);
        }
        
        .sidebar-menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        
        /* TopBar */
        .topbar {
            height: var(--topbar-height);
            background: var(--topbar-bg);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background var(--transition-fast);
        }
        
        .mobile-menu-toggle:hover {
            background: rgba(0,0,0,0.05);
        }
        
        .topbar-title {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }
        
        .content-wrapper {
            flex: 1;
            padding: var(--content-padding-mobile);
            max-width: var(--max-content-width);
            margin: 0 auto;
            width: 100%;
        }
        
        /* Sistema de Tarjetas */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow-sm);
            transition: all var(--transition-normal);
            cursor: pointer;
            position: relative;
        }
        
        .card:hover {
            box-shadow: var(--card-shadow-xl);
            transform: translateY(-4px);
        }
        
        .card-group {
            transition: all var(--transition-normal);
        }
        
        .card-group:hover .card-image img {
            transform: scale(1.05);
        }
        
        .card-image {
            position: relative;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }
        
        .card-gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 100%);
        }
        
        .card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--badge-bg);
            color: var(--text-foreground);
            border-radius: 9999px;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(8px);
        }
        
        .card-rating {
            position: absolute;
            bottom: 12px;
            right: 12px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(0,0,0,0.3);
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .card-rating .star {
            color: var(--star-color);
        }
        
        .card-content {
            padding: 20px;
        }
        
        .card-title {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1.3;
        }
        
        .card-description {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 12px;
        }
        
        .card-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        /* Grid System */
        .grid-2x4 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .grid-4-cols {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .grid-responsive {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }
        
        /* Hero Section */
        .hero {
            height: 440px;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 40px;
        }
        
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
            color: white;
        }
        
        .hero-title {
            font-family: 'Fraunces', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.1;
        }
        
        .hero-stats {
            display: flex;
            gap: 24px;
            margin-top: 24px;
        }
        
        .stat-pill {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Buttons */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--sidebar-active);
            color: white;
        }
        
        .btn-primary:hover {
            background: #059669;
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: var(--text-primary);
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        
        /* Search and Filters */
        .search-bar {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            transition: border-color var(--transition-fast);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--sidebar-active);
        }
        
        .filter-select {
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            background: white;
            cursor: pointer;
            transition: border-color var(--transition-fast);
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--sidebar-active);
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 45;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }
            
            .main-content {
                margin-left: 200px;
            }
            
            .grid-4-cols {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 10px 0 30px rgba(0,0,0,0.5);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .mobile-overlay.show {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: var(--content-padding-mobile);
            }
            
            .mobile-menu-toggle {
                display: block;
                font-size: 1.5rem;
                padding: 0.75rem;
                background: rgba(255,255,255,0.9);
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            
            .grid-2x4 {
                grid-template-columns: 1fr;
            }
            
            .grid-4-cols {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-stats {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .topbar {
                padding: 0 1rem;
            }
            
            .topbar-title {
                font-size: 1.25rem;
            }
            
            .card {
                border-radius: 16px;
            }
            
            .card-content {
                padding: 1.25rem;
            }
        }
        
        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                max-width: 280px;
            }
            
            .grid-4-cols {
                grid-template-columns: 1fr;
            }
            
            .grid-2x4 {
                grid-template-columns: 1fr;
            }
            
            .hero {
                height: 350px;
                border-radius: 16px;
            }
            
            .hero-content {
                padding: 1.5rem 1rem;
            }
            
            .hero-title {
                font-size: 1.5rem;
                line-height: 1.2;
            }
            
            .hero-stats {
                gap: 8px;
            }
            
            .stat-badge {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
            
            .content-wrapper {
                padding: 1rem 0.75rem;
            }
            
            .topbar {
                height: 56px;
                padding: 0 0.75rem;
            }
            
            .topbar-title {
                font-size: 1.125rem;
            }
            
            .card {
                border-radius: 12px;
            }
            
            .card-content {
                padding: 1rem;
            }
            
            .card-title {
                font-size: 1.125rem;
            }
            
            .card-description {
                font-size: 0.875rem;
            }
            
            .sidebar-header {
                padding: 1.5rem;
            }
            
            .sidebar-logo {
                font-size: 1.25rem;
            }
            
            .nav-item {
                padding: 0.875rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        @media (min-width: 769px) {
            .content-wrapper {
                padding: var(--content-padding-desktop);
            }
        }
    </style>
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">🗺</div>
                    <div class="sidebar-logo-name">TurismoApp</div>
                </div>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="sidebar-menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="/destinos" class="sidebar-menu-item {{ request()->is('destinos*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i>
                    Destinos
                </a>
                <a href="/actividades" class="sidebar-menu-item {{ request()->is('actividades*') ? 'active' : '' }}">
                    <i class="fas fa-hiking"></i>
                    Actividades
                </a>
                <a href="/gastronomia" class="sidebar-menu-item {{ request()->is('gastronomia*') ? 'active' : '' }}">
                    <i class="fas fa-utensils"></i>
                    Gastronomía
                </a>
                <a href="/departamentos" class="sidebar-menu-item {{ request()->is('departamentos*') ? 'active' : '' }}">
                    <i class="fas fa-map"></i>
                    Departamentos
                </a>
                <a href="/rutas" class="sidebar-menu-item {{ request()->is('rutas*') ? 'active' : '' }}">
                    <i class="fas fa-route"></i>
                    Rutas
                </a>
                <a href="/categorias" class="sidebar-menu-item {{ request()->is('categorias*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    Categorías
                </a>
                <a href="{{ route('configuracion') }}" class="sidebar-menu-item {{ request()->is('configuracion*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
            </nav>
        </aside>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- TopBar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="topbar-right">
                    <div class="user-avatar">🧑‍💼</div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (mobileMenuToggle && sidebar && mobileOverlay) {
            mobileMenuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                mobileOverlay.classList.toggle('show');
            });

            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('show');
            });

            // Close sidebar when navigating
            document.querySelectorAll('.sidebar-menu-item').forEach(item => {
                item.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                });
            });
        }

        // Fix for Chrome extension message channel errors
        (function() {
            if (typeof chrome !== 'undefined' && chrome.runtime && chrome.runtime.sendMessage) {
                const originalSendMessage = chrome.runtime.sendMessage;
                chrome.runtime.sendMessage = function(...args) {
                    try {
                        const callback = args[args.length - 1];
                        if (typeof callback === 'function') {
                            const wrappedCallback = function(response) {
                                try {
                                    callback(response);
                                } catch (e) {
                                    console.warn('Chrome extension callback error:', e);
                                }
                            };
                            args[args.length - 1] = wrappedCallback;
                        }
                        return originalSendMessage.apply(this, args);
                    } catch (e) {
                        console.warn('Chrome extension sendMessage error:', e);
                        return false;
                    }
                };
            }

            window.addEventListener('error', function(event) {
                if (event.message && (event.message.includes('message channel') || event.message.includes('async response'))) {
                    console.warn('Message channel error handled:', event.message);
                    event.preventDefault();
                    event.stopPropagation();
                    return true;
                }
            }, true);

            window.addEventListener('unhandledrejection', function(event) {
                if (event.reason && event.reason.message && 
                    (event.reason.message.includes('message channel') || event.reason.message.includes('async response'))) {
                    console.warn('Promise rejection handled:', event.reason.message);
                    event.preventDefault();
                    return true;
                }
            }, true);
        })();
    </script>
</body>
</html>
