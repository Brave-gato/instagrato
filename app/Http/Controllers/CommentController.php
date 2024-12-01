<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content']
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        
        return back();
    }
}