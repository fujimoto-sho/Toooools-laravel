<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $onePage = 10;

        $order = $request->order ?? 'create_desc';
        $search_target = $request->search_target ?? 'tool_name';
        $search_word = $request->search_word ?? '';

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

        if (!empty($search_word)) {
            $target = 'posts.name';
            if ($search_target === 'tool_introduction') $target = 'posts.introduction';


            $posts->where($target, '=', $search_word);
        }

        switch ($order) {
            case 'create_desc':
                $posts->orderBy('posts.created_at', 'DESC');
                break;
            case 'create_asc':
                $posts->orderBy('posts.created_at', 'ASC');
                break;
            case 'like_desc':
                $posts->orderBy('likesCnt.like_cnt', 'DESC');
                break;
        }

        $posts = $posts->paginate($onePage);

        $postCount = $posts->total();
        $pageCount = (int)($request->page ?? 1);
        // 表示中の最小件数
        $minPostNum = (($pageCount - 1) * $onePage) + 1;
        if ($minPostNum < $postCount) $minPostNum = $postCount;
        // 表示中の最大件数
        $maxPostNum = ($pageCount  * $onePage);
        if ($maxPostNum > $postCount) $maxPostNum = $postCount;

        $param = [
            'order' => $order,
            'search_target' => $search_target,
            'search_word' => $search_word,
            'minPostNum' => $minPostNum,
            'maxPostNum' => $maxPostNum,
            'postCount' => $postCount,
            'posts' => $posts,
        ];
        return view('post.index', $param);
    }

    public function create(Request $request)
    {
        $form = [
            'name' => '',
            'introduction' => '',
            'url' => '',
            'img_filename' => '/img/tool/default.png',
        ];
        return view('post.edit', ['form' => $form, 'title' => '新規投稿']);
    }

    public function store(Request $request)
    {
        $this->validate($request, Post::$rules);

        $filename = '';
        if (isset($request->img)) {
            $filename = '/storage/' . $request->img->store('/img/tool');
        }

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->name = $request->name;
        $post->introduction = $request->introduction;
        $post->url = $request->url;
        $post->img_filename = $filename;
        $post->save();
        return redirect('/home')->with('flash_msg', '投稿しました');
    }

    public function edit(Request $request)
    {
        $posts = Post::where('id', '=', $request->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        if ($posts->isEmpty()) {
            return redirect('/post/create');
        }

        $post = $posts[0];
        $post->img_filename = empty($post->img_filename) ? '/img/tool/default.png' : $post->img_filename;
        return view('post.edit', ['form' => $post, 'title' => '投稿編集']);
    }

    public function update(Request $request)
    {
        $this->validate($request, Post::$rules);

        if (isset($request->img)) {
            $filename = '/storage/' . $request->img->store('/img/tool');
        }

        $post = Post::find($request->id);
        $post->user_id = Auth::user()->id;
        $post->name = $request->name;
        $post->introduction = $request->introduction;
        $post->url = $request->url;
        $post->img_filename = $filename ?? $post->img_filename;
        $post->save();
        return redirect('/home')->with('flash_msg', '投稿を編集しました');
    }

    public function show(Request $request)
    {
        $queryLikes = DB::raw("(SELECT post_id, COUNT(*) like_cnt FROM likes GROUP BY post_id) likesCnt");
        $queryReplies = DB::raw("(SELECT post_id, COUNT(*) reply_cnt FROM replies WHERE deleted_at is null GROUP BY post_id) repliesCnt");
        $post = Post::select(
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
            ->leftJoin($queryReplies, 'repliesCnt.post_id', '=', 'posts.id')
            ->where('posts.id','=', $request->id)
            ->first();

        if (empty($post)) {
            return redirect('/');
        }

        $replies = Reply::select(
                'replies.message',
                'replies.created_at',
                'users.name',
                'profiles.img_filename',
            )
            ->leftJoin('users', 'users.id', '=', 'replies.user_id')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('post_id', '=', $request->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('post.show', ['post' => $post, 'replies' => $replies]);
    }

    public function reply(Request $request)
    {
        $this->validate($request, Reply::$rules);

        $reply = new Reply;
        $reply->user_id = Auth::user()->id;
        $reply->post_id = $request->id;
        $reply->message = $request->message;
        $reply->save();

        return back();
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        DB::transaction(function () use ($id) {
            Post::find($id)->delete();
            Reply::where('post_id', '=', $id)->delete();
            Like::where('post_id', '=', $id)->delete();
        });
        return redirect('/');
    }
}
