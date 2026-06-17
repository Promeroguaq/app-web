@extends('layouts.premium')

@section('content')
<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="row mb-4 g-0">
        <div class="col-12">
            <div class="card bg-dark text-white border-0">
                <img src="https://source.unsplash.com/random/1200x400/?ecolodge,nature,forest"
                     class="card-img w-100"
                     alt="Eco-Lodges"
                     style="height: 250px; object-fit: cover;">

                <div class="card-img-overlay d-flex flex-column justify-content-center text-center px-3"
                     style="background: rgba(0,0,0,0.6);">

                    <h1 class="display-6 fw-bold mb-3">Eco-Lodges</h1>
                    <p class="lead mb-0 d-none d-md-block">Alojamientos sostenibles en armonía con la naturaleza</p>
                    <p class="mb-0 d-md-none">Turismo ecológico responsable</p>
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

    <!-- Eco-Lodges Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-tree text-success me-2"></i>
                Eco-Lodges Disponibles
            </h3>
        </div>
        @if($lodges->count() > 0)
            @foreach($lodges as $lodge)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-campground fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">{{ $lodge->nombre }}</h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $lodge->municipio }}, {{ $lodge->departamento }}
                            </p>
                            <p class="card-text">
                                <span class="badge bg-success">${{ number_format($lodge->precio, 0) }}/noche</span>
                            </p>
                            <p class="card-text">
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>{{ $lodge->rating }}
                                </span>
                            </p>
                            <a href="#" class="btn btn-success btn-sm" onclick="showLodgeDetails({{ $lodge->id }})">
                                Explorar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay eco-lodges disponibles en este momento.
                </div>
            </div>
        @endif
    </div>

    <!-- Eco Features Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-leaf text-success me-2"></i>
                Características Ecológicas
            </h3>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-solar-panel fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Energía Solar</h5>
                    <p class="card-text text-muted small">
                        100% energía renovable de fuentes solares
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-tint fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Agua Lluvia</h5>
                    <p class="card-text text-muted small">
                        Sistema de recolección y filtración de agua de lluvia
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-recycle fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Reciclaje</h5>
                    <p class="card-text text-muted small">
                        Programa completo de reciclaje y compostaje
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-seedling fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Jardín Orgánico</h5>
                    <p class="card-text text-muted small">
                        Alimentos cultivados orgánicamente en el lugar
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-hiking text-primary me-2"></i>
                Actividades Disponibles
            </h3>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-hiking fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Senderismo</h5>
                    <p class="card-text text-muted small">
                        Rutas guiadas por bosques y montañas
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-binoculars fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Observación</h5>
                    <p class="card-text text-muted small">
                        Avistamiento de aves y vida silvestre
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-water fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Kayak</h5>
                    <p class="card-text text-muted small">
                        Excursiones en ríos y lagos cercanos
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-mountain fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Montañismo</h5>
                    <p class="card-text text-muted small">
                        Ascensos a picos y miradores naturales
                    </p>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection

@push('scripts')
<script>
function showLodgeDetails(lodgeId) {
    // Datos de ejemplo para los eco-lodges
    const lodges = {
        1: { nombre: 'Amazonia Eco Lodge', descripcion: 'Inmersión total en la selva amazónica', actividades: ['Trekking', 'Observación de fauna', 'Canopy', 'Visita comunidades'] },
        2: { nombre: 'Sierra Verde', descripcion: 'Eco-lodge con vistas al mar Caribe', actividades: ['Snorkel', 'Kayak', 'Senderismo', 'Yoga'] },
        3: { nombre: 'Coffee Forest', descripcion: 'Alojamiento en medio de cafetales', actividades: ['Tour cafetero', 'Birdwatching', 'Catación', 'Cabalgata'] },
        4: { nombre: 'Pacific Paradise', descripcion: 'Paraíso ecológico en el Pacífico', actividades: ['Avistamiento ballenas', 'Surf', 'Pesca', 'Relajación'] }
    };
    
    const lodge = lodges[lodgeId];
    if (lodge) {
        alert(`🏕️ ${lodge.nombre}\n\n${lodge.descripcion}\n\nActividades:\n${lodge.actividades.join(' • ')}`);
    }
}
</script>
@endpush
