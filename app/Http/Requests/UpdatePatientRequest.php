<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255',
            'phone' => 'sometimes|string|max:255|',
            'date_of_birth' => 'sometimes|date_format:Y-m-d|before:today',
            'address' => 'sometimes|nullable|string|max:255',
            'medical_record_number' => 'sometimes|string|max:255',
            'medical_history' => 'sometimes|nullable|string',
            'association_id' => 'sometimes|exists:associations,id',
            'disease_id' => 'sometimes',
            'characteristics' => 'sometimes',
        ];
    }
}
