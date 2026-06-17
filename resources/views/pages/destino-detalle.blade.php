@extends('layouts.premium')

@section('title', $destino['nombre'])

@push('styles')
<style>
    .hero-image {
        height: 400px;
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: 20px;
        overflow: hidden;
    }
    .hero-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: flex-end;
        padding: 30px;
    }
    .badge-destacado {
        background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(245, 175, 25, 0.4);
    }
    .destino-title {
        font-family: 'Georgia', 'Times New Roman', serif;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        margin-bottom: 0.5rem;
    }
    .info-panel {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 25px;
        height: 100%;
    }
    .info-item {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #7f8c8d;
        font-size: 0.875rem;
        margin-bottom: 5px;
    }
    .info-value {
        color: #2c3e50;
        font-size: 1rem;
        font-weight: 500;
    }
    .star-rating {
        color: #ffc107;
        font-size: 1.25rem;
    }
    .btn-volver {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-volver:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .description-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #5a6c7d;
    }
    .category-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-block;
    }
    .subcategory-badge {
        background: #e9ecef;
        color: #495057;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        margin-left: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Back Button -->
    <a href="{{ route('destinos') }}" class="btn btn-volver mb-4">
        <i class="fas fa-arrow-left me-2"></i> Volver a Destinos
    </a>

    <!-- Hero Section -->
    <div class="hero-image mb-4" style="background-image: url('{{ $destino['imagen'] }}');">
        <div class="hero-overlay">
            <div class="w-100">
                @if($destino['destacado'])
                    <span class="badge-destacado mb-3">
                        <i class="fas fa-star me-2"></i> Destacado
                    </span>
                @endif
                <h1 class="destino-title">{{ $destino['nombre'] }}</h1>
                <div class="d-flex align-items-center flex-wrap">
                    <span class="category-badge">{{ $destino['categoria'] }}</span>
                    <span class="subcategory-badge">{{ $destino['subcategoria'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4" style="color: #2c3e50;">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Descripción
                    </h3>
                    <p class="description-text">{{ $destino['descripcion'] }}</p>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="col-12 col-lg-4">
            <div class="info-panel">
                <h4 class="fw-bold mb-4" style="color: #2c3e50;">
                    <i class="fas fa-map-pin me-2 text-danger"></i> Información del Destino
                </h4>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt me-2"></i> Ubicación Exacta
                    </div>
                    <div class="info-value">{{ $destino['ubicacion_exacta'] }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-globe me-2"></i> Departamento
                    </div>
                    <div class="info-value">{{ $destino['departamento'] }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-city me-2"></i> Municipio
                    </div>
                    <div class="info-value">{{ $destino['municipio'] }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-star me-2"></i> Calificación
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($destino['calificacion']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $destino['calificacion'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="ms-2 fw-bold" style="color: #2c3e50;">{{ $destino['calificacion'] }}/5</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-tag me-2"></i> Categoría
                    </div>
                    <div class="info-value">{{ $destino['categoria'] }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-layer-group me-2"></i> Subcategoría
                    </div>
                    <div class="info-value">{{ $destino['subcategoria'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
