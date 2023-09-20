$(function () {
    const player = new Plyr('#player', {captions: {active: false}});
    
    $(window).keypress(function(event){
        if($(".modal").hasClass('show')){
            return;
        }

        if(event.code === "Space"){
            player.togglePlay();
            $('html, body').animate({ scrollTop: 30 }, 'slow');
        }
    });

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
        const videoPlayer = $('#player');

        const sourceVideo = `${URLROOT}/public/videos/${video.url}`;
        const previousVideo = videoPlayer.attr('src');
        
        if(sourceVideo === previousVideo){
            return;
        }

        videoPlayer.prop('src', sourceVideo);
        $('#video-description').text(video.description);
        $('#video-nom').text(video.nomVideo);
        $('.video.active').removeClass('active')
        .find('.media-body').removeClass('text-white')
        .find('.icon').text('');
        $(this).addClass('active')
        .find('.media-body').addClass('text-white')
        .find('.icon').text('pause_circle_filled');
        $('#video-mention').val(`@${video.nomVideo}`);
        $('html, body').animate({ scrollTop: 30 }, 'slow');
        player.play();
    });

    // toggle Like
    $('#like').click(function(){
        $(this).addClass('btn-danger').removeClass('btn-default text-danger');
        $.post(`${URLROOT}/etudiant/toggleLikeFormation/${$('#id_formation').val()}`, function({data}){
            $('#number-likes').text(data.jaimes);
            if(data.isLiked){
                $('#like').addClass('btn-danger').removeClass('btn-default text-danger'); 
            }else{
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

    // toggle Read
    $('#btn-read').click(function(){
        const isTruncated = $('#video-description').toggleClass('text-truncate').hasClass('text-truncate');
        if(isTruncated){
            $(this).text('more');
        }else{
            $(this).text('less');
        }
    });

    // Ask Formateur
    $('#ask-formateur').click(function(){
        const idVideo = $(this).data('video');
        console.log(idVideo)
    });

    // Sent Message Form
    const $sendMessageForm = $('#ask-form');
    $sendMessageForm.validate({
    	ignore: [],
        errorElement: "div",
        rules: {
        	message: {
        		required : {
                    depends:function(){
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                maxlength: 255,
        	},
            to: {
                required: true
            },
            nom_video: {
                required: true
            }
        },
        // messages: {
        	
        // },
        errorPlacement: function(error, element){
            error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form){
            console.log($(form).serialize())

		    $.ajax({
		      url: `${URLROOT}/api/messages`, 
		      type: 'POST',
		      data: $(form).serialize(),
		      success: function({messages}) {
                $('[name="message"]').val('');
                $('#alert').addClass('alert alert-success').text(messages);
                setTimeout(() => $('#alert').removeClass('alert alert-success').text(''), 1000);                
		      },
		      error: function({responseJSON: {messages}}) {
		        alert(messages);
		      },
		    });
        }
    });
});