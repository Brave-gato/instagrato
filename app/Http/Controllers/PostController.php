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
/*
    public function index()
    {
        $following_ids = auth()->user()->following()->pluck('users.id');
        $posts = Post::whereIn('user.id', $following_ids)
            ->orWhereHas('likes', '>', 0)
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }
*/

        public function index()
    {
        
            $following_ids = auth()->user()->following()->pluck('id');
            $posts = Post::whereIn('user.id', $following_ids)
                ->orWhereHas('likes', function ($query) {
                    $query->where('id', '>', 0); // ou toute autre condition que vous souhaitez
                })
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

        // Resize image
       // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        //$image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'img_path' => $imagePath,
        ]);

       // return redirect()->route('profile.show', auth()->user());
            return redirect()->route('home')->with('success', 'Publication créée.');

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