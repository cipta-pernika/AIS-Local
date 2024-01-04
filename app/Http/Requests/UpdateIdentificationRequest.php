<?php

namespace App\Http\Requests;

use App\Models\Identification;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIdentificationRequest extends FormRequest
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
        $rules = Identification::$rules;
        
        return $rules;
    }
}
