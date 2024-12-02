<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

//Implemente la recherche de user et post
class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->get('q');
        
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get();
            
        $posts = Post::where('caption', 'like', "%{$query}%")
            ->with('user')
            ->take(5)
            ->get();

        return view('search.results', compact('users', 'posts', 'query'));
    }
}