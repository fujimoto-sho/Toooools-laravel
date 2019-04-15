<?php

namespace App;

use Illuminate\Support\Facades\DB;
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

    protected $guarded = array('id');

    public function scopePostItem($query, $userId)
    {
        $queryLikes = DB::raw("(SELECT post_id, COUNT(*) like_cnt FROM likes GROUP BY post_id) likesCnt");
        $queryReplies = DB::raw("(SELECT post_id, COUNT(*) reply_cnt FROM replies WHERE deleted_at is null GROUP BY post_id) repliesCnt");
        $query->select(
                'users.id AS user_id',
                'users.name AS user_name',
                'profiles.img_filename AS user_img',
                'posts.id AS post_id',
                'posts.name AS post_name',
                'posts.introduction',
                'posts.url',
                'posts.img_filename AS post_img',
                'posts.created_at',
                'likesCnt.like_cnt',
                'repliesCnt.reply_cnt',
                'likes.id AS is_like',
            )
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->leftJoin($queryLikes, 'likesCnt.post_id', '=', 'posts.id')
            ->leftJoin($queryReplies, 'repliesCnt.post_id', '=', 'posts.id')
            ->leftJoin('likes', function ($join) use ($userId) {
                $join->on('likes.post_id', '=', 'posts.id')
                    ->where('likes.user_id', '=', $userId);
            });
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
