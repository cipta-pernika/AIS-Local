<?php

namespace App\Http\Requests;

use App\Models\AisDataAnomaly;
use Illuminate\Foundation\Http\FormRequest;

class CreateAisDataAnomalyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AisDataAnomaly::$rules;
    }
}
