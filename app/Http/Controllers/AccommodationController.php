<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Http\Requests\StoreAccommodationRequest;
use App\Http\Requests\UpdateAccommodationRequest;
use OpenApi\Annotations as OA;



class AccommodationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/accommodations",
     *     summary="Crear una nueva acomodación",
     *     description="Crea una nueva acomodación asociada a un hotel y tipo de habitación.",
     *     tags={"Acomodaciones"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="hotel_id", type="integer", example=1),
     *             @OA\Property(property="room_type_id", type="integer", example=1),
     *             @OA\Property(property="type", type="string", example="Sencilla"),
     *             @OA\Property(property="quantity", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Acomodación creada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Accommodation")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function store(StoreAccommodationRequest $request)
    {
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

    /**
     * @OA\Get(
     *     path="/api/accommodations",
     *     summary="Obtener todas las acomodaciones",
     *     description="Retorna una lista de todas las acomodaciones con sus relaciones (hotel y tipo de habitación).",
     *     tags={"Acomodaciones"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de acomodaciones obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Accommodation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron acomodaciones"
     *     )
     * )
     */
    public function index()
    {
        $accommodations = Accommodation::with('hotel', 'roomType')->orderBy('hotel_id')->get();
        return response()->json($accommodations);
    }

    /**
     * @OA\Get(
     *     path="/api/accommodations/{id}",
     *     summary="Mostrar una acomodación específica",
     *     description="Retorna los detalles de una acomodación específica por su ID.",
     *     tags={"Acomodaciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la acomodación",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la acomodación obtenidos exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Accommodation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Acomodación no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $accommodation = Accommodation::with('hotel', 'roomType')->findOrFail($id);
        return response()->json($accommodation);
    }

    /**
     * @OA\Put(
     *     path="/api/accommodations/{id}",
     *     summary="Actualizar una acomodación",
     *     description="Actualiza los datos de una acomodación existente.",
     *     tags={"Acomodaciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la acomodación",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="hotel_id", type="integer", example=1),
     *             @OA\Property(property="room_type_id", type="integer", example=1),
     *             @OA\Property(property="type", type="string", example="Doble"),
     *             @OA\Property(property="quantity", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Acomodación actualizada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Accommodation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Acomodación no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function update(UpdateAccommodationRequest $request, $id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $validated = $request->validated();
        $accommodation->update($validated);
        return response()->json($accommodation);
    }

    /**
     * @OA\Delete(
     *     path="/api/accommodations/{id}",
     *     summary="Eliminar una acomodación",
     *     description="Elimina una acomodación existente por su ID.",
     *     tags={"Acomodaciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la acomodación",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Acomodación eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Acomodación eliminada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Acomodación no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return response()->json(['message' => 'Acomodación eliminada'], 200);
    }
}
