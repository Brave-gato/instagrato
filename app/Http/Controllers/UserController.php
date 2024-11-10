<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;


class UserController extends Controller
{
    public function edit()
    {
        return view('users.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show', $user)->with('success', 'Profil mis à jour');
    }

    public function follow(User $user)
    {
        auth()->user()->following()->attach($user->id);
        return back()->with('success', 'Vous suivez ' . $user->name);
    }


    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->id);
        return back()->with('success', 'Vous ne suivez plus ' . $user->name);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%$query%")->get();
        $posts = Post::where('caption', 'like', "%$query%")->get();

        return view('search.results', compact('users', 'posts'));
    }


    public function show(User $user)
    {
        $posts = $user->posts()->latest()->paginate(12);
        return view('users.show', compact('user', 'posts'));
    }
}
