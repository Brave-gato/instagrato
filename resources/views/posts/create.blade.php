@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Créer une nouvelle publication</h2>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Photo
                </label>
                <input type="file" name="image" id="image" accept="image/*" required
                    class="w-full border border-gray-300 rounded-md p-2">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">
                    Caption
                </label>
                <textarea name="caption" id="caption" rows="3" 
                    class="w-full border border-gray-300 rounded-md p-2">{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Partager publication
            </button>
        </form>
    </div>
</div>
@endsection