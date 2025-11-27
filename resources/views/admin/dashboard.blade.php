@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 760px;">
    <h1 class="mb-4">Panel de Administración</h1>

    <div class="list-group">
        <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action">Gestionar Posts</a>
        <a href="{{ route('admin.requests.index') }}" class="list-group-item list-group-item-action">Ver Solicitudes de Servicios</a>
        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Gestionar Usuarios</a>
    </div>
</div>
@endsection
