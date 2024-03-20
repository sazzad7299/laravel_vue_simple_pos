<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralInfoRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_contanct_no' => 'required|numeric|digits_between:1,15',
            'company_address' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'logo' => 'nullable',
            'icon' => 'nullable',
            'currency_symbol' => 'required|string|max:2',
            'currency_code' => 'required|string|max:10',
        ];
    }
}