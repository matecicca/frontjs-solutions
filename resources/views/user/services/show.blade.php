@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de Solicitud</h1>
        <a href="{{ route('user.services.index') }}" class="btn btn-outline-secondary">Volver a mis solicitudes</a>
    </div>

    @php
        $badge = $request->getStatusBadge();
    @endphp

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $request->tipo_servicio }}</strong>
                @if ($request->empresa)
                    <span class="text-muted ms-2">- {{ $request->empresa }}</span>
                @endif
            </div>
            <span class="badge {{ $badge['class'] }} fs-6">{{ $badge['label'] }}</span>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Nombre:</strong></p>
                    <p class="text-muted">{{ $request->nombre }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Email:</strong></p>
                    <p class="text-muted">{{ $request->email }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Fecha de solicitud:</strong></p>
                    <p class="text-muted">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                </div>
                @if ($request->accepted_at)
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Fecha de respuesta:</strong></p>
                        <p class="text-muted">{{ $request->accepted_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>

            <hr>

            <div class="mb-4">
                <p class="mb-1"><strong>Descripción del proyecto:</strong></p>
                <div class="p-3 bg-light rounded">
                    {{ $request->descripcion_proyecto }}
                </div>
            </div>

            {{-- Mensaje del administrador --}}
            @if ($request->admin_message)
                <hr>
                <div class="mb-2">
                    <p class="mb-1"><strong>Respuesta de FrontJS Solutions:</strong></p>
                    <div class="alert {{ $request->isAceptada() ? 'alert-success' : ($request->isRechazada() ? 'alert-danger' : 'alert-info') }} mb-0">
                        {{ $request->admin_message }}
                    </div>
                </div>
            @elseif ($request->isEnRevision())
                <hr>
                <div class="alert alert-warning mb-0">
                    <strong>Estado:</strong> Tu solicitud está siendo revisada. Te notificaremos por correo electrónico cuando tengamos una respuesta.
                </div>
            @endif
        </div>

        <div class="card-footer bg-transparent text-muted small">
            ID de solicitud: #{{ $request->id }}
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('request.create') }}" class="btn btn-primary">Nueva solicitud</a>
        <a href="{{ route('user.services.index') }}" class="btn btn-outline-secondary">Ver todas mis solicitudes</a>
    </div>
</div>
@endsection
