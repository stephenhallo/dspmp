<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobNotice extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->hasOne('App\Models\ArtistJob', 'id', 'job_id');
    }

}
