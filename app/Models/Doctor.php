<?php

namespace App\Models;

use App\Models\AuthTokens\DoctorToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Doctor extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function tokens()
    {
        return $this->hasMany(DoctorToken::class);
    }

    public function invalidTokens() {
        return $this->hasMany(DoctorToken::class)->where(
            DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
            '>',
            DB::raw('`time_valid`')
        );
    }
}
