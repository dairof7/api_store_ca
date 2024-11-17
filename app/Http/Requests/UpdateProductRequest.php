<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProductRequest
 *
 * This request handles validation for updating an existing product. It ensures that
 * the input data conforms to the required rules for product updates and provides
 * custom error messages for specific fields.
 */
class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method currently allows all users to send this request.
     * You can modify this logic to implement authorization based on user roles
     * or permissions.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define the validation rules for the request.
     *
     * These rules are applied when updating a product. Fields like 'name', 'price',
     * and 'category' are optional but, if provided, they must meet specific criteria.
     *
     * @return array<string, string> An array of field rules.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category' => 'sometimes|required|string|max:255',
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * This method allows you to provide user-friendly error messages for specific
     * validation rules. These messages will be returned in the response when
     * validation fails.
     *
     * @return array<string, string> An array of custom error messages.
     */
    public function messages(): array
    {
        return [
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }

    /**
     * Additional validation logic after the default validation.
     *
     * This method allows you to perform custom validation checks, such as verifying
     * that at least one valid field is provided for the update. If no valid field is found,
     * an error is added to the validator.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // List of allowed keys in the request payload
            $allowedKeys = ['name', 'description', 'price', 'category'];

            // Check if at least one valid key is present in the input
            $inputKeys = array_keys($this->all());
            $hasValidKeys = !empty(array_intersect($inputKeys, $allowedKeys));

            if (!$hasValidKeys) {
                $validator->errors()->add('fields', 'Debe proporcionar al menos un campo válido para actualizar.');
            }
        });
    }
}
