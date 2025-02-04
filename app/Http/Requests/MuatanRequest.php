<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MuatanRequest extends FormRequest
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
			'mmsi' => 'required|string',
			'curah_kering_food_grain' => 'required',
			'curah_kering_non_food_grain' => 'required',
			'general_cargo' => 'required',
			'petikemas_20' => 'required',
			'petikemas_40' => 'required',
			'curah_cair' => 'required',
        ];
    }
}
