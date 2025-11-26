@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gestión de Usuarios</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-3">Total de usuarios: {{ $users->total() }}</p>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Fecha de creación</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-primary">User</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="btn btn-sm btn-info">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
