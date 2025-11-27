@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Solicitudes de Servicio</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $req)
                    <tr>
                        <td>{{ $req->nombre }}</td>
                        <td>{{ $req->email }}</td>
                        <td>{{ $req->tipo_servicio }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($req->descripcion_proyecto, 70, '...') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" class="d-inline">
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
