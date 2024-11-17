<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreProductRequest
 *
 * This request handles validation for storing a product. It ensures that the
 * input data conforms to the required rules and provides custom error messages
 * for specific fields.
 */
class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * For simplicity, this method currently allows all users to send this request.
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
     * These rules ensure that the required fields are present and formatted correctly.
     *
     * @return array<string, string> An array of field rules.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
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
        ];
    }
}
