@extends('layouts.minimal')

@section('title', 'Debug Minimal')

@section('content')
    <h1 style="color: red; text-align: center;">🔴 PÁGINA DEBUG MINIMAL 🔴</h1>
    <p style="font-size: 1.2rem; text-align: center;">Si ves esto, el layout minimal funciona.</p>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <h2>Información:</h2>
        <p>Fecha: {{ date('Y-m-d H:i:s') }}</p>
        <p>URL: {{ request()->fullUrl() }}</p>
        <p>Layout: layouts.minimal</p>
    </div>
    
    <div style="background: #e8f5e8; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <h2>Contenido de prueba:</h2>
        <p>Este es contenido estático que siempre debería renderizar.</p>
        <p>No depende de base de datos ni de controladores complejos.</p>
    </div>
@endsection
