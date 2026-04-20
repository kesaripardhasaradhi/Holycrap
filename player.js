document.body.addEventListener("click", function() {
    var audio = document.getElementById("player");
    if (audio.paused) {
        audio.play();
    }
});
