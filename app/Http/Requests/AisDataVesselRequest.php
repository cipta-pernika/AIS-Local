<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AisDataVesselRequest extends FormRequest
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
			'vessel_name' => 'string',
			'vessel_type' => 'string',
			'mmsi' => 'required|string',
			'callsign' => 'string',
			'dimension_to_bow' => 'string',
			'dimension_to_stern' => 'string',
			'dimension_to_port' => 'string',
			'dimension_to_starboard' => 'string',
			'reported_destination' => 'string',
			'out_of_range' => 'required',
			'no_pkk' => 'string',
			'jenis_layanan' => 'string',
			'nama_negara' => 'string',
			'tipe_kapal' => 'string',
			'nama_perusahaan' => 'string',
			'tgl_tiba' => 'string',
			'tgl_brangkat' => 'string',
			'bendera' => 'string',
			'dwt' => 'string',
			'nakhoda' => 'string',
			'jenis_trayek' => 'string',
			'pelabuhan_asal' => 'string',
			'pelabuhan_tujuan' => 'string',
			'lokasi_lambat_labuh' => 'string',
			'nomor_spog' => 'string',
			'jenis_muatan' => 'string',
			'no_pandu' => 'string',
			'nama_pandu' => 'string',
			'nama_kapal_eks' => 'string',
			'nama_kapal_pemilik' => 'string',
			'loa' => 'string',
			'isAssign' => 'required',
			'nama_kapal_inaportnet' => 'string',
        ];
    }
}
