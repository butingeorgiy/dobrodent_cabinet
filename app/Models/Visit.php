<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function status()
    {
        return $this->belongsTo(VisitStatus::class, 'visit_status_id', 'id');
    }

    public function illness()
    {
        return $this->belongsTo(Illness::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function attachments()
    {
        return $this->hasMany(VisitAttachment::class);
    }
}
