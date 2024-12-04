@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center">
            <img src="{{ $user->profile_photo 
                ? '/storage/'.$user->profile_photo
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                alt="{{ $user->name }}" 
                class="w-32 h-32 rounded-full object-cover">
            
            <div class="ml-8">
                <div class="flex items-center mb-4">
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    @auth
                        @if(auth()->id() !== $user->id)
                            @if(auth()->user()->following->contains($user))
                                <form action="{{ route('follow.destroy', $user) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-gray-200 text-black px-4 py-1 rounded-md hover:bg-gray-300">
                                        Pas suivre
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('follow.store', $user) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">
                                        Suivre
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('profile.edit', $user) }}" 
                                class="ml-4 text-sm text-blue-500 hover:text-blue-700">
                                Editer Profile
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="flex space-x-8 mb-4">
                    <div>
                        <span class="font-bold">{{ $user->posts->count() }}</span> Publications
                    </div>
                    <div>
                        <span class="font-bold">{{ $user->followers->count() }}</span> Followers
                    </div>
                    <div>
                        <span class="font-bold">{{ $user->following->count() }}</span> Suivi(e)s
                    </div>
                </div>

                @if($user->bio)
                    <p class="text-sm">{{ $user->bio }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block aspect-square">
                <img src="{{ '/storage/'.$post->img_path }}" 
                    alt="{{ $post->caption }}" 
                    class="w-full h-full object-cover">
            </a>
        @endforeach
    </div>

    {{ $posts->links() }}
</div>
@endsection