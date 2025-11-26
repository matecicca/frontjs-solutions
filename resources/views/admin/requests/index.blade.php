@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Solicitudes de Servicio</h1>

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
