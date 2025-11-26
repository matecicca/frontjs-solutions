@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <a href="{{ route('blog.index') }}" class="btn btn-secondary mb-3">&larr; Volver</a>

    <h1 class="display-6">{{ $post->titulo }}</h1>
    <p class="text-muted mb-3"><small>Publicado el {{ $post->created_at->format('d/m/Y') }}</small></p>

    @if($post->imagen)
        <img src="{{ asset('images/' . $post->imagen) }}" alt="{{ $post->titulo }}" class="img-fluid rounded shadow-sm mb-3">
    @endif

    <article class="fs-5 lh-lg">
        {!! nl2br(e($post->contenido)) !!}
    </article>
</div>
@endsection
