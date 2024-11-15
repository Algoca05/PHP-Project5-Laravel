<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Música</title>
    <link rel="stylesheet" href="{{ asset('css/music.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/howler@2.2.4/dist/howler.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
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
    <div id="upDiv">
        <div id="PrincipalView">
            <h1 id="titleText"></h1>
            <img id="coverImage">
            <br>
            <div id="buttons">
                <button id="backButton">BACK</button>
                <button id="playButton">PLAY</button>
                <button id="nextButton">NEXT</button>
            </div>
            <br>
            <input type="range" min="0.0" max="1.0" value="0.5" step="0.01" id="volumeRange">
            <label for="volumeRange">Volume</label>
            <br>
            <input type="range" min="0.0" step="0.01" value="0" id="songProgress">
            <label for="timerRange">Timer</label>
            <br>
            <input type="range" min="-20" max="20" value="0" step="0.1" id="bassRange">
            <label for="bassRange">Bass</label>
            <input type="range" min="-20" max="20" value="0" step="0.1" id="trebleRange">
            <label for="trebleRange">Treble</label>
            <h1>EQUALIZER</h1>
            <canvas id="equalizerCanvas" width="200" height="200"></canvas>
        </div>
        <div class="containerMusica">
            <div id="playlistDiv">
                <h1>PLAYLIST</h1>
                <input type="text" id="searchBar" placeholder="Search for a song...">
            </div>
            <div id="radioStationDiv">
                <h1>RADIO</h1>
            </div>
        </div>
    </div>
    <footer>
        <img id="logoAbajo" src="./src/img/logo.jpeg" alt="Logo">
        <span style="text-align: start;">© PapuMusic 2024 - 2025</span>
    </footer>
    <script type="module" src="{{ asset('js/music.js') }}"></script>
</body>
</html>
