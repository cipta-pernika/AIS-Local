<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cctv
 *
 * @property $id
 * @property $url
 * @property $terminal_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Terminal $terminal
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cctv extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['url', 'terminal_id', 'type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function terminal()
    {
        return $this->belongsTo(\App\Models\Terminal::class, 'terminal_id', 'id');
    }
    
}
