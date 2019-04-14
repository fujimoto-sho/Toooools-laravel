<?php

namespace App\Http\Controllers\Ajax;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function ajax(Request $request)
    {
        if (!Auth::check()) {
            $userId = Auth::user()->id;
            $postId = $request->id;

            $like = Like::where('post_id', '=', $postId)
                ->where('user_id', '=', $userId)
                ->first();

            if (empty($like)) {
                $like = new Like;
                $like->user_id = $userId;
                $like->post_id = $postId;
                $like->save();
            } else {
                $like->delete();
            }

            return Like::where('post_id', '=', $postId)->count();
        }
    }
}
