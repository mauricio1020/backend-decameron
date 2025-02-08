<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Obtener todos los hoteles
    public function index()
    {
        $hotels = Hotel::with('accommodations.roomType')->get();
        return response()->json($hotels);
    }

    // Crear un nuevo hotel
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'nit' => 'required|string|unique:hotels,nit',
            'number_of_rooms' => 'required|integer|min:1',
        ]);
        $hotel = Hotel::create($validated);
        return response()->json($hotel, 201);
    }

    // Mostrar un hotel específico
    public function show($id)
    {
        $hotel = Hotel::with('accommodations.roomType')->findOrFail($id);
        return response()->json($hotel);
    }

    // Actualizar un hotel
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'nit' => 'sometimes|required|string|unique:hotels,nit,' . $id,
            'number_of_rooms' => 'sometimes|required|integer|min:1',
        ]);

        $hotel->update($validated);
        return response()->json($hotel);
    }

    // Eliminar un hotel
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['message' => 'Hotel eliminado'], 200);
    }
}
