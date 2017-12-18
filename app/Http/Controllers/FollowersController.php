<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        if (Auth::user()->id === $user->id) {
            session()->flash('warning', '不允许关注自己');
            return redirect()->back();
        }

        if (! Auth::user()->isFollowing($user->id)) {
            session()->flash('success', '关注成功');
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            session()->flash('warning', '不允许取消关注自己');
            return redirect()->back();
        }

        if (Auth::user()->isFollowing($user->id)) {
            session()->flash('success', '取消关注成功');
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user    );
    }
}
