<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    // 値を用意しない項目
    protected $fillable = ['user_id', 'post_id', 'message'];

    public static $rules = array(
        'message' => ['required', 'max:140'],
    );
}
