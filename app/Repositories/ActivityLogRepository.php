<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use App\Repositories\BaseRepository;

class ActivityLogRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ActivityLog::class;
    }
}
