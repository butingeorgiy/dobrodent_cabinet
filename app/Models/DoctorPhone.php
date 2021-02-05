<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPhone extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $table = 'doctor_phones';
}
