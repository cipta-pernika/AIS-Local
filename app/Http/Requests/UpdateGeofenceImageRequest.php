<?php

namespace App\Http\Requests;

use App\Models\GeofenceImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGeofenceImageRequest extends FormRequest
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
        $rules = GeofenceImage::$rules;
        
        return $rules;
    }
}
