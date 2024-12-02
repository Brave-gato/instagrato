<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


//Handles user profile operations
class ProfileController extends Controller
{
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
 /*   
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
*/
        public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'profile_photo' => 'nullable|image|max:5000'
        ]);

        if ($request->hasFile('profile_photo')) {
            $imagePath = $request->file('profile_photo')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);
            $image->save();
            $data['profile_photo'] = $imagePath;
        }

        auth()->user()->update($data);

        return redirect()->route('profile.show', auth()->user());
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
