<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitAttachment extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $table = 'visit_attachments';
}
