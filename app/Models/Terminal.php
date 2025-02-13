<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Terminal extends Model
{
    public $table = 'terminals';

    public $fillable = [
        'pelabuhan_id',
        'name',
        'latitude',
        'longitude',
        'radius',
        'address',
        'penanggung_jawab',
        'no_izin_pengoperasian',
        'tgl_izin_pengoperasian',
        'penerbit_izin_pengoperasian',
        'no_perjanjian_sewa_perairan',
        'tgl_sewa_perairan',
        'luas_perairan',
        'jasa_pengunaan_perairan',
        'keterangan',
        'masa_berlaku_izin_operasi',
        'masa_berlaku_perjanjian_sewa_perairan'
    ];

    protected $casts = [
        'name' => 'string',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
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
        'masa_berlaku_perjanjian_sewa_perairan' => 'string'
    ];

    public static array $rules = [
        'pelabuhan_id' => 'nullable',
        'name' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'radius' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'penanggung_jawab' => 'nullable|string|max:255',
        'no_izin_pengoperasian' => 'nullable|string|max:255',
        'tgl_izin_pengoperasian' => 'nullable|string|max:255',
        'penerbit_izin_pengoperasian' => 'nullable|string|max:255',
        'no_perjanjian_sewa_perairan' => 'nullable|string|max:255',
        'tgl_sewa_perairan' => 'nullable|string|max:255',
        'luas_perairan' => 'nullable',
        'jasa_pengunaan_perairan' => 'nullable',
        'keterangan' => 'nullable|string|max:255',
        'masa_berlaku_izin_operasi' => 'nullable|string|max:255',
        'masa_berlaku_perjanjian_sewa_perairan' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function pelabuhan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pelabuhan::class, 'pelabuhan_id');
    }
}
