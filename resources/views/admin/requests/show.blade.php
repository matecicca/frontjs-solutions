@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de Solicitud #{{ $request->id }}</h1>
        <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $badge = $request->getStatusBadge();
    @endphp

    <div class="row">
        {{-- Información de la solicitud --}}
        <div class="col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Información de la solicitud</strong>
                    <span class="badge {{ $badge['class'] }} fs-6">{{ $badge['label'] }}</span>
                </div>
                <div class="card-body">
                    {{-- Usuario --}}
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="text-muted mb-2">Usuario solicitante</h6>
                        @if ($request->user)
                            <p class="mb-1"><strong>Nombre:</strong> {{ $request->user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $request->user->email }}</p>
                            <p class="mb-0">
                                <a href="{{ route('admin.users.show', $request->user->id) }}" class="btn btn-sm btn-outline-primary">
                                    Ver perfil del usuario
                                </a>
                            </p>
                        @else
                            <p class="mb-0 text-muted">Usuario no registrado o eliminado</p>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nombre en solicitud:</strong></p>
                            <p>{{ $request->nombre }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email de contacto:</strong></p>
                            <p>{{ $request->email }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Tipo de servicio:</strong></p>
                            <p><span class="badge bg-info">{{ $request->tipo_servicio }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Empresa:</strong></p>
                            <p>{{ $request->empresa ?: 'No especificada' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Fecha de solicitud:</strong></p>
                            <p>{{ $request->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if ($request->accepted_at)
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Fecha de respuesta:</strong></p>
                                <p>{{ $request->accepted_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="mb-0">
                        <p class="mb-1"><strong>Descripción del proyecto:</strong></p>
                        <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $request->descripcion_proyecto }}</div>
                    </div>

                    {{-- Mensaje actual si existe --}}
                    @if ($request->admin_message)
                        <hr>
                        <div class="mb-0">
                            <p class="mb-1"><strong>Mensaje enviado al usuario:</strong></p>
                            <div class="alert {{ $request->isAceptada() ? 'alert-success' : ($request->isRechazada() ? 'alert-danger' : 'alert-secondary') }} mb-0">
                                {{ $request->admin_message }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel de gestión de estado --}}
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>Gestionar solicitud</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.requests.updateStatus', $request->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="revision" {{ $request->status === 'revision' ? 'selected' : '' }}>
                                    En revisión
                                </option>
                                <option value="aceptado" {{ $request->status === 'aceptado' ? 'selected' : '' }}>
                                    Aceptado
                                </option>
                                <option value="rechazado" {{ $request->status === 'rechazado' ? 'selected' : '' }}>
                                    Rechazado
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_message" class="form-label">
                                Mensaje para el usuario
                                <small class="text-muted">(obligatorio al aceptar)</small>
                            </label>
                            <textarea name="admin_message" id="admin_message" rows="5"
                                      class="form-control @error('admin_message') is-invalid @enderror"
                                      placeholder="Escribe aquí el mensaje que recibirá el usuario...">{{ old('admin_message', $request->admin_message) }}</textarea>
                            @error('admin_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Este mensaje se enviará por email al usuario y quedará visible en su panel.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Guardar cambios
                            </button>
                        </div>

                        @if (!$request->isEnRevision())
                            <div class="alert alert-info mt-3 mb-0 small">
                                <strong>Nota:</strong> Esta solicitud ya fue {{ $request->isAceptada() ? 'aceptada' : 'rechazada' }}.
                                Puedes cambiar el estado, pero se enviará un nuevo email al usuario.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Acciones adicionales --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Acciones</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta solicitud? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            Eliminar solicitud
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
