@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Solicitudes de Servicio</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filtros rápidos --}}
    <div class="mb-3">
        <span class="me-2">Filtrar por estado:</span>
        <a href="{{ route('admin.requests.index') }}" class="btn btn-sm btn-outline-secondary {{ !request('status') ? 'active' : '' }}">Todos</a>
        <a href="{{ route('admin.requests.index', ['status' => 'revision']) }}" class="btn btn-sm btn-outline-warning {{ request('status') === 'revision' ? 'active' : '' }}">En revisión</a>
        <a href="{{ route('admin.requests.index', ['status' => 'aceptado']) }}" class="btn btn-sm btn-outline-success {{ request('status') === 'aceptado' ? 'active' : '' }}">Aceptadas</a>
        <a href="{{ route('admin.requests.index', ['status' => 'rechazado']) }}" class="btn btn-sm btn-outline-danger {{ request('status') === 'rechazado' ? 'active' : '' }}">Rechazadas</a>
    </div>

    @if ($requests->isEmpty())
        <div class="alert alert-info">
            No hay solicitudes de servicio registradas.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $req)
                        @php
                            $badge = $req->getStatusBadge();
                        @endphp
                        <tr>
                            <td>#{{ $req->id }}</td>
                            <td>
                                @if ($req->user)
                                    <a href="{{ route('admin.users.show', $req->user->id) }}">
                                        {{ $req->user->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Sin usuario</span>
                                @endif
                            </td>
                            <td>{{ $req->nombre }}</td>
                            <td>{{ $req->tipo_servicio }}</td>
                            <td>
                                <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </td>
                            <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-sm btn-primary">
                                    Ver / Gestionar
                                </a>
                                <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta solicitud?')">
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
    @endif
</div>
@endsection
