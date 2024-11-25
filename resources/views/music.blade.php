@extends('layouts.layout')

@section('title', 'Música')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/music.css') }}">
@endsection

@section('content')
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
            <div id="playlistContainer"></div>
        </div>
        <div id="moodDiv">
            <h1>MOODS</h1>
            <div id="moodContainer"></div>
        </div>
    </div>
</div>
<footer id="footer">
    <img id="logoAbajo" src="./src/img/logo.jpeg" alt="Logo">
    <span style="text-align: start;">© PapuMusic 2024 - 2025</span>
</footer>
@endsection

@section('scripts')
<script type="module" src="{{ asset('js/music.js') }}"></script>
@endsection
