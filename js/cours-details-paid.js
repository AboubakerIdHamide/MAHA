$(document).ready(function () {
	function removeTags(str) {
	    if ((str===null) || (str===''))
	        return '';
	    else
	        str = str.toString();
	          
	    // Regular expression to identify HTML tags in 
	    // the input string. Replacing the identified 
	    // HTML tag with a null string.
	    return str.replace(/(<([^>]+)>)/ig, '');
	}

	// PLaylist
	let $videosList = $('.videos-list ul li');

	$videosList.on('click', function (event) {
		let $saveBookmark = $(event.target);
		if($saveBookmark.hasClass('fa-bookmark')){
			if($saveBookmark.hasClass('fa-solid'))
				$saveBookmark.removeClass('fa-solid').addClass('fa-regular');
			else {
				$('.videos-list .fa-bookmark').removeClass('fa-solid').addClass('fa-regular');
				$saveBookmark.removeClass('fa-regular').addClass('fa-solid');
			}
			return;
		}

		if($(this).hasClass('selected'))
			return;

		$('.videos-list .selected .fa-circle-pause').removeClass('fa-circle-pause').addClass('fa-circle-play')
		$('.videos-list .selected').removeClass('selected');

		$(this).addClass('selected');

		$(this).find('i.fa-circle-play')
			   .removeClass('fa-circle-play')
			   .addClass('fa-circle-pause');

		let $videoName = $('.selected .video-name').text();
		$('.main-video video').attr('src', 'videos/'+$videoName+'.mp4');
		$('.container .main-video-name').text($videoName);
	});

	// add comment
	let $btn = $('.submit-btn');
	$btn.click(function (event) {
		let nomTotal = 'BOUDAL AHMED';
		let $comment = removeTags($('.comment-text').val());
		let time = new Date();

		// comment validation
		if($comment.length > 500){
			$('.comment-entry .comment-error').text('Maximum Caracters is 500')
			return;
		}
		else{
			if($comment.length < 4){
				$('.comment-entry .comment-error').text('Minimum Caracters is 4');
				return;
			}
		}

		let divComment = `
		<div class="d-flex gap-2 mt-2">
			<img class="align-self-start" src="./images/default.jpg" alt="my-photo">
			<div class="d-flex flex-column etudiant-comment">
				<span class="my-name">${nomTotal}</span>
				<p>${$comment}</p>
				<small>${time}</small>
			</div>
		</div>
		`;

		$('.comments-section .my-comments').append(divComment);
	});

	$('.comment-text').on('keydown keyup', function (event) {
		let $cptComment = $('.comment-text').val().length;
		$('.cpt-caractere').text($cptComment);
		if($cptComment >= 500){
			$('.cpt-caractere').text(500);
			$('.comment-entry .comment-error').text('Maximum Caracters is 500')
			return;
		}
		else {
			$('.comment-entry .comment-error').text('');
		}
	});

	// to-tp button
	let $toTop = $('.to-top');

	window.addEventListener('scroll', () => {
	    if(window.pageYOffset > 150)
	        $toTop.addClass('active');
	    else
	        $toTop.removeClass('active');
	});

	$toTop.click(function (e) {
	    e.preventDefault();
	    window.scrollTo(0, 0);
	})


});