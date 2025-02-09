<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;



class HotelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     summary="Obtener lista de hoteles",
     *     description="Retorna una lista de todos los hoteles registrados con sus acomodaciones y tipos de habitación.",
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
    public function index()
    {
        $hotels = Hotel::with('accommodations.roomType')->get();
        return response()->json($hotels);
    }

    /**
     * @OA\Post(
     *     path="/api/hotels",
     *     summary="Crear un nuevo hotel",
     *     description="Crea un nuevo hotel con los datos proporcionados.",
     *     tags={"Hoteles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Hotel Decameron"),
     *             @OA\Property(property="address", type="string", example="Calle 23 #58-25"),
     *             @OA\Property(property="city", type="string", example="Cartagena"),
     *             @OA\Property(property="nit", type="string", example="12345678-9"),
     *             @OA\Property(property="number_of_rooms", type="integer", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hotel creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/hotels/{id}",
     *     summary="Obtener un hotel específico",
     *     description="Retorna los detalles de un hotel específico con sus acomodaciones y tipos de habitación.",
     *     tags={"Hoteles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del hotel",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel encontrado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $hotel = Hotel::with('accommodations.roomType')->findOrFail($id);
        return response()->json($hotel);
    }

    /**
     * @OA\Put(
     *     path="/api/hotels/{id}",
     *     summary="Actualizar un hotel",
     *     description="Actualiza los datos de un hotel existente.",
     *     tags={"Hoteles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del hotel",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Hotel Decameron Actualizado"),
     *             @OA\Property(property="address", type="string", example="Calle 24 #59-26"),
     *             @OA\Property(property="city", type="string", example="Barranquilla"),
     *             @OA\Property(property="nit", type="string", example="87654321-0"),
     *             @OA\Property(property="number_of_rooms", type="integer", example=60)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel actualizado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Hotel")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/hotels/{id}",
     *     summary="Eliminar un hotel",
     *     description="Elimina un hotel existente.",
     *     tags={"Hoteles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del hotel",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hotel eliminado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['message' => 'Hotel eliminado'], 200);
    }
}
