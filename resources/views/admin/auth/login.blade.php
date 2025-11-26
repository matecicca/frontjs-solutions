@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 420px;">
    <h1 class="mb-4 text-center">Acceso al Panel</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Usuario</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required autofocus placeholder="admin">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" required placeholder="pass123">
        </div>

        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>

    <p class="text-center text-muted mt-3 small">Usuario: <b>admin</b> — Contraseña: <b>pass123</b></p>
</div>
@endsection
