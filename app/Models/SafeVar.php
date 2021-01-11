<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SafeVar extends Model
{
    protected $primaryKey = 'uuid';

    protected $guarded = [];

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';


    public function scopeAvailable($query)
    {
        return $query->where(
            DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
            '<',
            DB::raw('`destroy_time`')
        );
    }

    public function scopeNotAvailable($query)
    {
        return $query->where(
            DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
            '>',
            DB::raw('`destroy_time`')
        );
    }
}
