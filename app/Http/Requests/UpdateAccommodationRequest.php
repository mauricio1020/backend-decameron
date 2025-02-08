<?php

namespace App\Http\Requests;

use App\Models\RoomType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccommodationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_id' => 'sometimes|required|exists:hotels,id',
            'room_type_id' => 'sometimes|required|exists:room_types,id',
            'type' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer|min:1',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('room_type_id') && $this->has('type')) {
                $roomTypeId = $this->input('room_type_id');
                $type = $this->input('type');

                $roomType = RoomType::findOrFail($roomTypeId);

                if ($roomType->name === 'Estándar' && !in_array($type, ['Sencilla', 'Doble'])) {
                    $validator->errors()->add('type', 'La acomodación no es válida para este tipo de habitación.');
                }
                if ($roomType->name === 'Junior' && !in_array($type, ['Triple', 'Cuádruple'])) {
                    $validator->errors()->add('type', 'La acomodación no es válida para este tipo de habitación.');
                }
                if ($roomType->name === 'Suite' && !in_array($type, ['Sencilla', 'Doble', 'Triple'])) {
                    $validator->errors()->add('type', 'La acomodación no es válida para este tipo de habitación.');
                }
            }
        });
    }
}
