<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'nullable|string|max:1000',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'img_path' => $imagePath,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully');
    }

    public function index()
    {
        $followedUsers = auth()->user()->following()->pluck('id');
        $posts = Post::whereIn('user_id', $followedUsers)
            ->orWhereHas('likes', '>', 10)
            ->latest()
            ->paginate(15);

        return view('home', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }


}
