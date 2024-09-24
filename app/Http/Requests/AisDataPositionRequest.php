<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AisDataPositionRequest extends FormRequest
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
			'sensor_data_id' => 'required',
			'vessel_id' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
			'speed' => 'required',
			'navigation_status' => 'string',
			'timestamp' => 'required',
			'is_inside_geofence' => 'required',
			'is_geofence' => 'required',
        ];
    }
}
