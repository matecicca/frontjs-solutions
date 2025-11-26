@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 760px;">
    <h1 class="mb-3">Crear nuevo Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="resumen" class="form-label">Resumen</label>
            <textarea name="resumen" id="resumen" rows="3" class="form-control" required>{{ old('resumen') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" id="contenido" rows="6" class="form-control" required>{{ old('contenido') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="nombre_imagen" class="form-label">Nombre para guardar la imagen (sin extensión)</label>
            <input type="text" name="nombre_imagen" id="nombre_imagen" class="form-control" placeholder="Ej: react-introduccion">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Seleccionar imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Crear Post</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
