@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->caption }}</h1>
        <img src="{{ asset('storage/'. $post->img_path) }}" alt="Post Image" class="img-fluid">
        <p>Publié par: {{ $post->user->name }}</p>
        <p>Publié le: {{ $post->created_at->format('d M Y H:i') }}</p>
        <!-- Ajoutez ici d'autres détails du post que vous souhaitez afficher -->
    </div>
@endsection
