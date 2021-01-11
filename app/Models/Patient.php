<?php

namespace App\Models;

use App\Models\AuthTokens\PatientToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public function tokens()
    {
        return $this->hasMany(PatientToken::class);
    }

    public function invalidTokens() {
        return $this->hasMany(PatientToken::class)->where(
                DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
                '>',
                DB::raw('`time_valid`')
        );
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = hash('sha256', $value);
    }

    public function scopeByPhone($query, $value)
    {
        return $query->where(DB::raw('CONCAT(`phone_code`, `phone`)'), $value);
    }
}
