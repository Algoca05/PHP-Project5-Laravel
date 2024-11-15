import 'https://cdn.jsdelivr.net/npm/howler@2.2.4/dist/howler.js';

let i = 0;
let songs;
let radio;
let songVolume = 0.5;
let sound;
let coverImage = document.getElementById('coverImage');
let titleText = document.getElementById('titleText');
let songProgress = document.getElementById('songProgress');

let radioSound;

let analyser;
let bufferLength;
let dataArray;
let canvas = document.getElementById('equalizerCanvas');
let ctx;
if (canvas) {
    ctx = canvas.getContext('2d');
}

let bassFilter;
let trebleFilter;

function initializeFilters() {
    if (Howler.ctx) {
        bassFilter = Howler.ctx.createBiquadFilter();
        bassFilter.type = 'lowshelf';
        bassFilter.frequency.setValueAtTime(200, Howler.ctx.currentTime);
        bassFilter.gain.setValueAtTime(0, Howler.ctx.currentTime);

        trebleFilter = Howler.ctx.createBiquadFilter();
        trebleFilter.type = 'highshelf';
        trebleFilter.frequency.setValueAtTime(3000, Howler.ctx.currentTime);
        trebleFilter.gain.setValueAtTime(0, Howler.ctx.currentTime);

        Howler.masterGain.connect(bassFilter);
        bassFilter.connect(trebleFilter);
        trebleFilter.connect(Howler.ctx.destination);
    } else {
        console.error('Howler context is not initialized.');
    }
}

new Howl({
    src: ['dummy.mp3'], 
    onload: function() {
        initializeFilters();
    }
});

const loadSongs = async () => {
    let response = await fetch("/json/songData.json");
    let data = await response.json();
    songs = data.songs;
    sound = new Howl({
        src: songs[i].src,
        volume: songVolume,
        onplay: function() {
            if (!bassFilter || !trebleFilter) {
                initializeFilters();
            }
        }
    });
    coverImage.src = songs[i].cover;
    titleText.innerHTML = songs[i].artist + ' - ' + songs[i].title;
    analyser = Howler.ctx.createAnalyser();
    bufferLength = analyser.frequencyBinCount;
    dataArray = new Uint8Array(bufferLength);
    
    changeTimeSecond();
    loadPlaylist();
    loadEqualizer();
    animateEqualizer();
    
    try {
        let responseRadio = await fetch("/json/songData.json");
        let radioData = await responseRadio.json();
        radio = radioData.radios;
        radioSound = new Howl({
            src: [radio[0].src],
            html5: true,
        });
        loadRadio();
    } catch (error) {
        console.error('Failed to load radio data:', error);
        radio = data.radios;
        radioSound = new Howl({
            src: [radio[0].src],
            html5: true,
        });
        loadRadio();
    }
}

function play() {
    if (radioSound && radioSound.playing()) {
        radioSound.pause();
    }
    if (sound.playing()) {
        sound.pause();
    } else {
        sound.play();
        songProgress.max = sound.duration();
        document.getElementById('playButton').innerHTML = 'PAUSE';
    }
}

function loadPlaylist() {
    for (let i = 0; i < songs.length; i++) {
        let song = document.createElement('div');
        song.className = 'song';
        song.innerHTML = '<h2 onclick="loadSong(' + i + ')">' + songs[i].artist + ' - ' + songs[i].title + '</h2>';
        document.getElementById('playlistDiv').appendChild(song);
    }
}

function loadRadio() {
    if (radio && radio.length > 0) {
        for (let i = 0; i < radio.length; i++) {
            let rlist = document.createElement('div');
            rlist.className = 'rlist';
            rlist.innerHTML = '<h2 onclick="loadRadioSong(' + i + ')">' + radio[i].title + '</h2>';
            document.getElementById('radioStationDiv').appendChild(rlist);
        }
    }
}

function loadRadioSong(index) {
    if (radioSound && radioSound.playing()) {
        radioSound.stop();
    }
    const radioUrl = radio[index].src;
    fetch(radioUrl, { method: 'HEAD', mode: 'no-cors' })
        .then(response => {
            if (response.ok || response.type === 'opaque') {
                radioSound = new Howl({
                    src: [radioUrl],
                    html5: true,
                });
                radioSound.play();
            } else {
                console.error('Radio stream not available:', radioUrl);
            }
        })
        .catch(error => {
            console.error('Failed to fetch radio stream:', error);
        });
}

function setParameters() {
    if (radioSound && radioSound.playing()) {
        radioSound.pause();
    }
    sound.unload();
    sound = new Howl({
        src: [songs[i].src],
        volume: songVolume // Asegúrate de establecer el volumen aquí
    });
    sound.play();
    sleep(500).then(() => { songProgress.max = sound.duration(); });
    coverImage.src = songs[i].cover;
    titleText.innerHTML = songs[i].artist + ' - ' + songs[i].title;
}

function loadSong(index) {
    i = index;
    setParameters();
}

function changeSong(change) {
    if (change == 'back') {
        if (i > 0) {
            i--;
        } else {
            i = songs.length - 1;
        }
    } else {
        if (i < songs.length - 1) {
            i++;
        } else {
            i = 0;
        }
    }
    setParameters();
}

function volume(event) {
    songVolume = event.value;
    sound.volume(songVolume);
   
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function changeTime(event) {
    sound.seek(event.value);
}

function changeTimeSecond() {
    setInterval(() => {
        songProgress.value = sound.seek();
    }, 1000);
}

function loadEqualizer() {
    Howler.masterGain.connect(analyser);
    analyser.connect(Howler.ctx.destination);
    analyser.fftSize = 2048;
    analyser.getByteTimeDomainData(dataArray);
}

function changeBass(event) {
    if (bassFilter) {
        bassFilter.gain.setValueAtTime(event.target.value, Howler.ctx.currentTime);
    } else {
        console.error('Bass filter is not initialized.');
    }
}

function changeTreble(event) {
    if (trebleFilter) {
        trebleFilter.gain.setValueAtTime(event.target.value, Howler.ctx.currentTime);
    } else {
        console.error('Treble filter is not initialized.');
    }
}

let animationFrame;
function animateEqualizer() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    analyser.getByteFrequencyData(dataArray);
    let volume = document.getElementById("volumeRange").value
    
    let barWidth = (canvas.width / bufferLength) * 10;
    let barSpacing = 0;
    let barHeight;
    for (let i = 0; i < bufferLength; i++) {
        barHeight = dataArray[i]*volume;
        let x = i * (barWidth + barSpacing);
        let y = canvas.height - barHeight;
        ctx.fillStyle = 'goldenrod';
        ctx.fillRect(x, y, barWidth, barHeight);
    }
    animationFrame = requestAnimationFrame(animateEqualizer);
}

function stopEqualizer() {
    cancelAnimationFrame(animationFrame);
}

document.getElementById('backButton').addEventListener('click', function() { changeSong('back') });
document.getElementById('nextButton').addEventListener('click', function() { changeSong('next') });
document.getElementById('playButton').addEventListener('click', play);
document.getElementById('volumeRange').addEventListener('input', function() { volume(this) });
document.getElementById('songProgress').addEventListener('change', function() { changeTime(this) });
document.getElementById('bassRange').addEventListener('input', function(event) { changeBass(event) });
document.getElementById('trebleRange').addEventListener('input', function(event) { changeTreble(event) });

loadSongs();
