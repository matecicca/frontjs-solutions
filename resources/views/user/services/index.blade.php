@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mis Solicitudes de Servicio</h1>
        <a href="{{ route('request.create') }}" class="btn btn-primary">Nueva solicitud</a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($requests->isEmpty())
        <div class="alert alert-info">
            <p class="mb-0">No tienes solicitudes de servicio. <a href="{{ route('request.create') }}">Crea tu primera solicitud</a>.</p>
        </div>
    @else
        <div class="row">
            @foreach ($requests as $req)
                @php
                    $badge = $req->getStatusBadge();
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $req->tipo_servicio }}</strong>
                            <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted small mb-2">
                                <strong>Fecha:</strong> {{ $req->created_at->format('d/m/Y H:i') }}
                            </p>
                            @if ($req->empresa)
                                <p class="card-text small mb-2">
                                    <strong>Empresa:</strong> {{ $req->empresa }}
                                </p>
                            @endif
                            <p class="card-text">
                                {{ \Illuminate\Support\Str::limit($req->descripcion_proyecto, 150, '...') }}
                            </p>

                            {{-- Mensaje del admin si existe --}}
                            @if ($req->admin_message)
                                <hr>
                                <div class="alert {{ $req->isAceptada() ? 'alert-success' : 'alert-danger' }} py-2 mb-0">
                                    <strong>Respuesta de FrontJS Solutions:</strong>
                                    <p class="mb-0 mt-1">{{ \Illuminate\Support\Str::limit($req->admin_message, 100, '...') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('user.services.show', $req->id) }}" class="btn btn-sm btn-outline-primary">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
