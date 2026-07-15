@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle Deporte Aventura')

@section('content')
<!-- Main Container -->
<div class="detail-destination-page w-full min-w-0 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<x-detail.detail-hero
    :title="$item->nombre"
    :subtitle="$item->descripcion"
    :image="$item->imagen"
    :badge="'🏔️ Deporte de Aventura'"
    :location="$item->ubicacion ?? 'Colombia'"
    :fallbackTheme="'adventure'"
/>

<!-- Info Section -->
@php
    $infoItems = [];
    if(isset($item->ubicacion) && $item->ubicacion) {
        $infoItems[] = ['label' => 'Ubicación', 'value' => $item->ubicacion, 'icon' => 'fa-map-marker-alt'];
    }
    if(isset($item->municipios) && $item->municipios) {
        $infoItems[] = ['label' => 'Municipios', 'value' => $item->municipios, 'icon' => 'fa-city'];
    }
@endphp
<x-detail.info-grid :items="$infoItems" />

<!-- Description Section -->
<x-detail.description-section 
    :title="'Sobre ' . $item->nombre"
    :description="$item->descripcion"
/>

    </div>
</div>
@endsection
