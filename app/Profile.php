<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    // 値を用意しない項目
    protected $guarded = array('id');

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
