<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    public static $rules = array(
        'name' => ['required', 'max:30'],
        'introduction' => ['required', 'max:500'],
        'url' => ['url', 'max:1000'],
        'img' => ['image','max:3000'],
    );

    // 値を用意しない項目
    protected $guarded = array('id');

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
