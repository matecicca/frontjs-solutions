@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Listado de Posts</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Nuevo Post</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Slug</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->titulo }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
