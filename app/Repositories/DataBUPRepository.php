<?php

namespace App\Repositories;

use App\Models\DataBUP;
use App\Repositories\BaseRepository;

class DataBUPRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id_rkbm',
        'ais_data_vessel_id',
        'pbm_kode',
        'no_pkk',
        'no_surat_keluar',
        'kade',
        'rencana_bongkar',
        'rencana_muat',
        'mulai_bongkar',
        'mulai_muat',
        'actual_mulai_bongkar',
        'actual_mulai_muat',
        'selesai_bongkar',
        'selesai_muat',
        'actual_selesai_bongkar',
        'actual_selesai_muat',
        'nomor_layanan_masuk',
        'nomor_layanan_sps',
        'nama_kapal',
        'gt_kapal',
        'panjang_kapal',
        'dwt',
        'siupal_pemilik',
        'siupal_operator',
        'bendera',
        'nama_perusahaan',
        'nomor_produk',
        'tipe_kapal',
        'pbm',
        'bongkar',
        'muat',
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
        'mmsi',
        'jenis_layanan',
        'nama_negara',
        'tgl_tiba',
        'tgl_brangkat',
        'no_imo',
        'call_sign',
        'nakhoda',
        'jenis_trayek',
        'pelabuhan_asal',
        'pelabuhan_tujuan',
        'lokasi_lambat_labuh',
        'waktu_respon',
        'nomor_spog',
        'no_pandu',
        'nama_pandu',
        'grt',
        'loa',
        'tanggal_pandu_naik_kapal',
        'tanggal_pandu_turun_kapal',
        'jam_pandu_naik_kapal',
        'jam_pandu_turun_kapal',
        'biaya_layanan',
        'jumlah_pnbp',
        'foto_di_kapal',
        'bpjp'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DataBUP::class;
    }
}
