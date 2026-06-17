@extends('layouts.app')

@section('title', 'Test Minimal')

@section('content')
<div style="background: red; color: white; padding: 20px; margin: 20px;">
    <h1>PÁGINA DE PRUEBA MÍNIMA</h1>
    <p>Si puedes ver esto, el layout funciona.</p>
    <p>Fecha: {{ date('Y-m-d H:i:s') }}</p>
</div>

<div style="background: blue; color: white; padding: 20px; margin: 20px;">
    <h2>Contenido de prueba</h2>
    <p>Este es contenido adicional para verificar renderizado.</p>
    @if(isset($test_data))
        <p>Datos del controlador: {{ $test_data }}</p>
    @else
        <p>Sin datos del controlador</p>
    @endif
</div>
@endsection
