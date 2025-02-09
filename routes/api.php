<?php
namespace App\OpenApi;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;




// Ruta protegida para obtener el usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * @OA\Get(
 *     path="/api/hotels",
 *     summary="Obtener lista de hoteles",
 *     tags={"Hoteles"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de hoteles obtenida exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Hotel")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontraron hoteles"
 *     )
 * )
 */
Route::apiResource('hotels', HotelController::class);

/**
 * @OA\Get(
 *     path="/api/accommodations",
 *     summary="Obtener lista de acomodaciones",
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
Route::apiResource('accommodations', AccommodationController::class);

/**
 * @OA\Get(
 *     path="/api/room-types",
 *     summary="Obtener lista de tipos de habitación",
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
Route::get('/room-types', [RoomTypeController::class, 'index']);
