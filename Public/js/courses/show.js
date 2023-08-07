$(function(){
    const player = new Plyr('#player', {captions: {active: true}});
    const videoPlayer = document.getElementById('player');

    // Expose player so it can be used from the console
    window.player = player;

    // Open the overlay when the button is clicked
    $("#show-preview").click(function(event) {
        $("#overlay").fadeIn();
        $(".overlay-content").css({ transform: "translate(-50%, -50%)" });
        $("body").css({
            overflow : 'hidden'
        });

        videoPlayer.play();
    });

    function hideOverlay() {
        $("#overlay").fadeOut();
        $(".overlay-content").css({ transform: "translate(-50%, 1000%)" });
        $("body").css({
            overflow : 'auto'
        });
        
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
    }

    $("#closeBtn, #overlay").click(hideOverlay);

    // sidebar for Course
    $('#sidebar-course').theiaStickySidebar({
        additionalMarginTop: 76
    });

    const $toTopBtn = $('.to-top-btn');

    $(window).scroll(function(){
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            $toTopBtn.fadeIn('slow');
        } else {
            $toTopBtn.fadeOut('slow');
        }
    });

    $toTopBtn.click(function() {
        document.body.scrollTop = 532; // For Safari
        document.documentElement.scrollTop = 532; // For Chrome, Firefox, IE and Opera
    })
});