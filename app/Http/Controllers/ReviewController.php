<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'guest_name' => 'required_without:user_id|string|min:2|max:100',
            'guest_email' => 'nullable|email|max:255',
        ], [
            'rating.required' => 'La calificación es obligatoria.',
            'rating.min' => 'La calificación mínima es 1 estrella.',
            'rating.max' => 'La calificación máxima es 5 estrellas.',
            'comment.required' => 'El comentario es obligatorio.',
            'comment.min' => 'El comentario debe tener al menos 10 caracteres.',
            'comment.max' => 'El comentario no puede exceder 1000 caracteres.',
            'guest_name.required_without' => 'El nombre es obligatorio.',
            'guest_name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'guest_email.email' => 'El email no es válido.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario.');
        }

        try {
            // Validar que el modelo reviewable existe
            $reviewableType = $request->reviewable_type;
            $reviewableId = $request->reviewable_id;

            // Mapeo de tipos a modelos
            $modelMap = [
                'municipio' => \App\Models\Municipio::class,
                'feria' => \App\Models\FeriaFiesta::class,
                'App\Models\Municipio' => \App\Models\Municipio::class,
                'App\Models\FeriaFiesta' => \App\Models\FeriaFiesta::class,
            ];

            if (!isset($modelMap[$reviewableType])) {
                return back()->with('error', 'Tipo de entidad no válido para reseñas.');
            }

            $modelClass = $modelMap[$reviewableType];
            $reviewable = $modelClass::find($reviewableId);

            if (!$reviewable) {
                return back()->with('error', 'La entidad a reseñar no existe.');
            }

            // Crear la review
            $review = new Review([
                'reviewable_type' => $modelClass,
                'reviewable_id' => $reviewableId,
                'rating' => $request->rating,
                'comment' => strip_tags($request->comment),
                'status' => 'pending', // Requiere moderación
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Si hay usuario autenticado
            if (Auth::check()) {
                $review->user_id = Auth::id();
            } else {
                $review->guest_name = strip_tags($request->guest_name);
                $review->guest_email = $request->guest_email;
            }

            $review->save();

            Log::info('Nueva review creada', [
                'review_id' => $review->id,
                'reviewable_type' => $review->reviewable_type,
                'reviewable_id' => $review->reviewable_id,
                'rating' => $review->rating,
                'status' => $review->status,
            ]);

            return back()->with('success', '¡Gracias por tu opinión! Tu comentario será revisado antes de publicarse.');

        } catch (\Exception $e) {
            Log::error('Error al crear review', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return back()->with('error', 'Hubo un error al guardar tu comentario. Por favor intenta nuevamente.');
        }
    }
}
