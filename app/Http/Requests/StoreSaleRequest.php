<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'saleProducts' => 'required|array|min:1', // At least one sale product is required
            'saleProducts.*.product_id' => 'required|integer',
            'saleProducts.*.price' => 'required|numeric',
            'saleProducts.*.quantity' => 'required|numeric|min:1', // Quantity must be at least 1
            'saleProducts.*.discount' => 'required|numeric|between:0,100',
            'saleProducts.*.subtotal' => 'required|numeric',
            'saleProducts.*.tax' => 'required|numeric',

            'sale' => 'required|array',
            'sale.subtotal' => 'required|numeric|min:1',
            'sale.discount' => 'required|numeric',
            'sale.total' => 'required|numeric|between:0,100000000',
            'sale.tax' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'saleProducts.required' => 'At least one sale product is required.',
            'saleProducts.min' => 'At least one sale product is required.', // This message will be shown when there are no sale products provided
            'saleProducts.*.quantity.min' => 'Quantity must be at least 1.',
            'sale.customer_id.required' => 'The customer ID is required.',
            'sale.customer_id.integer' => 'Invalid customer ID.',
            // Add more custom messages for other rules as needed
        ];
    }
}
