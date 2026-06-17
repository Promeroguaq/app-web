@extends('layouts.premium')

@section('content')
<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="row mb-4 g-0">
        <div class="col-12">
            <div class="card bg-dark text-white border-0">
                <img src="https://source.unsplash.com/random/1200x400/?resort,luxury,beach"
                     class="card-img w-100"
                     alt="Resorts"
                     style="height: 250px; object-fit: cover;">

                <div class="card-img-overlay d-flex flex-column justify-content-center text-center px-3"
                     style="background: rgba(0,0,0,0.6);">

                    <h1 class="display-6 fw-bold mb-3">Resorts de Lujo</h1>
                    <p class="lead mb-0 d-none d-md-block">Experiencias premium con servicios de clase mundial</p>
                    <p class="mb-0 d-md-none">Vacaciones de lujo y confort</p>
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

    <!-- Resorts Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-umbrella-beach text-info me-2"></i>
                Resorts de Lujo Disponibles
            </h3>
        </div>
        @if($resorts->count() > 0)
            @foreach($resorts as $resort)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-umbrella-beach fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">{{ $resort->nombre }}</h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $resort->municipio }}, {{ $resort->departamento }}
                            </p>
                            <p class="card-text">
                                <span class="badge bg-success">${{ number_format($resort->precio, 0) }}/noche</span>
                            </p>
                            <p class="card-text">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $resort->estrellas)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </p>
                            <a href="#" class="btn btn-info btn-sm" onclick="showResortDetails({{ $resort->id }})">
                                Ver resorts
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay resorts disponibles en este momento.
                </div>
            </div>
        @endif
    </div>

    <!-- Luxury Services Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-concierge-bell text-warning me-2"></i>
                Servicios Premium
            </h3>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-spa fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Spa & Wellness</h5>
                    <p class="card-text text-muted small">
                        Tratamientos de relajación y terapias rejuvenecedoras
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
                    <h5 class="card-title">Restaurantes Gourmet</h5>
                    <p class="card-text text-muted small">
                        Gastronomía internacional de chefs reconocidos
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-swimming-pool fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Piscinas Infinity</h5>
                    <p class="card-text text-muted small">
                        Piscinas con vistas espectaculares al mar o montaña
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-dumbbell fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Gimnasio Premium</h5>
                    <p class="card-text text-muted small">
                        Equipamiento de última generación y entrenadores
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Types Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-bed text-primary me-2"></i>
                Tipos de Habitación
            </h3>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-door-open fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Suite Estándar</h5>
                    <p class="card-text text-muted small">
                        Comodidad y elegancia con todas las amenidades
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-crown fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Suite Presidencial</h5>
                    <p class="card-text text-muted small">
                        Lujo exclusivo con vistas panorámicas
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
                    <h5 class="card-title">Villa Privada</h5>
                    <p class="card-text text-muted small">
                        Piscina privada y acceso directo a la playa
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-heart fa-3x text-danger"></i>
                    </div>
                    <h5 class="card-title">Suite Romántica</h5>
                    <p class="card-text text-muted small">
                        Perfecta para escapadas en pareja
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Beach Destinations -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-map-marked-alt text-success me-2"></i>
                Destinos de Playa Populares
            </h3>
        </div>
        @foreach($departamentos->take(4) as $departamento)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-umbrella-beach fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">{{ $departamento->NOMBRE_DEPARTAMENTO }}</h5>
                        <p class="card-text text-muted small">
                            {{ rand(3, 12) }} resorts de lujo
                        </p>
                        <a href="#" class="btn btn-outline-info btn-sm">
                            Explorar
                        </a>
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
function showResortDetails(resortId) {
    // Datos de ejemplo para los resorts
    const resorts = {
        1: { nombre: 'Caribbean Resort', descripcion: 'Resort de 5 estrellas en San Andrés', servicios: ['Spa', 'Gimnasio', 'Restaurantes', 'Piscinas', 'Playa privada'] },
        2: { nombre: 'Pacific Paradise Resort', descripcion: 'Lujo frente al mar Pacífico', servicios: ['Spa', 'Gimnasio', 'Restaurantes', 'Piscinas', 'Kayak'] },
        3: { nombre: 'Andes Luxury', descripcion: 'Resort boutique con vistas a los Andes', servicios: ['Spa', 'Gimnasio', 'Restaurantes', 'Piscinas', 'Terraza panorámica'] },
        4: { nombre: 'Sun Beach Resort', descripcion: 'Resort familiar en la costa Atlántica', servicios: ['Kids Club', 'Gimnasio', 'Restaurantes', 'Piscinas', 'Discoteca'] }
    };
    
    const resort = resorts[resortId];
    if (resort) {
        alert(`🏨 ${resort.nombre}\n\n${resort.descripcion}\n\nServicios:\n${resort.servicios.join(' • ')}`);
    }
}
</script>
@endpush
