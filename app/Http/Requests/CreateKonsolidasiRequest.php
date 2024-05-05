<?php

namespace App\Http\Requests;

use App\Models\Konsolidasi;
use Illuminate\Foundation\Http\FormRequest;

class CreateKonsolidasiRequest extends FormRequest
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
        return Konsolidasi::$rules;
    }
}
