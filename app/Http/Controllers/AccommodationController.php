<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Http\Requests\StoreAccommodationRequest;
use App\Http\Requests\UpdateAccommodationRequest;

class AccommodationController extends Controller
{
    // Crear una nueva acomodación
    public function store(StoreAccommodationRequest $request) {
        try {
            $validated = $request->validated();
            $accommodation = Accommodation::create($validated);
            return response()->json($accommodation, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Obtener todas las acomodaciones
    public function index()
    {
        $accommodations = Accommodation::with('hotel', 'roomType')->orderBy('hotel_id')->get();
        return response()->json($accommodations);
    }

    // Mostrar una acomodación específica
    public function show($id)
    {
        $accommodation = Accommodation::with('hotel', 'roomType')->findOrFail($id);
        return response()->json($accommodation);
    }

    // Actualizar una acomodación
    public function update(UpdateAccommodationRequest $request, $id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $validated = $request->validated();
        $accommodation->update($validated);
        return response()->json($accommodation);
    }

    // Eliminar una acomodación
    public function destroy($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return response()->json(['message' => 'Acomodación eliminada'], 200);
    }
}
