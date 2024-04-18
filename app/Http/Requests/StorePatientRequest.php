<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'date_of_birth' => 'required|date_format:Y-m-d|before:today',
            'address' => 'sometimes|nullable|string|max:255',
            'medical_record_number' => 'required|string|max:255',
            'medical_history' => 'nullable|string',
            'association_id' => 'nullable|exists:associations,id',
            'disease_id' => 'nullable|exists:diseases,id',
            'characteristics' => 'nullable',
        ];
    }
}
