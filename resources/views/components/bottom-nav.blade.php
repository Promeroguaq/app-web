<!-- Navegación Inferior Móvil -->
<nav class="bottom-nav" style="position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); padding: 8px 0; z-index: 999; display: none;">
  <style>
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: white;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
      padding: 8px 0;
      z-index: 999;
      width: 100%;
      max-width: 100vw;
    }

    .nav-links {
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 0 10px;
      width: 100%;
    }

    .nav-link {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-decoration: none;
      color: #64748b;
      font-size: 10px;
      padding: 6px 8px;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
      min-width: 0;
      flex: 1;
    }

    .nav-link i {
      font-size: 18px;
      margin-bottom: 4px;
      color: #64748b;
    }

    .nav-link.active {
      color: #0d4f3d;
      background: rgba(13, 79, 61, 0.1);
    }

    .nav-link.active i {
      color: #0d4f3d;
    }

    .nav-link:hover {
      color: #0d4f3d;
      transform: translateY(-2px);
    }

    .nav-link:hover i {
      color: #0d4f3d;
    }

    .nav-link span {
      font-size: 9px;
      font-weight: 500;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
      .bottom-nav {
        display: block !important;
      }
    }

    @media (max-width: 480px) {
      .nav-link {
        padding: 4px 6px;
      }

      .nav-link i {
        font-size: 16px;
      }

      .nav-link span {
        font-size: 8px;
      }
    }
  </style>
  
  <div class="nav-links">
    <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
      <i class="fas fa-tachometer-alt"></i>
      <span>Inicio</span>
    </a>
    <a href="/departamentos" class="nav-link {{ request()->is('departamentos*') ? 'active' : '' }}">
      <i class="fas fa-map-marked-alt"></i>
      <span>Destinos</span>
    </a>
    <a href="{{ route('departamentos.index') }}" class="nav-link {{ request()->is('departamentos*') ? 'active' : '' }}">
      <i class="fas fa-th-large"></i>
      <span>Categorías</span>
    </a>
    <a href="{{ route('configuracion') }}" class="nav-link {{ request()->is('configuracion*') ? 'active' : '' }}">
      <i class="fas fa-cog"></i>
      <span>Configuración</span>
    </a>
  </div>
</nav>