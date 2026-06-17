@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="row mb-4 g-0">
        <div class="col-12">
            <div class="card bg-dark text-white border-0">
                <img src="https://source.unsplash.com/random/1200x400/?settings,configuration,dashboard"
                     class="card-img w-100"
                     alt="Configuración"
                     style="height: 250px; object-fit: cover;">

                <div class="card-img-overlay d-flex flex-column justify-content-center text-center px-3"
                     style="background: rgba(0,0,0,0.6);">

                    <h1 class="display-6 fw-bold mb-3">Configuración</h1>
                    <p class="lead mb-0 d-none d-md-block">Personaliza tu experiencia en TurismoApp</p>
                    <p class="mb-0 d-md-none">Ajustes personales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Configuration Sections -->
    <div class="row">
        <!-- Left Sidebar - Navigation -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-cog text-primary me-2"></i>
                        Menú de Configuración
                    </h5>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#general" data-bs-toggle="pill">
                            <i class="fas fa-sliders-h me-2"></i> General
                        </a>
                        <a class="nav-link" href="#cuenta" data-bs-toggle="pill">
                            <i class="fas fa-user me-2"></i> Cuenta
                        </a>
                        <a class="nav-link" href="#notificaciones" data-bs-toggle="pill">
                            <i class="fas fa-bell me-2"></i> Notificaciones
                        </a>
                        <a class="nav-link" href="#privacidad" data-bs-toggle="pill">
                            <i class="fas fa-lock me-2"></i> Privacidad
                        </a>
                        <a class="nav-link" href="#region" data-bs-toggle="pill">
                            <i class="fas fa-map-marker-alt me-2"></i> Región
                        </a>
                        <a class="nav-link" href="#apariencia" data-bs-toggle="pill">
                            <i class="fas fa-palette me-2"></i> Apariencia
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="tab-content">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-sliders-h text-primary me-2"></i>
                                Configuración General
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('configuracion.update.general') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="idioma" class="form-label">Idioma</label>
                                        <select class="form-select" id="idioma" name="idioma">
                                            <option value="es" selected>Español</option>
                                            <option value="en">English</option>
                                            <option value="pt">Português</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="moneda" class="form-label">Moneda</label>
                                        <select class="form-select" id="moneda" name="moneda">
                                            <option value="COP" selected>Peso Colombiano (COP)</option>
                                            <option value="USD">Dólar Americano (USD)</option>
                                            <option value="EUR">Euro (EUR)</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="zona_horaria" class="form-label">Zona Horaria</label>
                                        <select class="form-select" id="zona_horaria" name="zona_horaria">
                                            <option value="America/Bogota" selected>Hora Colombia (GMT-5)</option>
                                            <option value="America/Mexico_City">Hora México (GMT-6)</option>
                                            <option value="America/Argentina/Buenos_Aires">Hora Argentina (GMT-3)</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="tab-pane fade" id="cuenta">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user text-primary me-2"></i>
                                Configuración de Cuenta
                            </h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="tu@email.com">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="bio" class="form-label">Biografía</label>
                                        <textarea class="form-control" id="bio" rows="3" placeholder="Cuéntanos sobre ti..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Actualizar Perfil
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div class="tab-pane fade" id="notificaciones">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-bell text-primary me-2"></i>
                                Configuración de Notificaciones
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('configuracion.update.notificaciones') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" checked>
                                        <label class="form-check-label" for="email_notifications">
                                            Notificaciones por Email
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="push_notifications" name="push_notifications" checked>
                                        <label class="form-check-label" for="push_notifications">
                                            Notificaciones Push
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Newsletter de TurismoApp
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="promociones" name="promociones" checked>
                                        <label class="form-check-label" for="promociones">
                                            Promociones y Ofertas
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar Preferencias
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="tab-pane fade" id="privacidad">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-lock text-primary me-2"></i>
                                Configuración de Privacidad
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('configuracion.update.privacidad') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="profile_public" name="profile_public">
                                        <label class="form-check-label" for="profile_public">
                                            Perfil Público
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="show_activity" name="show_activity" checked>
                                        <label class="form-check-label" for="show_activity">
                                            Mostrar Actividad
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="data_analytics" name="data_analytics" checked>
                                        <label class="form-check-label" for="data_analytics">
                                            Permitir Análisis de Datos
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Actualizar Privacidad
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Region Settings -->
                <div class="tab-pane fade" id="region">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Configuración Regional
                            </h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="departamento_preferido" class="form-label">Departamento Preferido</label>
                                        <select class="form-select" id="departamento_preferido" name="departamento_preferido">
                                            <option value="">Selecciona un departamento</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{ $departamento->ID_DEPARTAMENTO }}">{{ $departamento->NOMBRE_DEPARTAMENTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="municipio_preferido" class="form-label">Municipio Preferido</label>
                                        <select class="form-select" id="municipio_preferido" name="municipio_preferido">
                                            <option value="">Selecciona un municipio</option>
                                            @foreach($municipios as $municipio)
                                                <option value="{{ $municipio->ID_MUNICIPIOS }}">{{ $municipio->NOMBRE_MUNICIPIOS }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Guardar Preferencias Regionales
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div class="tab-pane fade" id="apariencia">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-palette text-primary me-2"></i>
                                Configuración de Apariencia
                            </h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Tema</label>
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="theme" id="theme_light" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="theme_light">
                                            <i class="fas fa-sun me-2"></i> Claro
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="theme" id="theme_dark" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="theme_dark">
                                            <i class="fas fa-moon me-2"></i> Oscuro
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="theme" id="theme_auto" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="theme_auto">
                                            <i class="fas fa-adjust me-2"></i> Automático
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="font_size" class="form-label">Tamaño de Fuente</label>
                                    <select class="form-select" id="font_size" name="font_size">
                                        <option value="small">Pequeño</option>
                                        <option value="medium" selected>Mediano</option>
                                        <option value="large">Grande</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Aplicar Cambios
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
