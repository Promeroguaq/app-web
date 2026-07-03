<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Mostrar página de configuración
     */
    public function index()
    {
        // Regiones naturales de Colombia para preferencias
        $regiones = [
            (object)['slug' => 'caribe', 'name' => 'Región Caribe', 'shortName' => 'Caribe'],
            (object)['slug' => 'andina', 'name' => 'Región Andina', 'shortName' => 'Andina'],
            (object)['slug' => 'pacifica', 'name' => 'Región Pacífica', 'shortName' => 'Pacífica'],
            (object)['slug' => 'amazonia', 'name' => 'Región Amazónica', 'shortName' => 'Amazonía'],
            (object)['slug' => 'llanos', 'name' => 'Región Orinoquía', 'shortName' => 'Llanos'],
            (object)['slug' => 'insular', 'name' => 'Región Insular', 'shortName' => 'Insular']
        ];

        // Enviar datos a la vista
        return view('pages.configuracion', compact('regiones'));
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
