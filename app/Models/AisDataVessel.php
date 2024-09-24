<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AisDataVessel
 *
 * @property $id
 * @property $vessel_name
 * @property $vessel_type
 * @property $mmsi
 * @property $imo
 * @property $callsign
 * @property $draught
 * @property $dimension_to_bow
 * @property $dimension_to_stern
 * @property $dimension_to_port
 * @property $dimension_to_starboard
 * @property $reported_destination
 * @property $out_of_range
 * @property $type_number
 * @property $reported_eta
 * @property $no_pkk
 * @property $jenis_layanan
 * @property $nama_negara
 * @property $tipe_kapal
 * @property $nama_perusahaan
 * @property $tgl_tiba
 * @property $tgl_brangkat
 * @property $bendera
 * @property $gt_kapal
 * @property $dwt
 * @property $nakhoda
 * @property $jenis_trayek
 * @property $pelabuhan_asal
 * @property $pelabuhan_tujuan
 * @property $lokasi_lambat_labuh
 * @property $nomor_spog
 * @property $jenis_muatan
 * @property $no_pandu
 * @property $nama_pandu
 * @property $nama_kapal_eks
 * @property $nama_kapal_pemilik
 * @property $loa
 * @property $counting_hari
 * @property $tgl_counting_hari
 * @property $last_update_counting
 * @property $isAssign
 * @property $nama_kapal_inaportnet
 * @property $created_at
 * @property $updated_at
 *
 * @property AisDataPosition[] $aisDataPositions
 * @property BongkarMuatTerlambat[] $bongkarMuatTerlambats
 * @property Certificate[] $certificates
 * @property DataMandiriKapal[] $dataMandiriKapals
 * @property PanduTerlambat[] $panduTerlambats
 * @property PanduTidakTerjadwal[] $panduTidakTerjadwals
 * @property PkkAssignHistory[] $pkkAssignHistories
 * @property PkkHistory[] $pkkHistories
 * @property PnbpJasaLabuhKapal[] $pnbpJasaLabuhKapals
 * @property TidakTerjadwal[] $tidakTerjadwals
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AisDataVessel extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['vessel_name', 'vessel_type', 'mmsi', 'imo', 'callsign', 'draught', 'dimension_to_bow', 'dimension_to_stern', 'dimension_to_port', 'dimension_to_starboard', 'reported_destination', 'out_of_range', 'type_number', 'reported_eta', 'no_pkk', 'jenis_layanan', 'nama_negara', 'tipe_kapal', 'nama_perusahaan', 'tgl_tiba', 'tgl_brangkat', 'bendera', 'gt_kapal', 'dwt', 'nakhoda', 'jenis_trayek', 'pelabuhan_asal', 'pelabuhan_tujuan', 'lokasi_lambat_labuh', 'nomor_spog', 'jenis_muatan', 'no_pandu', 'nama_pandu', 'nama_kapal_eks', 'nama_kapal_pemilik', 'loa', 'counting_hari', 'tgl_counting_hari', 'last_update_counting', 'isAssign', 'nama_kapal_inaportnet'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aisDataPositions()
    {
        return $this->hasMany(\App\Models\AisDataPosition::class, 'id', 'vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bongkarMuatTerlambats()
    {
        return $this->hasMany(\App\Models\BongkarMuatTerlambat::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificates()
    {
        return $this->hasMany(\App\Models\Certificate::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataMandiriKapals()
    {
        return $this->hasMany(\App\Models\DataMandiriKapal::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTerlambats()
    {
        return $this->hasMany(\App\Models\PanduTerlambat::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTidakTerjadwals()
    {
        return $this->hasMany(\App\Models\PanduTidakTerjadwal::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pkkAssignHistories()
    {
        return $this->hasMany(\App\Models\PkkAssignHistory::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pkkHistories()
    {
        return $this->hasMany(\App\Models\PkkHistory::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pnbpJasaLabuhKapals()
    {
        return $this->hasMany(\App\Models\PnbpJasaLabuhKapal::class, 'id', 'ais_data_vessel_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tidakTerjadwals()
    {
        return $this->hasMany(\App\Models\TidakTerjadwal::class, 'id', 'ais_data_vessel_id');
    }
    
}
