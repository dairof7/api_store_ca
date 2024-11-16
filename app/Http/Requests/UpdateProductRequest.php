<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category' => 'sometimes|required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Claves permitidas en el payload
            $allowedKeys = ['name', 'description', 'price', 'category'];

            // Verificar si al menos una clave válida está presente
            $inputKeys = array_keys($this->all());
            $hasValidKeys = !empty(array_intersect($inputKeys, $allowedKeys));

            if (!$hasValidKeys) {
                $validator->errors()->add('fields', 'Debe proporcionar al menos un campo válido para actualizar.');
            }
        });
    }
}
