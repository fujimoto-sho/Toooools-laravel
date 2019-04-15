<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Profile;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id ?? Auth::user()->id;
        $user = User::find($id);
        if (empty($user)) {
            return redirect('/');
        }

        $queryLikes = DB::raw("(SELECT post_id, COUNT(*) like_cnt FROM likes GROUP BY post_id) likesCnt");
        $queryReplies = DB::raw("(SELECT post_id, COUNT(*) reply_cnt FROM replies WHERE deleted_at is null GROUP BY post_id) repliesCnt");
        $posts = Post::select(
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
            ->leftJoin('likes', 'likes.user_id', '=', 'users.id')
            ->leftJoin($queryLikes, 'likesCnt.post_id', '=', 'posts.id')
            ->leftJoin($queryReplies, 'repliesCnt.post_id', '=', 'posts.id');

        if (!empty($request->isLikeShow)) {
            $posts->where('likes.user_id', '=', $id);
        } else {
            $posts->where('posts.user_id', '=', $id);
        }

        $posts->orderBy('posts.created_at', 'DESC');


        $posts = $posts->get();

        $param = [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('profile.index', $param);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $form = [
            'email' => $user->email,
            'name' => $user->name,
            'bio' => !empty($profile->bio) ? $profile->bio : '',
            'like_tool' => !empty($profile->like_tool) ? $profile->like_tool : '',
            'img' => !empty($profile->img_filename) ? Storage::disk('s3')->url($profile->img_filename) : '/img/avatar/default.png',
        ];

        return view('profile.edit', ['form' => $form]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id . ',id,deleted_at,NULL'],
            'bio' => ['max:500'],
            'like_tool' => ['max:30'],
            'img' => ['image','max:3000'],
        ]);

        if (isset($request->img)) {
            $filename = Storage::disk('s3')->putFile('img', $request->img, 'public');
            $path = Storage::disk('s3')->url($filename);
        }


        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();

        $profiles = Profile::where('user_id', $user->id)->get();
        if ($profiles->isEmpty()) {

            $profile = new Profile;
            $profile->user_id = Auth::user()->id;
            $profile->bio = $request->bio ?? '';
            $profile->like_tool = $request->like_tool ?? '';
            $profile->img_filename = $path ?? '';
            $profile->save();
        } else {
            $profile = $profiles[0];
            $profile->bio = $request->bio ?? '';
            $profile->like_tool = $request->like_tool ?? '';
            $profile->img_filename = $path ?? $profile->img_filename;
            $profile->save();
        }

        return redirect('/profile')->with('flash_msg', 'プロフィールを変更しました');
    }
}
