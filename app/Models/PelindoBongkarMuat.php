<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelindoBongkarMuat extends Model
{
    public $table = 'pelindo_bongkar_muats';

    public $fillable = [
        'no_pkk',
        'ais_data_vessel_id',
        'nama_kapal',
        'nama_agent',
        'ppk',
        'gt_kapal',
        'dwt',
        'loa',
        'nama_dermaga',
        'rea_mulai_bm',
        'rea_selesai_bm',
        'jumlah_biaya',
        'jumlah_pnbp',
        'id_rkbm',
        'pbm',
        'kegiatan_bongkar_muat',
        'jenis_barang',
        'jumlah_barang',
        'rea_mulai_tambat',
        'rea_selesai_tambat',
        'created_at_pelindo',
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
        'nama_kapal' => 'string',
        'nama_agent' => 'string',
        'ppk' => 'string',
        'nama_dermaga' => 'string',
        'rea_mulai_bm' => 'string',
        'rea_selesai_bm' => 'string',
        'id_rkbm' => 'string',
        'pbm' => 'string',
        'kegiatan_bongkar_muat' => 'string',
        'jenis_barang' => 'string',
        'rea_mulai_tambat' => 'datetime',
        'rea_selesai_tambat' => 'datetime',
        'created_at_pelindo' => 'datetime',
        'image_mulai' => 'string',
        'image_sedang' => 'string',
        'image_selesai' => 'string',
        'no_pkk_assign' => 'string',
        'mmsi' => 'string'
    ];

    public static array $rules = [
        'no_pkk' => 'required|string|max:255',
        'ais_data_vessel_id' => 'nullable',
        'nama_kapal' => 'nullable|string|max:255',
        'nama_agent' => 'nullable|string|max:255',
        'ppk' => 'nullable|string|max:255',
        'gt_kapal' => 'nullable',
        'dwt' => 'nullable',
        'loa' => 'nullable',
        'nama_dermaga' => 'nullable|string|max:255',
        'rea_mulai_bm' => 'nullable|string|max:255',
        'rea_selesai_bm' => 'nullable|string|max:255',
        'jumlah_biaya' => 'nullable',
        'jumlah_pnbp' => 'nullable',
        'id_rkbm' => 'nullable|string|max:255',
        'pbm' => 'nullable|string|max:255',
        'kegiatan_bongkar_muat' => 'nullable|string|max:255',
        'jenis_barang' => 'nullable|string|max:255',
        'jumlah_barang' => 'nullable',
        'rea_mulai_tambat' => 'nullable',
        'rea_selesai_tambat' => 'nullable',
        'created_at_pelindo' => 'nullable',
        'image_mulai' => 'nullable|string',
        'image_sedang' => 'nullable|string',
        'image_selesai' => 'nullable|string',
        'no_pkk_assign' => 'nullable|string|max:255',
        'mmsi' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
