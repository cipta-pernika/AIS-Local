<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VesselList20240621Request extends FormRequest
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
			'name' => 'string',
			'name_ais' => 'string',
			'vessel_type' => 'string',
			'vessel_type_specific' => 'string',
			'home_port' => 'string',
			'status' => 'string',
        ];
    }
}
