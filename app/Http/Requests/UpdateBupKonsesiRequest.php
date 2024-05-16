<?php

namespace App\Http\Requests;

use App\Models\BupKonsesi;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBupKonsesiRequest extends FormRequest
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
        $rules = BupKonsesi::$rules;
        
        return $rules;
    }
}
