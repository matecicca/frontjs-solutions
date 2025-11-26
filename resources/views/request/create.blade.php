@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 760px;">
    <h1 class="mb-4">Solicitar un Servicio</h1>

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
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="empresa" class="form-label">Empresa (opcional)</label>
            <input type="text" name="empresa" id="empresa" value="{{ old('empresa') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
            <select name="tipo_servicio" id="tipo_servicio" class="form-select" required>
                <option value="">Seleccionar...</option>
                <option value="React" {{ old('tipo_servicio') == 'React' ? 'selected' : '' }}>React</option>
                <option value="Vue" {{ old('tipo_servicio') == 'Vue' ? 'selected' : '' }}>Vue</option>
                <option value="Mantenimiento" {{ old('tipo_servicio') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="Otro" {{ old('tipo_servicio') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion_proyecto" class="form-label">Descripción del proyecto</label>
            <textarea name="descripcion_proyecto" id="descripcion_proyecto" rows="5" class="form-control" required>{{ old('descripcion_proyecto') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar solicitud</button>
    </form>
</div>
@endsection
