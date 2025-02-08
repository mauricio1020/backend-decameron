<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name',
        'address',
        'city',
        'nit',
        'number_of_rooms',
    ];

    // Relaciones
    public function accommodations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Accommodation::class);
    }
}
