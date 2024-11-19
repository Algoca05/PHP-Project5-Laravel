
document.addEventListener('DOMContentLoaded', function() {
    const songElements = document.querySelectorAll('.song');
    const audioPlayer = new Audio();

    songElements.forEach(song => {
        song.addEventListener('click', function() {
            const src = this.getAttribute('data-src');
            audioPlayer.src = src;
            audioPlayer.play();
        });
    });
});