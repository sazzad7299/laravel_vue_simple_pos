<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSMSRequest extends FormRequest
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
            'SMS_METHOD'=>'required',
            'TWILIO_TOKEN' => 'required_if:SMS_METHOD,TWILIO',
            'TWILIO_SID' => 'required_if:SMS_METHOD,TWILIO',
            'TWILIO_SERVICE_SID' => 'required_if:SMS_METHOD,TWILIO',
            'TWILIO_FROM' => 'required_if:SMS_METHOD,TWILIO',
            'RELEANS_API_KEY' => 'required_if:SMS_METHOD,RELEANS',
            'RELEANS_API_FROM' => 'required_if:SMS_METHOD,RELEANS',
            'MSG91_AUTH_KEY' => 'required_if:SMS_METHOD,MSG91',
            'MSG91_TEMPLATE_ID' =>'required_if:SMS_METHOD,MSG91',
            'TWOFACTORS_API_KEY' =>'required_if:SMS_METHOD,2FACTOR',
        ];
    }
}
