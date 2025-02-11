<?php

namespace App\Repositories;

use App\Models\CameraCapture;
use App\Repositories\BaseRepository;

class CameraCaptureRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'pelabuhan_id',
        'geofence_id',
        'image'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CameraCapture::class;
    }
}
