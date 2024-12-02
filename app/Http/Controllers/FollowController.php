<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

// Gère les follow/unfollow functionality
class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        auth()->user()->following()->attach($user->id);
        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->following()->detach($user->id);
        return back();
    }
}