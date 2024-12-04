@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Editer Profile</h2>

            <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-gray-300 rounded-md p-2">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Bio
                    </label>
                    <textarea name="bio" id="bio" rows="3" class="w-full border border-gray-300 rounded-md p-2">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Photo Profile
                    </label>
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                        class="w-full border border-gray-300 rounded-md p-2">
                    @error('profile_photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
@endsection
