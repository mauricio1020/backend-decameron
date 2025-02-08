<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Hotel; // Asegúrate de que esta línea esté presente
use App\Models\RoomType;
use App\Models\Accommodation;

class StoreAccommodationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $roomTypeId = $this->input('room_type_id');
            $type = $this->input('type');

            // Validar el tipo de habitación
            $roomType = RoomType::findOrFail($roomTypeId);

            if ($roomType->name === 'Estándar' && !in_array($type, ['Sencilla', 'Doble'])) {
                $validator->errors()->add('type', 'La acomodación no es válida para el tipo de habitación Estándar.');
            }
            if ($roomType->name === 'Junior' && !in_array($type, ['Triple', 'Cuádruple'])) {
                $validator->errors()->add('type', 'La acomodación no es válida para el tipo de habitación Junior.');
            }
            if ($roomType->name === 'Suite' && !in_array($type, ['Sencilla', 'Doble', 'Triple'])) {
                $validator->errors()->add('type', 'La acomodación no es válida para el tipo de habitación Suite.');
            }
            // Validar que la cantidad de habitaciones no exceda el límite del hotel
            $totalRooms = Accommodation::where('hotel_id', $this->input('hotel_id'))->sum('quantity');
            $hotel = Hotel::findOrFail($this->input('hotel_id'));

            if ($totalRooms + $this->input('quantity') > $hotel->number_of_rooms) {
                $validator->errors()->add('quantity', 'La cantidad de habitaciones excede el límite del hotel.');
            }
            // Validar que no existan combinaciones duplicadas
            $exists = Accommodation::where('hotel_id', $this->input('hotel_id'))
                ->where('room_type_id', $roomTypeId)
                ->where('type', $type)
                ->exists();

            if ($exists) {
                $validator->errors()->add('type', 'Esta combinación de tipo de habitación y acomodación ya existe para este hotel.');
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
