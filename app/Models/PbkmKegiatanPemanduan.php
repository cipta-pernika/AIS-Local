<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PbkmKegiatanPemanduan extends Model
{
    public $table = 'pbkm_kegiatan_pemanduans';

    public $fillable = [
        'nomor_spk_pandu',
        'no_pkk',
        'ais_data_vessel_id',
        'tanggal_spk_pandu',
        'nomor_imo',
        'nomor_spog',
        'npwp_agent',
        'nama_agent',
        'kode_dermaga_awal',
        'nama_dermaga_awal',
        'nama_dermaga_tujuan',
        'no_pandu',
        'nama_pandu',
        'nama_kapal',
        'bendera_kapal',
        'grt',
        'dwt',
        'loa',
        'tanggal_pandu_naik_kapal',
        'tanggal_pandu_turun_kapal',
        'jam_pandu_naik_kapal',
        'jam_pandu_turun_kapal',
        'biaya_layanan',
        'jumlah_pnbp'
    ];

    protected $casts = [
        'nomor_spk_pandu' => 'string',
        'no_pkk' => 'string',
        'tanggal_spk_pandu' => 'datetime',
        'nomor_imo' => 'string',
        'nomor_spog' => 'string',
        'npwp_agent' => 'string',
        'nama_agent' => 'string',
        'kode_dermaga_awal' => 'string',
        'nama_dermaga_awal' => 'string',
        'nama_dermaga_tujuan' => 'string',
        'no_pandu' => 'string',
        'nama_pandu' => 'string',
        'nama_kapal' => 'string',
        'bendera_kapal' => 'string',
        'tanggal_pandu_naik_kapal' => 'date',
        'tanggal_pandu_turun_kapal' => 'date'
    ];

    public static array $rules = [
        'nomor_spk_pandu' => 'required|string|max:255',
        'no_pkk' => 'required|string|max:255',
        'ais_data_vessel_id' => 'nullable',
        'tanggal_spk_pandu' => 'nullable',
        'nomor_imo' => 'nullable|string|max:255',
        'nomor_spog' => 'nullable|string|max:255',
        'npwp_agent' => 'nullable|string|max:255',
        'nama_agent' => 'nullable|string|max:255',
        'kode_dermaga_awal' => 'nullable|string|max:255',
        'nama_dermaga_awal' => 'nullable|string|max:255',
        'nama_dermaga_tujuan' => 'nullable|string|max:255',
        'no_pandu' => 'nullable|string|max:255',
        'nama_pandu' => 'nullable|string|max:255',
        'nama_kapal' => 'nullable|string|max:255',
        'bendera_kapal' => 'nullable|string|max:255',
        'grt' => 'nullable',
        'dwt' => 'nullable',
        'loa' => 'nullable',
        'tanggal_pandu_naik_kapal' => 'nullable',
        'tanggal_pandu_turun_kapal' => 'nullable',
        'jam_pandu_naik_kapal' => 'nullable',
        'jam_pandu_turun_kapal' => 'nullable',
        'biaya_layanan' => 'nullable',
        'jumlah_pnbp' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
