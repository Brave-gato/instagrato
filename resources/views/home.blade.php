@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        
        @if(isset($posts) && $posts->count() > 0)
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $post->img_path) }}" class="card-img-top" alt="Post Image">
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($post->caption, 100) }}</p>
                                <p class="card-text"><small class="text-muted">Publié par {{ $post->user->name }} le
                                        {{ $post->created_at->format('M d, Y') }}</small></p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Voir publication</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <p>Aucune publication trouvée.</p>
        @endif
    </div>
@endsection
