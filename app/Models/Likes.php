<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table = 'patients_likes_doctors';

    public $timestamps = false;
}
