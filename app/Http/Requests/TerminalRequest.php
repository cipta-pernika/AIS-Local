<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalRequest extends FormRequest
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
			'name' => 'required|string',
			'latitude' => 'required',
			'longitude' => 'required',
			'radius' => 'string',
			'address' => 'string',
			'penanggung_jawab' => 'string',
			'no_izin_pengoperasian' => 'string',
			'tgl_izin_pengoperasian' => 'string',
			'penerbit_izin_pengoperasian' => 'string',
			'no_perjanjian_sewa_perairan' => 'string',
			'tgl_sewa_perairan' => 'string',
			'keterangan' => 'string',
			'masa_berlaku_izin_operasi' => 'string',
			'masa_berlaku_perjanjian_sewa_perairan' => 'string',
        ];
    }
}
