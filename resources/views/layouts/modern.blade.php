<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turismo App - @yield('title', 'Inicio')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* RESET AND BASE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* CORPORATE COLOR PALETTE */
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #64748b;
            --accent: #0ea5e9;
            --warning: #f59e0b;
            --danger: #dc2626;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --border: #cbd5e1;
            
            /* CORPORATE GRADIENTS */
            --gradient-primary: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --gradient-secondary: linear-gradient(135deg, #64748b 0%, #475569 100%);
            --gradient-accent: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            --gradient-warm: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-cool: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            
            /* SPACING */
            --sidebar-width: 280px;
            --header-height: 80px;
            --container-max: 1400px;
            --radius: 20px;
            --radius-sm: 12px;
            --radius-lg: 32px;
            
            /* SHADOWS */
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1), 0 6px 10px rgba(0,0,0,0.08);
            --shadow-xl: 0 20px 40px rgba(0,0,0,0.15), 0 10px 20px rgba(0,0,0,0.1);
            --shadow-2xl: 0 25px 50px rgba(0,0,0,0.25);
            
            /* TRANSITIONS */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: 
                radial-gradient(ellipse at top left, rgba(96, 165, 250, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            background-size: 100% 100%, 100% 100%, 100% 100%;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* TYPOGRAPHY */
        .font-display {
            font-family: 'Inter', sans-serif;
        }
        
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-base { font-size: 1rem; line-height: 1.5rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-5xl { font-size: 3rem; line-height: 1; }
        .text-6xl { font-size: 3.75rem; line-height: 1; }
        .text-7xl { font-size: 4.5rem; line-height: 1; }
        
        /* LAYOUT */
        .app {
            display: flex;
            min-height: 100vh;
            background: var(--light);
        }
        
        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: var(--transition);
            box-shadow: 
                10px 0 30px rgba(0,0,0,0.3),
                inset -2px 0 10px rgba(255,255,255,0.1);
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header {
            padding: 2rem;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 
                inset 0 2px 10px rgba(255,255,255,0.2),
                inset 0 -2px 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 
                0 8px 16px rgba(0,0,0,0.3),
                inset 0 2px 4px rgba(255,255,255,0.3),
                inset 0 -2px 4px rgba(0,0,0,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .logo-text {
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .sidebar-nav {
            padding: 1.5rem 0;
        }
        
        .nav-item {
            display: block;
            padding: 1rem 2rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            margin: 0.25rem 0.5rem;
            border-radius: 12px;
            box-shadow: 
                inset 0 1px 0 rgba(255,255,255,0.1),
                inset 0 -1px 0 rgba(0,0,0,0.1);
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateX(-100%);
            transition: var(--transition);
            border-radius: 2px;
        }
        
        .nav-item:hover {
            color: white;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
            padding-left: 2.5rem;
            box-shadow: 
                0 4px 12px rgba(0,0,0,0.3),
                inset 0 1px 0 rgba(255,255,255,0.2),
                inset 0 -1px 0 rgba(0,0,0,0.2);
            transform: translateX(5px);
        }
        
        .nav-item:hover::before {
            transform: translateX(0);
        }
        
        .nav-item.active {
            color: white;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.3) 0%, rgba(59, 130, 246, 0.2) 100%);
            border-left: 4px solid #60a5fa;
            border-radius: 0 25px 25px 0;
            margin-right: 12px;
            box-shadow: 
                0 4px 12px rgba(0,0,0,0.3),
                inset 0 1px 0 rgba(255,255,255,0.2),
                inset 0 -1px 0 rgba(0,0,0,0.2);
        }
        
        .nav-item i {
            width: 24px;
            margin-right: 1rem;
            text-align: center;
        }
        
        /* MAIN CONTENT */
        .main {
            flex: 1;
            margin-left: var(--sidebar-width);
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.7) 0%, rgba(241, 245, 249, 0.5) 100%);
            backdrop-filter: blur(15px);
            min-height: 100vh;
            box-shadow: 
                inset 5px 0 20px rgba(0,0,0,0.1),
                inset -5px 0 20px rgba(255,255,255,0.05);
        }
        
        /* HEADER */
        .header {
            height: var(--header-height);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(203, 213, 225, 0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 
                0 4px 20px rgba(0,0,0,0.15),
                inset 0 1px 0 rgba(255,255,255,0.9),
                inset 0 -1px 0 rgba(0,0,0,0.1);
        }
        
        .header-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }
        
        /* CONTENT */
        .content {
            padding: 3rem;
            max-width: var(--container-max);
            margin: 0 auto;
        }
        
        /* CARDS */
        .card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(15px);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.2),
                inset 0 2px 4px rgba(255,255,255,0.8),
                inset 0 -2px 4px rgba(0,0,0,0.1);
            transition: var(--transition);
            position: relative;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 
                0 20px 50px rgba(0,0,0,0.3),
                inset 0 2px 4px rgba(255,255,255,0.9),
                inset 0 -2px 4px rgba(0,0,0,0.15);
        }
        
        .card-image {
            position: relative;
            height: 240px;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-slow);
        }
        
        .card:hover .card-image img {
            transform: scale(1.1);
        }
        
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
        }
        
        .card-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--dark);
            box-shadow: var(--shadow-sm);
        }
        
        .card-rating {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(10px);
            padding: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .card-rating .star {
            color: #fbbf24;
        }
        
        .card-content {
            padding: 2rem;
        }
        
        .card-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }
        
        .card-description {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .card-meta {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray);
        }
        
        .card-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* GRID */
        .grid {
            display: grid;
            gap: 2rem;
        }
        
        .grid-2x2 {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .grid-3x3 {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .grid-4x4 {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .grid-auto {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }
        
        /* HERO */
        .hero {
            height: 500px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            margin-bottom: 4rem;
            box-shadow: var(--shadow-2xl);
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
            padding: 4rem;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);
            color: white;
        }
        
        .hero-title {
            font-family: 'Inter', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .stat {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .stat:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        /* BUTTONS */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-secondary {
            background: white;
            color: var(--dark);
            border: 2px solid var(--border);
        }
        
        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        /* MOBILE */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--dark);
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }
        
        .mobile-menu-toggle:hover {
            background: var(--light);
        }
        
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        /* ANIMATIONS */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
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
        
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .grid-4x4 {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .sidebar {
                width: 240px;
            }
            
            .main {
                margin-left: 240px;
            }
        }
        
        @media (max-width: 768px) {
            /* Sidebar móvil */
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 
                    10px 0 30px rgba(0,0,0,0.5),
                    inset -2px 0 10px rgba(255,255,255,0.1);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .mobile-overlay.show {
                display: block;
            }
            
            .main {
                margin-left: 0;
                background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.6) 100%);
            }
            
            .mobile-menu-toggle {
                display: block;
                font-size: 1.5rem;
                padding: 0.75rem;
                background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
                border-radius: 12px;
                box-shadow: 
                    0 4px 12px rgba(0,0,0,0.15),
                    inset 0 1px 0 rgba(255,255,255,0.8);
            }
            
            .content {
                padding: 1.5rem 1rem;
            }
            
            .grid-2x2,
            .grid-3x3,
            .grid-4x4 {
                grid-template-columns: 1fr;
            }
            
            .grid-auto {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-stats {
                flex-wrap: wrap;
                gap: 0.75rem;
            }
            
            .stat {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .header {
                padding: 0 1rem;
                height: 60px;
            }
            
            .header-title {
                font-size: 1.25rem;
            }
            
            /* Ajustar efectos 3D para móvil */
            .card {
                box-shadow: 
                    0 6px 20px rgba(0,0,0,0.15),
                    inset 0 1px 2px rgba(255,255,255,0.8),
                    inset 0 -1px 2px rgba(0,0,0,0.1);
            }
            
            .card:hover {
                transform: translateY(-6px) scale(1.01);
                box-shadow: 
                    0 12px 30px rgba(0,0,0,0.2),
                    inset 0 1px 2px rgba(255,255,255,0.9),
                    inset 0 -1px 2px rgba(0,0,0,0.15);
            }
            
            .nav-item {
                padding: 0.875rem 1.5rem;
                margin: 0.125rem 0.25rem;
            }
            
            .nav-item:hover {
                padding-left: 1.75rem;
            }
        }
        
        @media (max-width: 480px) {
            /* Sidebar más compacto en móvil pequeño */
            .sidebar {
                width: 100%;
                max-width: 280px;
            }
            
            .hero {
                height: 350px;
                border-radius: 16px;
            }
            
            .hero-content {
                padding: 1.5rem 1rem;
            }
            
            .hero-title {
                font-size: 1.75rem;
                line-height: 1.2;
            }
            
            .hero-stats {
                gap: 0.5rem;
            }
            
            .stat {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
                border-radius: 20px;
            }
            
            .content {
                padding: 1rem 0.75rem;
            }
            
            .card {
                border-radius: 16px;
            }
            
            .card-content {
                padding: 1.25rem;
            }
            
            .card-title {
                font-size: 1.25rem;
            }
            
            .card-description {
                font-size: 0.875rem;
            }
            
            .header {
                height: 56px;
                padding: 0 0.75rem;
            }
            
            .header-title {
                font-size: 1.125rem;
            }
            
            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
            
            /* Grid optimizado para móviles pequeños */
            .grid-auto {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            /* Reducir efectos 3D en móviles pequeños para mejor rendimiento */
            .card:hover {
                transform: translateY(-4px);
            }
            
            .sidebar-header {
                padding: 1.5rem;
            }
            
            .logo-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }
            
            .logo-text {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="app">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon"><i class="fas fa-map"></i></div>
                    <div class="logo-text">TurismoApp Colombia</div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="/dashboard" class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Inicio
                </a>
                <a href="/departamentos" class="nav-item {{ request()->is('departamentos*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i>
                    Destinos
                </a>
                <a href="/categorias" class="nav-item {{ request()->is('categorias*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    Categorías
                </a>
                <a href="/agencias" class="nav-item {{ request()->is('agencias*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    Agencias
                </a>
            </nav>
        </aside>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- Main Content -->
        <main class="main">
            <!-- Header -->
            <header class="header">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="header-title">@yield('title', 'Inicio')</h1>
                </div>
                <div class="header-actions">
                    <div class="user-avatar"><i class="fas fa-user"></i></div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Navegación Inferior Móvil -->
    @include('components.bottom-nav')

    <script>
        // Mobile menu
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

            // Close on navigation
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                });
            });
        }

        // Fix Chrome extension errors
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

        // Animations
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Modern design loaded');
            
            // Animate cards on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                        entry.target.style.opacity = '1';
                    }
                });
            });

            document.querySelectorAll('.card').forEach(card => {
                card.style.opacity = '0';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>
