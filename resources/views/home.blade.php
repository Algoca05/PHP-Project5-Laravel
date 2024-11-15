<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<header class="text-center">
    <h1>Bienvenido a la Página de Inicio</h1>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top w-100">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
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
                <li class="nav-item">
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
    <main>
        
    </main>
</div>
<footer class="footer mt-auto py-3 bg-light w-100">
    <div class="container text-center">
        <span class="text-muted">&copy; 2024-1015 Papumusic. Todos los derechos reservados.</span>
        <div>
            <a href="https://www.facebook.com" class="text-muted mx-2">Facebook</a>
            <a href="https://www.twitter.com" class="text-muted mx-2">Twitter</a>
            <a href="https://www.instagram.com" class="text-muted mx-2">Instagram</a>
        </div>
    </div>
</footer>
</body>
</html>