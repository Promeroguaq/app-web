@extends('layouts.premium')

@section('content')
<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="row mb-4 g-0">
        <div class="col-12">
            <div class="card bg-dark text-white border-0">
                <img src="https://source.unsplash.com/random/1200x400/?colombia,tourism"
                     class="card-img w-100"
                     alt="Puntos de Interés"
                     style="height: 250px; object-fit: cover;">

                <div class="card-img-overlay d-flex flex-column justify-content-center text-center px-3"
                     style="background: rgba(0,0,0,0.6);">

                    <h1 class="display-6 fw-bold mb-3">{{ $title ?? 'Puntos de Interés' }}</h1>
                    <p class="lead mb-0 d-none d-md-block">{{ $description ?? 'Descubre los lugares más increíbles de Colombia' }}</p>
                    <p class="mb-0 d-md-none">{{ $subtitle ?? 'Explora Colombia' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container-fluid px-3 px-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if(isset($error))
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $error }}
                    </div>
                @elseif(isset($items) && $items->count() > 0)
                    <div class="row g-3 g-md-4">
                        @foreach($items as $item)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card border-0 shadow-sm h-100 text-center cursor-pointer island-card" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#modal{{ $item->ID_ACTIVIDAD ?? $item->id ?? uniqid() }}"
                                     @if(isset($item->imagen)) 
                                         @if($icon === 'fas fa-umbrella-beach') 
                                             data-island-image="{{ $item->imagen }}" data-island-name="{{ $item->nombre ?? 'Isla' }}"
                                         @elseif($icon === 'fas fa-map-marked-alt') 
                                             data-departamento-image="{{ $item->imagen }}" data-departamento-name="{{ $item->nombre ?? 'Departamento' }}"
                                         @endif 
                                     @endif>
                                    @if(isset($item->imagen) && !empty($item->imagen))
                                        <div class="card-img-top position-relative overflow-hidden" style="height: 150px;">
                                            <img src="{{ $item->imagen }}" 
                                                 alt="{{ $item->nombre ?? 'Imagen' }}" 
                                                 class="w-100 h-100 object-fit-cover"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-primary bg-opacity-75 text-white">
                                                    <i class="{{ $icon ?? 'fas fa-map-marker-alt' }} me-1"></i>
                                                    @if($icon === 'fas fa-umbrella-beach') Isla 
                                                    @elseif($icon === 'fas fa-map-marked-alt') Departamento 
                                                    @else Punto @endif
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-img-top bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <div class="text-center">
                                                <i class="{{ $icon ?? 'fas fa-map-marker-alt' }} text-primary fs-1 mb-2"></i>
                                                <div class="badge bg-primary bg-opacity-75 text-white">
                                                    @if($icon === 'fas fa-umbrella-beach') Isla 
                                                    @elseif($icon === 'fas fa-map-marked-alt') Departamento 
                                                    @else Punto @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-body p-3">
                                        <h6 class="card-title fw-bold mb-2">
                                            {{ $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? $item->nombre_actividad_en_parque ?? $item->nombre ?? $item->nombre_desierto_lagunas ?? $item->nombre_lugar ?? $item->name ?? $item->titulo ?? 'Sin nombre' }}
                                        </h6>
                                        @if(isset($item->DESCRIPCION) || isset($item->descripcion) || isset($item->description))
                                            <p class="text-muted small mb-0">
                                                {{ Str::limit($item->DESCRIPCION ?? $item->descripcion ?? $item->description ?? '', 80) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade"
                                 id="modal{{ $item->ID_ACTIVIDAD ?? $item->id ?? uniqid() }}"
                                 tabindex="-1"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-2 mx-sm-3">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title h5 h-sm-6">
                                                <i class="{{ $icon ?? 'fas fa-map-marker-alt' }} me-2"></i>
                                                {{ $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? $item->nombre_actividad_en_parque ?? $item->nombre ?? $item->nombre_desierto_lagunas ?? $item->nombre_lugar ?? $item->name ?? $item->titulo ?? 'Sin nombre' }}
                                            </h5>
                                            <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body py-2 py-sm-3">
                                            @if(isset($item->imagen))
                                                <div class="text-center mb-3">
                                                    <img src="{{ $item->imagen }}" 
                                                         alt="{{ $item->nombre ?? $item->NOMBRE_ISLA ?? $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? 'Imagen' }}" 
                                                         class="img-fluid rounded shadow-sm"
                                                         style="max-height: 250px; object-fit: cover;"
                                                         onerror="this.style.display='none';">
                                                </div>
                                            @endif
                                            
                                            @if(isset($item->DESCRIPCION) || isset($item->descripcion) || isset($item->description))
                                                <p class="mb-0">
                                                    {{ $item->DESCRIPCION ?? $item->descripcion ?? $item->description ?? '' }}
                                                </p>
                                            @else
                                                <p class="text-muted mb-0">No hay descripción disponible.</p>
                                            @endif
                                            
                                            @if(isset($item->ID_ACTIVIDAD) || isset($item->id_actividad) || isset($item->ID_LOCALITITES) || isset($item->id_localitites))
                                                <hr>
                                                <div class="row">
                                                    @if(isset($item->ID_ACTIVIDAD) || isset($item->id_actividad))
                                                        <div class="col-12 col-md-6">
                                                            <p class="text-muted small mb-2">
                                                                <i class="fas fa-fingerprint me-1"></i>
                                                                <strong>ID Actividad:</strong> {{ $item->ID_ACTIVIDAD ?? $item->id_actividad }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if(isset($item->ID_LOCALITITES) || isset($item->id_localitites))
                                                        <div class="col-12 col-md-6">
                                                            <p class="text-muted small mb-2">
                                                                <i class="fas fa-map-pin me-1"></i>
                                                                <strong>ID Localidad:</strong> {{ $item->ID_LOCALITITES ?? $item->id_localitites }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            @if(isset($item->ubicacion) || isset($item->direccion) || isset($item->lugar))
                                                <hr>
                                                <div class="row">
                                                    @if(isset($item->ubicacion))
                                                        <div class="col-12 col-md-6">
                                                            <p class="text-muted small mb-2">
                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                <strong>Ubicación:</strong> {{ $item->ubicacion }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if(isset($item->direccion))
                                                        <div class="col-12 col-md-6">
                                                            <p class="text-muted small mb-2">
                                                                <i class="fas fa-road me-1"></i>
                                                                <strong>Dirección:</strong> {{ $item->direccion }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if(isset($item->lugar))
                                                        <div class="col-12">
                                                            <p class="text-muted small mb-2">
                                                                <i class="fas fa-map-pin me-1"></i>
                                                                <strong>Lugar:</strong> {{ $item->lugar }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                        class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No hay {{ $itemName ?? 'elementos' }} disponibles en este momento.
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
