@extends('layouts.premium')

@section('content')
<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="row mb-4 g-0">
        <div class="col-12">
            <div class="card bg-dark text-white border-0">
                <img src="https://source.unsplash.com/random/1200x400/?guesthouse,bedbreakfast,hospitality"
                     class="card-img w-100"
                     alt="Casas de Huéspedes"
                     style="height: 250px; object-fit: cover;">

                <div class="card-img-overlay d-flex flex-column justify-content-center text-center px-3"
                     style="background: rgba(0,0,0,0.6);">

                    <h1 class="display-6 fw-bold mb-3">Casas de Huéspedes</h1>
                    <p class="lead mb-0 d-none d-md-block">Alojamientos acogedores con servicio personalizado</p>
                    <p class="mb-0 d-md-none">Hospedaje cercano y auténtico</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation Component -->
    <!-- Tab Navigation Component -->
    <div class="container-fluid px-3 px-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-map me-2"></i>
                    Explorar por Departamentos
                </h5>
            </div>
            <div class="card-body p-3 p-sm-4">
                <div class="row g-2 g-sm-3">
                    @forelse($departamentos->take(12) as $departamento)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="card border-0 shadow-sm h-100 text-center cursor-pointer">
                                <div class="card-body p-2 p-sm-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 p-sm-3 d-inline-block mb-2 mb-sm-3">
                                        <i class="fas fa-map-marked-alt text-success fs-5 fs-sm-4"></i>
                                    </div>
                                    <h6 class="card-title fw-bold mb-1 mb-sm-2 small fs-sm-6">{{ Str::limit($departamento->NOMBRE_DEPARTAMENTO, 15) }}</h6>
                                    <p class="text-muted small mb-0 d-none d-sm-block">
                                        <i class="fas fa-map-pin me-1"></i>
                                        Departamento
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No hay departamentos disponibles.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Guest Houses Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-home text-primary me-2"></i>
                Casas de Huéspedes Disponibles
            </h3>
        </div>
        @if($casas->count() > 0)
            @foreach($casas as $casa)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-home fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">{{ $casa->nombre }}</h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $casa->municipio }}, {{ $casa->departamento }}
                            </p>
                            <p class="card-text">
                                <span class="badge bg-success">${{ number_format($casa->precio, 0) }}/noche</span>
                            </p>
                            <p class="card-text text-muted small">
                                <i class="fas fa-bed me-1"></i> {{ $casa->habitaciones }} habitaciones
                            </p>
                            <a href="#" class="btn btn-primary btn-sm" onclick="showCasaDetails({{ $casa->id }})">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay casas de huéspedes disponibles en este momento.
                </div>
            </div>
        @endif
    </div>

    <!-- Features Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-star text-warning me-2"></i>
                Características de Nuestras Casas
            </h3>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-wifi fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">WiFi Gratis</h5>
                    <p class="card-text text-muted small">
                        Conexión a internet de alta velocidad en todas las habitaciones
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-utensils fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Desayuno Incluido</h5>
                    <p class="card-text text-muted small">
                        Delicioso desayuno casero preparado con ingredientes locales
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-car fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Estacionamiento</h5>
                    <p class="card-text text-muted small">
                        Área de estacionamiento seguro y gratuito para huéspedes
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-concierge-bell fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Servicio Personalizado</h5>
                    <p class="card-text text-muted small">
                        Atención cercana y recomendaciones locales personalizadas
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Destinations -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-map-marked-alt text-success me-2"></i>
                Destinos Populares
            </h3>
        </div>
        @foreach($departamentos->take(6) as $departamento)
            <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-map-pin fa-2x text-success"></i>
                        </div>
                        <h6 class="card-title">{{ $departamento->NOMBRE_DEPARTAMENTO }}</h6>
                        <p class="card-text text-muted small">
                            {{ rand(5, 25) }} casas disponibles
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection

@push('scripts')
<script>
function showCasaDetails(casaId) {
    // Datos de ejemplo para las casas
    const casas = {
        1: { nombre: 'Casa del Sol', descripcion: 'Hermosa casa con jardín y terraza', servicios: ['WiFi', 'Desayuno', 'Estacionamiento', 'Jardín'] },
        2: { nombre: 'Villa Peace', descripcion: 'Espaciosa villa con vistas panorámicas', servicios: ['WiFi', 'Desayuno', 'Estacionamiento', 'Terraza'] },
        3: { nombre: 'Café House', descripcion: 'Acogedora casa temática del café', servicios: ['WiFi', 'Desayuno', 'Cafetería', 'Tour cafetero'] },
        4: { nombre: 'Mountain View', descripcion: 'Casa con vistas a la montaña', servicios: ['WiFi', 'Desayuno', 'Senderismo', 'Chimenea'] }
    };
    
    const casa = casas[casaId];
    if (casa) {
        alert(`🏠 ${casa.nombre}\n\n${casa.descripcion}\n\nServicios:\n${casa.servicios.join(' • ')}`);
    }
}
</script>
@endpush
