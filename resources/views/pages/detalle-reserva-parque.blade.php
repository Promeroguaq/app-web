@extends('layouts.premium')

@section('title', $reserva->nombre ?? 'Detalle Reserva Natural')

@section('content')
<!-- Main Container -->
<div class="detail-destination-page w-full min-w-0 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<x-detail.detail-hero
    :title="$reserva->nombre"
    :subtitle="$reserva->descripcion"
    :image="$reserva->imagen"
    :badge="'🌲 Reserva Natural'"
    :location="$reserva->departamento ? $reserva->departamento . ', Colombia' : 'Colombia'"
    :fallbackTheme="'nature'"
/>

<!-- Info Section -->
@php
    $infoItems = [];
    if(isset($reserva->locality_municipio) && $reserva->locality_municipio) {
        $infoItems[] = ['label' => 'Municipio', 'value' => $reserva->locality_municipio, 'icon' => 'fa-map-marker-alt'];
    }
    if(isset($reserva->departamento) && $reserva->departamento) {
        $infoItems[] = ['label' => 'Departamento', 'value' => $reserva->departamento, 'icon' => 'fa-map'];
    }
    if(isset($reserva->region) && $reserva->region) {
        $infoItems[] = ['label' => 'Región', 'value' => $reserva->region, 'icon' => 'fa-compass'];
    }
@endphp
<x-detail.info-grid :items="$infoItems" />

<!-- Description Section -->
<x-detail.description-section 
    :title="'Sobre ' . $reserva->nombre"
    :description="$reserva->descripcion"
/>

    </div>
</div>
@endsection
