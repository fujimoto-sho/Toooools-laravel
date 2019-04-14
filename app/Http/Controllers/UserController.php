<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Post;
use App\Reply;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function withdraw(Request $request)
    {
        return view('user.withdraw');
    }

    public function remove(Request $request)
    {
        DB::transaction(function () {
            $id = Auth::user()->id;
            User::find($id)->delete();
            Profile::where('user_id', '=', $id)->delete();
            Post::where('user_id', '=', $id)->delete();
            Reply::where('user_id', '=', $id)->delete();
            Like::where('user_id', '=', $id)->delete();
        });
        return redirect('/login');
    }

    public function pass_edit(Request $request)
    {
        return view('user.pass_edit');
    }

    public function pass_update(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $messages = new MessageBag;
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            $messages->add('old_password', '現在のパスワードが違います');
        }
        if ($request->old_password === $request->password) {
            $messages->add('password', '現在のパスワードと新しいパスワードが同じです');
        }
        if ($messages->hasAny()) {
            return back()->withInput()->withErrors($messages);
        }

        $user->fill(['password' => Hash::make($request->password)])
            ->save();

        $request->session()->flash('flash_msg', 'パスワードを変更しました');
        return redirect('/profile');
     }
}
