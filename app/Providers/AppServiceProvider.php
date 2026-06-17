<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share menu image URL globally - CACHED to avoid query on every page load
        View::composer('*', function ($view) {
            $menuImageUrl = Cache::remember('menu_image_url', 3600, function () {
                $menuImage = DB::table('tabla_imagenes')->where('ID_IMAGEN', 2)->first();
                
                if ($menuImage && !empty($menuImage->RUTA)) {
                    return $menuImage->RUTA;
                } else {
                    Log::warning('No se encontró imagen de menú con ID_IMAGEN=2 en tabla_imagenes');
                    return null;
                }
            });
            
            $view->with('menuImageUrl', $menuImageUrl);
        });
    }
}
