@extends('layouts.app')

@section('title', 'Debug Test')

@section('content')
<div style="background: red; color: white; padding: 50px; margin: 20px; text-align: center; font-size: 2rem;">
    🔴 PÁGINA DE PRUEBA DEBUG 🔴
    <br><br>
    Si ves esto, el layout funciona.
    <br><br>
    Fecha: {{ date('Y-m-d H:i:s') }}
</div>

<div style="background: blue; color: white; padding: 30px; margin: 20px; text-align: center;">
    <h2>Información del Sistema</h2>
    <p>URL: {{ request()->fullUrl() }}</p>
    <p>Método: {{ request()->method() }}</p>
    <p>Usuario: {{ auth()->check() ? 'Autenticado' : 'No autenticado' }}</p>
</div>

<div style="background: green; color: white; padding: 30px; margin: 20px; text-align: center;">
    <h2>Datos de Controlador (si existen)</h2>
    @if(isset($test_data))
        <p>Datos recibidos: {{ $test_data }}</p>
    @else
        <p>No hay datos del controlador</p>
    @endif
</div>
@endsection
