@props(['post'])

<div class="bg-white border rounded-lg mb-8">
    <div class="p-4 flex items-center">
        <a href="{{ route('profile.show', $post->user) }}" class="flex items-center">
            <img src="{{ $post->user->profile_photo 
                ? Storage::url($post->user->profile_photo) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                alt="{{ $post->user->name }}" 
                class="h-8 w-8 rounded-full object-cover">
            <span class="ml-3 font-medium">{{ $post->user->name }}</span>
        </a>
        
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="ml-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        @endcan
    </div>

    <img src="{{ Storage::url($post->img_path) }}" alt="{{ $post->caption }}" class="w-full">

    <div class="p-4">
        <div class="flex items-center mb-4">
            @auth
                @if($post->likes->contains('user_id', auth()->id()))
                    <form action="{{ route('likes.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                @else
                    <form action="{{ route('likes.store', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </form>
                @endif
            @endauth
            
            <span class="ml-2 text-sm text-gray-600">{{ $post->likes->count() }} likes</span>
        </div>

        @if($post->caption)
            <p class="text-sm mb-2">
                <a href="{{ route('profile.show', $post->user) }}" class="font-bold">{{ $post->user->name }}</a>
                {{ $post->caption }}
            </p>
        @endif

        @if($post->comments->count() > 0)
            <div class="text-sm text-gray-600 mb-2">
                @foreach($post->comments->take(2) as $comment)
                    <div class="mb-1">
                        <a href="{{ route('profile.show', $comment->user) }}" class="font-bold">{{ $comment->user->name }}</a>
                        {{ $comment->content }}
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex">
            @csrf
            <input type="text" name="content" placeholder="Add a comment..." 
                class="flex-1 text-sm border-0 focus:ring-0 outline-none">
            <button type="submit" class="text-blue-500 font-semibold text-sm">Post</button>
        </form>
    </div>
</div>