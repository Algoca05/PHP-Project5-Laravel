<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Esférico de la Tierra</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://unpkg.com/tz-lookup@latest/tz.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.0.2/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tz-lookup@6.1.27/tz-lookup.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
</head>
<body class="d-flex justify-content-center align-items-center">
    <div id="digitalClockContainer" class="position-absolute" style="top: 10px;">
        <div id="digitalClock"></div>
        <div id="digitalDate"></div>
        <div id="selectedCountry"></div>
    </div>
    <div id="chartdiv" class="position-relative"></div> 
    <div id="analogClock" class="position-absolute">
        <svg viewBox="0 0 100 100" width="200" height="200">
            <circle cx="50" cy="50" r="48" stroke="none" fill="white"/>
            <line id="hourHand" x1="50" y1="50" x2="50" y2="20" stroke="black" stroke-width="2"/> <!-- Longer hour hand -->
            <line id="minuteHand" x1="50" y1="50" x2="50" y2="10" stroke="black" stroke-width="2"/> <!-- Longer minute hand -->
            <line id="secondHand" x1="50" y1="50" x2="50" y2="5" stroke="red" stroke-width="1"/> <!-- Longer second hand -->
            <text x="50" y="8" text-anchor="middle" fill="black" font-size="5">12</text>
            <text x="75" y="15" text-anchor="middle" fill="black" font-size="5">1</text>
            <text x="88" y="32" text-anchor="middle" fill="black" font-size="5">2</text>
            <text x="92" y="50" text-anchor="middle" fill="black" font-size="5">3</text>
            <text x="88" y="68" text-anchor="middle" fill="black" font-size="5">4</text>
            <text x="75" y="85" text-anchor="middle" fill="black" font-size="5">5</text>
            <text x="50" y="92" text-anchor="middle" fill="black" font-size="5">6</text>
            <text x="25" y="85" text-anchor="middle" fill="black" font-size="5">7</text>
            <text x="12" y="68" text-anchor="middle" fill="black" font-size="5">8</text>
            <text x="8" y="50" text-anchor="middle" fill="black" font-size="5">9</text>
            <text x="12" y="32" text-anchor="middle" fill="black" font-size="5">10</text>
            <text x="25" y="15" text-anchor="middle" fill="black" font-size="5">11</text>
        </svg>
    </div>
    <div class="position-absolute" style="bottom: 10px; left: 10px;">
        <button onclick="setDateFormat('24H')">24H</button>
        <button onclick="setDateFormat('12H')">12H</button>
        <button onclick="setDateFormat('ISO')">ISO</button>
        <button onclick="setDateFormat('DD/MM/YYYY')">DD/MM/YYYY</button>
        <button onclick="setDateFormat('DIA-MES-AÑO')">DIA-MES-AÑO</button>
        <button onclick="setDateFormat('DIA-MES-AÑO (SIMPLIFICADO)')">DIA-MES-AÑO (SIMPLIFICADO)</button>
        <button onclick="window.location.href='{{ route('home') }}'">Inicio</button>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/estrellas.js') }}"></script>
    <script src="{{ asset('js/mapa.js') }}"></script>
    <script src="{{ asset('js/relojes.js') }}"></script>
</body>
</html>