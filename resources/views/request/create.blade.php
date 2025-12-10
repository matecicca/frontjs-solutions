@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 760px;">
    <h1 class="mb-4">Solicitar un Servicio</h1>

    {{-- Info del usuario logueado --}}
    <div class="alert alert-info mb-4">
        <strong>Usuario:</strong> {{ $user->name }} ({{ $user->email }})
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('request.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $user->name) }}"
                   class="form-control @error('nombre') is-invalid @enderror" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" value="{{ $user->email }}"
                   class="form-control" disabled>
            <small class="text-muted">El email de tu cuenta será usado para esta solicitud.</small>
        </div>

        <div class="mb-3">
            <label for="empresa" class="form-label">Empresa (opcional)</label>
            <input type="text" name="empresa" id="empresa" value="{{ old('empresa') }}"
                   class="form-control @error('empresa') is-invalid @enderror">
            @error('empresa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
            <select name="tipo_servicio" id="tipo_servicio"
                    class="form-select @error('tipo_servicio') is-invalid @enderror" required>
                <option value="">Seleccionar...</option>
                <option value="React" {{ old('tipo_servicio') == 'React' ? 'selected' : '' }}>React</option>
                <option value="Vue" {{ old('tipo_servicio') == 'Vue' ? 'selected' : '' }}>Vue</option>
                <option value="Mantenimiento" {{ old('tipo_servicio') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="Otro" {{ old('tipo_servicio') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('tipo_servicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion_proyecto" class="form-label">Descripción del proyecto</label>
            <textarea name="descripcion_proyecto" id="descripcion_proyecto" rows="5"
                      class="form-control @error('descripcion_proyecto') is-invalid @enderror" required>{{ old('descripcion_proyecto') }}</textarea>
            @error('descripcion_proyecto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Mínimo 10 caracteres. Describe tu proyecto con el mayor detalle posible.</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
            <a href="{{ route('user.services.index') }}" class="btn btn-outline-secondary">Ver mis solicitudes</a>
        </div>
    </form>
</div>
@endsection
