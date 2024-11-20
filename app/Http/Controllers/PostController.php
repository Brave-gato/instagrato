<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /*Ceci signifie que l'utilisateur doit être authentifié pour accéder à toutes les autres méthodes du contrôleur, show et index. Il faut configurer l'authentification avec la commande 'composer require laravel/ui' et après 'php artisan ui vue --auth'*/
    /*Cette méthode est appelée pour afficher la page d'accueil, qui affiche les derniers posts de tous les utilisateurs suivis par l'utilisateur connecté, ainsi que les posts avec plus de 10 likes. Les posts sont triés par date décroissante.*/
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    /*public function index()
    {
        $followedUsers = auth()->user()->following()->pluck('id');

        $posts = Post::whereIn('user_id', $followedUsers)
            ->orWhereHas('likes', function ($query) {
                $query->havingRaw('COUNT(*) > ?', [10]);
            })
            ->latest()
            ->paginate(15);

        $posts = Post::with('user')->latest()->paginate(15);
        return view('home', compact('posts'));
    }*/

        public function index()
    {
        if (auth()->check()) {
            $followedUsers = auth()->user()->following()->get()->pluck('id');
            $posts = Post::whereIn('user_id', $followedUsers)
                         ->orWhere('user_id', auth()->id())
                         ->latest()
                         ->paginate(10);
        } else {
            // Si l'utilisateur n'est pas connecté, affichez peut-être les posts les plus populaires
            $posts = Post::withCount('likes')
                         ->orderByDesc('likes_count')
                         ->take(10)
                         ->get();
        }

        return view('posts.index', compact('posts'));
    }

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

        return redirect()->route('home')->with('success', 'Publication créée.');
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
