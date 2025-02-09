<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Hotel",
 *     title="Hotel",
 *     description="Modelo que representa un hotel.",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Hotel Decameron"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         example="Calle 23 #58-25"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         example="Cartagena"
 *     ),
 *     @OA\Property(
 *         property="nit",
 *         type="string",
 *         example="12345678-9"
 *     ),
 *     @OA\Property(
 *         property="number_of_rooms",
 *         type="integer",
 *         example=50
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2023-10-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2023-10-01T12:00:00Z"
 *     )
 * )
 */
class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'nit',
        'number_of_rooms',
    ];

    public function accommodations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Accommodation::class);
    }
}
