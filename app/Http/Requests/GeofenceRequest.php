<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeofenceRequest extends FormRequest
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
			'geofence_name' => 'string',
			'type' => 'string',
			'type_geo' => 'string',
			'radius' => 'string',
			'isMaster' => 'required',
        ];
    }
}
