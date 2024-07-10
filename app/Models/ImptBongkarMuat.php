<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImptBongkarMuat extends Model
{
    public $table = 'impt_bongkar_muats';

    protected $connection = 'mysql_second';

    public $fillable = [
        'id_impt_bongkar_muat',
        'no_pkk',
        'rkbm',
        'ais_data_vessel_id',
        'nomor_registrasi_cargo',
        'nama_kapal',
        'nama_perusahaan',
        'pemilik_barang',
        'jenis',
        'jumlah_tonase',
        'jumlah_biaya',
        'jumlah_pnbp',
        'kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'date',
        'image_mulai',
        'image_sedang',
        'image_selesai',
        'image_mulai_2',
        'image_sedang_2',
        'image_selesai_2',
        'image_mulai_3',
        'image_sedang_3',
        'image_selesai_3',
        'no_pkk_assign',
        'mmsi'
    ];

    protected $casts = [
        'no_pkk' => 'string',
        'rkbm' => 'string',
        'nomor_registrasi_cargo' => 'string',
        'nama_kapal' => 'string',
        'nama_perusahaan' => 'string',
        'pemilik_barang' => 'string',
        'jenis' => 'string',
        'kegiatan' => 'string',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'date' => 'datetime',
        'image_mulai' => 'string',
        'image_sedang' => 'string',
        'image_selesai' => 'string',
        'image_mulai_2' => 'string',
        'image_sedang_2' => 'string',
        'image_selesai_2' => 'string',
        'image_mulai_3' => 'string',
        'image_sedang_3' => 'string',
        'image_selesai_3' => 'string',
        'no_pkk_assign' => 'string',
        'mmsi' => 'string'
    ];

    public static array $rules = [
        'id_impt_bongkar_muat' => 'required',
        'no_pkk' => 'nullable|string|max:255',
        'rkbm' => 'nullable|string|max:255',
        'ais_data_vessel_id' => 'nullable',
        'nomor_registrasi_cargo' => 'nullable|string|max:255',
        'nama_kapal' => 'nullable|string|max:255',
        'nama_perusahaan' => 'nullable|string|max:255',
        'pemilik_barang' => 'nullable|string|max:255',
        'jenis' => 'nullable|string|max:255',
        'jumlah_tonase' => 'nullable',
        'jumlah_biaya' => 'nullable',
        'jumlah_pnbp' => 'nullable',
        'kegiatan' => 'nullable|string|max:255',
        'tanggal_mulai' => 'nullable',
        'tanggal_selesai' => 'nullable',
        'date' => 'nullable',
        'image_mulai' => 'nullable|string',
        'image_sedang' => 'nullable|string',
        'image_selesai' => 'nullable|string',
        'image_mulai_2' => 'nullable|string',
        'image_sedang_2' => 'nullable|string',
        'image_selesai_2' => 'nullable|string',
        'image_mulai_3' => 'nullable|string',
        'image_sedang_3' => 'nullable|string',
        'image_selesai_3' => 'nullable|string',
        'no_pkk_assign' => 'nullable|string|max:255',
        'mmsi' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function setImageMulaiAttribute($value)
    {
        if ($value) {
            $prefix = env('APP_URL');
            $filename = $prefix . time() . '.' . $value->getClientOriginalExtension();
            $path = $value->storeAs('images', $filename, 'public');
            $this->attributes['image_mulai'] = $filename;
        }
    }
    
}
