<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Mostrar página de configuración
     */
    public function index()
    {
        // Obtener departamentos para configuraciones regionales
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        
        // Obtener municipios para configuraciones locales
        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();

        // Enviar datos a la vista
        return view('pages.configuracion', compact('departamentos', 'municipios'));
    }
    
    /**
     * Actualizar configuración general
     */
    public function updateGeneral(Request $request)
    {
        // Lógica para actualizar configuración general
        return redirect()->route('configuracion')->with('success', 'Configuración general actualizada correctamente');
    }
    
    /**
     * Actualizar configuración de notificaciones
     */
    public function updateNotificaciones(Request $request)
    {
        // Lógica para actualizar configuración de notificaciones
        return redirect()->route('configuracion')->with('success', 'Configuración de notificaciones actualizada correctamente');
    }
    
    /**
     * Actualizar configuración de privacidad
     */
    public function updatePrivacidad(Request $request)
    {
        // Lógica para actualizar configuración de privacidad
        return redirect()->route('configuracion')->with('success', 'Configuración de privacidad actualizada correctamente');
    }
}
