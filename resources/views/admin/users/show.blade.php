@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle del Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver al Listado</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">ID:</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role:</th>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span class="badge bg-danger">Administrador</span>
                                    @else
                                        <span class="badge bg-primary">Usuario</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Email Verificado:</th>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">
                                            Sí - {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">No verificado</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de Registro:</th>
                                <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Última Actualización:</th>
                                <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if ($user->isAdmin())
                            <div class="alert alert-warning mb-0">
                                <strong>Nota:</strong> Este usuario tiene permisos de administrador.
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <strong>Info:</strong> Usuario con permisos estándar.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Estadísticas</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Cuenta creada hace:</strong><br>
                        {{ $user->created_at->diffForHumans() }}
                    </p>
                    <p class="mb-0">
                        <strong>Última modificación:</strong><br>
                        {{ $user->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Nota informativa sobre relaciones --}}
    <div class="alert alert-light border mt-4">
        <h6 class="alert-heading">
            <i class="bi bi-info-circle"></i> Información
        </h6>
        <p class="mb-0 small text-muted">
            La gestión de usuarios actualmente muestra solo información básica.
            Los posts del blog y las solicitudes de servicio no están vinculados a usuarios específicos.
        </p>
    </div>
</div>
@endsection
