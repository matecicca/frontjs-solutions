@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Panel de Administración</h1>

    <div class="row g-4">
        {{-- Card 1: Gestión de Posts --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="text-center mb-3">
                        <span style="font-size: 3rem;">📝</span>
                    </div>
                    <h5 class="card-title text-center">Gestionar Posts</h5>
                    <p class="card-text text-center mb-4">
                        Crear, editar y eliminar artículos del blog
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('posts.index') }}" class="btn btn-light w-100">
                            Ir a Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Solicitudes de Servicios --}}
        <div class="col-md-4">
            <div class="card text-white bg-success h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="text-center mb-3">
                        <span style="font-size: 3rem;">📬</span>
                    </div>
                    <h5 class="card-title text-center">Solicitudes de Servicios</h5>
                    <p class="card-text text-center mb-4">
                        Ver y gestionar solicitudes recibidas
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-light w-100">
                            Ver Solicitudes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Gestión de Usuarios --}}
        <div class="col-md-4">
            <div class="card text-white bg-info h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="text-center mb-3">
                        <span style="font-size: 3rem;">👥</span>
                    </div>
                    <h5 class="card-title text-center">Gestionar Usuarios</h5>
                    <p class="card-text text-center mb-4">
                        Ver listado y detalles de usuarios
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">
                            Ver Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
