<?php

namespace App\Models;

use App\Models\AuthTokens\AdministratorToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Administrator extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function tokens()
    {
        return $this->hasMany(AdministratorToken::class);
    }

    public function invalidTokens() {
        return $this->hasMany(AdministratorToken::class)->where(
            DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
            '>',
            DB::raw('`time_valid`')
        );
    }
}
