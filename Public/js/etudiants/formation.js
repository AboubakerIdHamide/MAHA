$(function () {
    const player = new Plyr('#player', {captions: {active: false}});
    const URLROOT = 'http://localhost/MAHA';
    console.log(player);
    player.on("play", (event) => {
        $('.video.active').find('.icon').text('play_circle_filled');
    });
    player.on("pause", (event) => {
        $('.video.active').find('.icon').text('pause_circle_filled');
    });

    $('.icon').click(function(){
        player.togglePlay();
    });

    // Change video in player
    $('.video').click(function(){
        const video = $(this).data('video');
        const player = $('#player');

        const sourceVideo = `${URLROOT}/public/videos/${video.url}`;
        const previousVideo = player.attr('src');
        
        if(sourceVideo === previousVideo){
            return;
        }

        player.prop('src', sourceVideo);
        $('#video-description').text(video.description);
        $('#video-nom').text(video.nomVideo);
        $('.video.active').removeClass('active')
        .find('.media-body').removeClass('text-white')
        .find('.icon').text('');
        $(this).addClass('active')
        .find('.media-body').addClass('text-white')
        .find('.icon').text('pause_circle_filled');
        $('html, body').animate({ scrollTop: 30 }, 'slow');
    });

    // toggle Like
    $('#like').click(function(){
        $(this).addClass('btn-danger').removeClass('btn-default text-danger');
        $.post(`${URLROOT}/etudiant/toggleLikeFormation/${$('#id_formation').val()}`, function({data}){
            $('#number-likes').text(data.jaimes);
            if(data.jaimes == 0){
               $('#like').removeClass('btn-danger').addClass('btn-default text-danger'); 
            }
            $('#like').blur();
        }).fail(function({responseJSON: {messages}}){
            alert(messages);
        });
    });

    // toggle bookmark
    $('.bookmark').click(function(event){
        event.stopPropagation();
        const currentVideo = $(this);
        const idVideo = currentVideo.data('id');
        $.post(`${URLROOT}/etudiant/toggleBookmarkVideo/${idVideo}`, function({data}){
            if(data.isBookmarked){
                return currentVideo.find('.material-icons').text('bookmark');
            }
            return currentVideo.find('.material-icons').text('bookmark_border');
        }).fail(function({responseJSON: {messages}}){
            alert(messages);
        });
    });
});