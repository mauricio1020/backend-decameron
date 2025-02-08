<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear tipos de habitación
        $roomTypes = RoomType::factory()->createMany([
            ['name' => 'Estándar'],
            ['name' => 'Junior'],
            ['name' => 'Suite'],
        ]);

        // 2. Crear un hotel
        $hotel = Hotel::factory()->create([
            'name' => 'DECAMERON CARTAGENA',
            'address' => 'CALLE 23 58-25',
            'city' => 'CARTAGENA',
            'nit' => '12345678-9',
            'number_of_rooms' => 42,
        ]);

        // 3. Asociar acomodaciones al hotel
        Accommodation::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomTypes[0]->id, // Estándar
            'type' => 'Sencilla',
            'quantity' => 25,
        ]);

        Accommodation::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomTypes[1]->id, // Junior
            'type' => 'Triple',
            'quantity' => 12,
        ]);

        Accommodation::factory()->create([
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomTypes[0]->id, // Estándar
            'type' => 'Doble',
            'quantity' => 5,
        ]);
    }
}
