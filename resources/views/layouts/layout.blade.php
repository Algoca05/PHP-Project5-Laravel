<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    @yield('title')
   
    @yield('styles')
</head>
<body>
<header class="text-center">
    @if(!Auth::user())
    <h1>Bienvenido a PapuMusic</h1>
    @else
    <h1>Bienvenido a PapuMusic {{ Auth::user()->name }}</h1>
    @endif
</header>
@if(Auth::user())
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top w-100">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Musica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Reloj Interactivo</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#RegisterModal">Registrarse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a>
            </li>
        </ul>
    </div>
</nav>
@else
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
                <a class="nav-link" href="{{ route('reloj') }}">Reloj Interactivo</a>
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
@endif
<div class="container">
    <main>
        @yield('main')
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

<!-- Login Modal -->
<div class="modal fade @if ($errors->has('email') || $errors->has('password')) show @endif" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" @if ($errors->has('email') || $errors->has('password'))" @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/login" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
                <p class="mt-3">¿No tienes una cuenta? <a href="#" data-toggle="modal" data-target="#RegisterModal" data-dismiss="modal">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade @if ($errors->has('name') || $errors->has('email') || $errors->has('password')) show @endif" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true" @if ($errors->has('name') || $errors->has('email') || $errors->has('password')) @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RegisterModalLabel">Registrarse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                        @if ($errors->has('name'))
                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="255">
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="8">
                        @if ($errors->has('password'))
                            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
                <p class="mt-3">¿Ya tienes una cuenta? <a href="#" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</div>
@yield('scripts')

</body>
</html>
