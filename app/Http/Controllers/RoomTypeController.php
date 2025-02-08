<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        // Obtener todos los tipos de habitación
        $roomTypes = RoomType::all();
        return response()->json($roomTypes);
    }
}
