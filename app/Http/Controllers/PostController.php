<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /*CRUD operations. Cette méthode est appelée pour afficher la page d'accueil, qui affiche les derniers posts de tous les utilisateurs suivis par l'utilisateur connecté, ainsi que les posts avec plus de 10 likes. Les posts sont triés par date décroissante.*/
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $following_ids = auth()->user()->following()->get()->pluck('id');
        $posts = Post::whereIn('user_id', $following_ids)

            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'nullable|string|max:2200',
            'image' => 'required|image|max:5000'
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');


        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'img_path' => $imagePath,
        ]);

        // return redirect()->route('profile.show', auth()->user());
        return redirect()->route('home')->with('succès', 'Publication créée.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        Storage::delete('public/' . $post->img_path);
        $post->delete();

        return redirect()->route('profile.show', auth()->user());
    }
}
