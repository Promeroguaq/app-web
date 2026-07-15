@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle Playa')

@section('content')
<!-- Main Container -->
<div class="detail-destination-page w-full min-w-0 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<x-detail.detail-hero
    :title="$item->nombre"
    :subtitle="$item->descripcion"
    :image="$item->imagen"
    :badge="'🏖️ Playa'"
    :location="$item->locality_departamento ? $item->locality_departamento . ', Colombia' : 'Colombia'"
    :fallbackTheme="'beach'"
/>

<!-- Info Section -->
@php
    $infoItems = [];
    if(isset($item->locality_municipio) && $item->locality_municipio) {
        $infoItems[] = ['label' => 'Municipio', 'value' => $item->locality_municipio, 'icon' => 'fa-map-marker-alt'];
    }
    if(isset($item->locality_departamento) && $item->locality_departamento) {
        $infoItems[] = ['label' => 'Departamento', 'value' => $item->locality_departamento, 'icon' => 'fa-map'];
    }
    if(isset($item->locality_region) && $item->locality_region) {
        $infoItems[] = ['label' => 'Región', 'value' => $item->locality_region, 'icon' => 'fa-compass'];
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
