<div>
    <header class="text-center">
        <h1>Bienvenido a PapuMusic {{ Auth::user()->name }}</h1>
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
    <div class="container">
        @livewire('home-component')
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
</div>
