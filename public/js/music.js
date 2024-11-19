import 'https://cdn.jsdelivr.net/npm/howler@2.2.4/dist/howler.js';

let i = 0;
let songs;
let songVolume = 0.5;
let sound;
let coverImage = document.getElementById('coverImage');
let titleText = document.getElementById('titleText');
let songProgress = document.getElementById('songProgress');

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
let secondaryColor;

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

let moods;

const loadSongs = async () => {
    let response = await fetch("/json/songData.json");
    let data = await response.json();
    songs = data.songs;
    moods = data.moods;
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
    updateMoodOptions();
}

function play() {
    if (sound.playing()) {
        sound.pause();
    } else {
        sound.play();
        songProgress.max = sound.duration();
        document.getElementById('playButton').innerHTML = 'PAUSE';
    }
}

function loadPlaylist(filteredSongs = songs) {
    const playlistContainer = document.getElementById('playlistContainer');
    playlistContainer.innerHTML = ''; // Clear existing playlist
    for (let j = 0; j < filteredSongs.length; j++) {
        let song = document.createElement('div');
        song.className = 'song';
        song.innerHTML = '<h2>' + filteredSongs[j].artist + ' - ' + filteredSongs[j].title + '</h2>';
        song.addEventListener('click', function() {
            loadSongByIndex(filteredSongs, j);
        });
        playlistContainer.appendChild(song);
    }
}

function loadSongByIndex(filteredSongs, index) {
    songs = filteredSongs;
    i = index;
    setParameters();
    loadPlaylist(songs); // Ensure all songs are visible after selecting a song
}

document.getElementById('searchBar').addEventListener('input', function(event) {
    const searchTerm = event.target.value.toLowerCase();
    const filteredSongs = songs.filter(song => 
        song.artist.toLowerCase().includes(searchTerm) || 
        song.title.toLowerCase().includes(searchTerm)
    );
    loadPlaylist(filteredSongs);
});

function updateMoodOptions() {
    const moodContainer = document.getElementById('moodContainer');
    moodContainer.innerHTML = ''; // Clear existing moods
    let allMoods = document.createElement('div');
    allMoods.className = 'mood';
    allMoods.innerHTML = '<h2>All</h2>';
    allMoods.addEventListener('click', function() {
        loadPlaylist(songs);
        changePageColor('all');
    });
    moodContainer.appendChild(allMoods);
    moods.forEach(mood => {
        let moodElement = document.createElement('div');
        moodElement.className = 'mood';
        moodElement.innerHTML = '<h2>' + mood.charAt(0).toUpperCase() + mood.slice(1) + '</h2>';
        moodElement.addEventListener('click', function() {
            const filteredSongs = songs.filter(song => song.moods.includes(mood));
            loadPlaylist(filteredSongs);
            changePageColor(mood);
        });
        moodContainer.appendChild(moodElement);
    });
}

function changePageColor(mood) {
    let colorMap = {
        'feliz': { primary: 'lightyellow', secondary: 'yellow' },
        'energetico': { primary: 'pink', secondary: 'lightpink' },
        'relajado': { primary: 'darkblue', secondary: 'lightblue' },
        'triste': { primary: 'lightgray', secondary: 'gray' },
        'inspirado': { primary: 'purple', secondary: 'purple' },
        'estresado': { primary: 'black', secondary: 'red' },
        'all': { primary: 'black', secondary: 'goldenrod' }
    };
    let moodDiv = document.getElementById('moodDiv');
    let playlistDiv = document.getElementById('playlistDiv');
    let principalView = document.getElementById('PrincipalView');
    let nextButton = document.getElementById('nextButton');
    let playButton = document.getElementById('playButton');
    let backButton = document.getElementById('backButton');
    let searchBar = document.getElementById('searchBar');
    let nav = document.getElementById('nav');
    let footer = document.getElementById('footer');
    document.querySelectorAll('ul').forEach(ul => {
        ul.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    });
    if (moodDiv) {
        moodDiv.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (playlistDiv) {
        playlistDiv.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (principalView) {
        principalView.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (nextButton) {
        nextButton.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (playButton) {
        playButton.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (backButton) {
        backButton.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (nav) {
        nav.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (searchBar) {
        searchBar.style.backgroundColor = colorMap[mood].secondary || 'goldenrod';
    }
    if (footer) {
        footer.style.backgroundColor = colorMap[mood].secondary || 'goldenrod'
    }
    document.body.style.backgroundColor = colorMap[mood].primary || 'black';
    secondaryColor = colorMap[mood].secondary || 'goldenrod';
}

function setParameters() {
    sound.unload();
    sound = new Howl({
        src: [songs[i].src],
        volume: songVolume // Asegúrate de establecer el volumen aquí
    });
    sound.play();
    sleep(500).then(() => { songProgress.max = sound.duration(); });
    coverImage.src = songs[i].cover;
    titleText.innerHTML = songs[i].artist + ' - ' + songs[i].title;
    moodSelect.value = songs[i].moods[0];
    changePageColor(songs[i].moods[0]);
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
        ctx.fillStyle = secondaryColor||'goldenrod';
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

loadSongs().then(updateMoodOptions);
