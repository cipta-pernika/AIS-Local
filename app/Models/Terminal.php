<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Terminal
 *
 * @property $id
 * @property $pelabuhan_id
 * @property $name
 * @property $latitude
 * @property $longitude
 * @property $radius
 * @property $address
 * @property $penanggung_jawab
 * @property $no_izin_pengoperasian
 * @property $tgl_izin_pengoperasian
 * @property $penerbit_izin_pengoperasian
 * @property $no_perjanjian_sewa_perairan
 * @property $tgl_sewa_perairan
 * @property $luas_perairan
 * @property $jasa_pengunaan_perairan
 * @property $keterangan
 * @property $masa_berlaku_izin_operasi
 * @property $masa_berlaku_perjanjian_sewa_perairan
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Terminal extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pelabuhan_id', 'name', 'latitude', 'longitude', 'radius', 'address', 'penanggung_jawab', 'no_izin_pengoperasian', 'tgl_izin_pengoperasian', 'penerbit_izin_pengoperasian', 'no_perjanjian_sewa_perairan', 'tgl_sewa_perairan', 'luas_perairan', 'jasa_pengunaan_perairan', 'keterangan', 'masa_berlaku_izin_operasi', 'masa_berlaku_perjanjian_sewa_perairan'];


}
