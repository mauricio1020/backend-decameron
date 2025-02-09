<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;



class RoomTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/room-types",
     *     summary="Obtener lista de tipos de habitación",
     *     description="Retorna una lista de todos los tipos de habitación registrados.",
     *     tags={"Tipos de Habitación"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipos de habitación obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/RoomType")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron tipos de habitación"
     *     )
     * )
     */
    public function index()
    {
        // Obtener todos los tipos de habitación
        $roomTypes = RoomType::all();
        return response()->json($roomTypes);
    }
}
