@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blog / Novedades</h1>

    @if ($posts->isEmpty())
        <div class="alert alert-info">No hay artículos publicados todavía.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <article class="card h-100">
                        @if($post->imagen)
                        <img src="{{ Storage::url($post->imagen) }}"
                        class="card-img-top img-fluid"
                        alt="{{ $post->titulo }}">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h2 class="h4 card-title">{{ $post->titulo }}</h2>
                            <p class="text-muted small mb-2">{{ $post->created_at->format('d/m/Y') }}</p>
                            <p class="card-text">{{ Str::limit($post->resumen, 150, '...') }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Leer más</a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
