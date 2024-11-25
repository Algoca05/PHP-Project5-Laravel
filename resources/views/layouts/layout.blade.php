<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top w-100">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('music') }}">Musica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Opción 2</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if(Auth::user()->role == 1)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user_management') }}">Panel de Control</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="#">Editar Perfil</a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
