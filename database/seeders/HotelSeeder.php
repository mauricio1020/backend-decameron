<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hotel::create([
            'name' => 'DECAMERON CARTAGENA',
            'address' => 'CALLE 23 58-25',
            'city' => 'CARTAGENA',
            'nit' => '12345678-9',
            'number_of_rooms' => 42,
        ]);
    }
}
