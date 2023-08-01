$(function(){
    const player = new Plyr('#player', {captions: {active: true}});
    const videoPlayer = document.getElementById('player');

    // Expose player so it can be used from the console
    window.player = player;

    // Open the overlay when the button is clicked
    $("#show-preview").click(function(event) {
        $("#overlay").fadeIn();
        $(".overlay-content").css({ transform: "translate(-50%, -50%) scale(1)" });
        $("body").css({
            overflow : 'hidden'
        });

        videoPlayer.play();
    });

    function hideOverlay() {
        $("#overlay").fadeOut();
        $(".overlay-content").css({ transform: "translate(-50%, -50%) scale(0)" });
        $("body").css({
            overflow : 'auto'
        });
        
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
    }

    $("#closeBtn, #overlay").click(hideOverlay);
});