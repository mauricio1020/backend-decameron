<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'type',
        'quantity',
    ];

    // Relaciones
    public function hotel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
