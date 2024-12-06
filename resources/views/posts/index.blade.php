@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1>Bienvenue à Instagrato</h1>
    @forelse($posts as $post)
        <x-post-card :post="$post" />
    @empty
        <div class="text-center py-8">
            <p class="text-gray-500">Aucune publication trouvée.</p>
        </div>
    @endforelse

    {{ $posts->links() }}
</div>
@endsection