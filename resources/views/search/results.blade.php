@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Rechercher"{{ $query }}"</h2>

    @if($users->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Utilisateurs</h3>
            <div class="bg-white rounded-lg shadow divide-y">
                @foreach($users as $user)
                    <div class="p-4 flex items-center">
                        <img src="{{ $user->profile_photo 
                            ? '/storage/'.$user->profile_photo
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                            alt="{{ $user->name }}" 
                            class="h-10 w-10 rounded-full object-cover">
                        <div class="ml-4">
                            <a href="{{ route('profile.show', $user) }}" class="font-medium hover:underline">
                                {{ $user->name }}
                            </a>
                            @if($user->bio)
                                <p class="text-sm text-gray-500">{{ Str::limit($user->bio, 100) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($posts->isNotEmpty())
        <div>
            <h3 class="text-lg font-semibold mb-4">Publications</h3>
            <div class="grid grid-cols-3 gap-4">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="block aspect-square">
                        <img src="{{ '/storage/'.$post->img_path }}" 
                            alt="{{ $post->caption }}" 
                            class="w-full h-full object-cover">
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if($users->isEmpty() && $posts->isEmpty())
        <div class="text-center py-8 text-gray-500">
            Aucun resultat trouvé "{{ $query }}"
        </div>
    @endif-
</div>
@endsection