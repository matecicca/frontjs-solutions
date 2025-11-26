<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontJS Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="{{ route('home') }}">FrontJS Solutions</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('request.create') }}">Solicitar Servicio</a></li>

        @auth('web')
          {{-- Usuario autenticado con guard web --}}
          <li class="nav-item">
            <span class="nav-link">Hola, {{ Auth::guard('web')->user()->name }}</span>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button class="btn btn-sm btn-outline-light">Cerrar sesión</button>
            </form>
          </li>
        @else
          {{-- Usuario no autenticado --}}
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
        @endauth

        {{-- Enlace al panel de admin (siempre visible) --}}
        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="flex-grow-1 py-4">
    @yield('content')
</main>

<footer class="py-4 bg-dark text-white-50">
  <div class="container text-center small">
    &copy; {{ date('Y') }} FrontJS Solutions. Todos los derechos reservados.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
