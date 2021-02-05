<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Illness extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(IllnessStatus::class, 'illness_status_id');
    }
}
