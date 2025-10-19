<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|between:0,99999999.99',
            'min_stock' => 'nullable|integer|min:1',
            'category_name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'status' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.string' => 'El nombre del producto debe ser una cadena de texto.',
            'name.max' => 'El nombre del producto no debe exceder los 255 caracteres.',
            'sku.string' => 'El SKU debe ser una cadena de texto.',
            'sku.max' => 'El SKU no debe exceder los 255 caracteres.',
            'barcode.string' => 'El código de barras debe ser una cadena de texto.',
            'barcode.max' => 'El código de barras no debe exceder los 255 caracteres.',
            'image_url.string' => 'La URL de la imagen debe ser una cadena de texto.',
            'image_url.max' => 'La URL de la imagen no debe exceder los 200 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un valor numérico.',
            'price.between' => 'El precio debe estar entre 0 y 99999999.99.',
            'min_stock.integer' => 'El stock mínimo debe ser un número entero.',
            'min_stock.min' => 'El stock mínimo debe ser al menos 1.',
            'category_name.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'category_name.max' => 'El nombre de la categoría no debe exceder los 255 caracteres.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'status.string' => 'El estado debe ser una cadena de texto.',
            'status.max' => 'El estado no debe exceder los 255 caracteres.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
