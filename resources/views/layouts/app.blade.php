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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container py-2">
        {{-- Marca / Logo --}}
        <a class="navbar-brand fw-semibold me-4" href="{{ route('home') }}">
            FrontJS Solutions
        </a>

        {{-- Botón toggler mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Contenido colapsable --}}
        <div class="collapse navbar-collapse" id="mainNav">
            {{-- Links públicos izquierda --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                       href="{{ route('blog.index') }}">
                        Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('request.*') ? 'active' : '' }}"
                       href="{{ route('request.create') }}">
                        Solicitar servicio
                    </a>
                </li>
            </ul>

            {{-- Zona derecha: admin / usuario / login --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">

                {{-- Botón Panel Admin: SOLO si hay admin logueado --}}
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isAdmin())
                    <li class="nav-item me-1">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning btn-sm">
                            Panel Admin
                        </a>
                    </li>
                @endif

                {{-- Usuario común logueado (guard web) --}}
                @if(Auth::guard('web')->check())
                    <li class="nav-item d-flex align-items-center">
                        <span class="navbar-text text-white me-2">
                            {{ Auth::guard('web')->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>

                {{-- Usuario sólo admin logueado (por si no tiene sesión web) --}}
                @elseif(Auth::guard('admin')->check())
                    <li class="nav-item d-flex align-items-center">
                        <span class="navbar-text text-white me-2">
                            {{ Auth::guard('admin')->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>

                {{-- Nadie logueado: mostrar login/registro --}}
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            Iniciar sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                            Registrarse
                        </a>
                    </li>
                @endif
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
