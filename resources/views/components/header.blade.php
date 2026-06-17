<style>
#header {
  z-index: 1001;
  background: #fff;
  box-shadow: 0 2px 15px rgba(0,0,0,0.1);
  margin: 0;
  padding: 0;
}

/* Ajuste para cuando el sidebar está abierto en móviles */
@media (max-width: 1199.98px) {
  .sidebar {
    z-index: 1000;
  }
  
  #header {
    z-index: 1002;
  }
}
</style>

<style>
  .app-header {
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 0;
    margin: 0;
  }
  
  .header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 100%;
    margin: 0;
    padding: 8px 16px;
  }
  
  .app-logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4361ee;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .header-actions {
    display: flex;
    gap: 16px;
    align-items: center;
  }
  
  .header-icon {
    font-size: 1.5rem;
    color: #2c3e50;
    position: relative;
  }
  
  .header-badge {
    position: absolute;
    top: -4px;
    right: -6px;
    background: #ff4d4f;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .search-bar {
    flex: 1;
    margin: 0 16px;
    position: relative;
  }
  
  .search-bar input {
    width: 100%;
    padding: 8px 16px 8px 40px;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    font-size: 14px;
    background: #f8f9fa;
  }
  
  .search-bar i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
  }
  
  @media (max-width: 767.98px) {
    .search-bar {
      display: none;
    }
  }
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    margin: 0 !important;
    padding: 0 !important;
    width: 100%;
}

.app-container {
    margin: 0 !important;
    padding: 0 !important;
    max-width: 100% !important;
}

#header, .app-header, header {
    margin: 0 !important;
    padding: 0 !important;
}

#hero {
    margin: 0 !important;
    padding: 0 !important;
}

/* Si usas alguna clase específica para el espacio, añádela aquí */
.espacio-blanco, .spacer, .gap {
    display: none !important;
}
</style>

<header class="app-header">
  <div class="header-content">
    <div class="d-flex align-items-center">
      <button id="sidebarToggle" class="btn btn-link p-0 me-2 text-dark d-md-none">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
      </button>
      <a href="{{ url('/') }}" class="app-logo">
        <i class="bi bi-geo-alt-fill"></i>
        <span>TourApp</span>
      </a>
    </div>
    
    <div class="search-bar d-none d-md-block">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Buscar destinos...">
    </div>
    
    <div class="header-actions">
      <a href="#" class="header-icon">
        <i class="bi bi-bell"></i>
        <span class="header-badge">3</span>
      </a>
      <a href="#" class="header-icon d-none d-md-block">
        <i class="bi bi-person-circle"></i>
      </a>
    </div>
  </div>
</header>
      <a class="btn-getstarted" href="#">Reservar Ahora</a>
    </div>
  </div>
</header>
