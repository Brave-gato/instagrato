<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Intervention\Image\Facades\Image;

//Handles user profile operations
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
      public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    public function show(User $user)
    {
        $posts = $user->posts()->latest()->paginate(12);
        return view('profile.show', compact('user', 'posts'));
    }
    
    // Display the user's profile form.
      
        public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }
    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . auth()->id(),
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);
        $request->user()->fill($data);
        
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        if ($request->hasFile('profile_photo')) {
            $imagePath = $request->file('profile_photo')->store('profile', 'public');
            $data['profile_photo'] = $imagePath;
        }

        auth()->user()->update($data);

        return Redirect::back()->with('status', 'profile-updated');
        
    }
}