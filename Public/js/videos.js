$(document).ready(function () {
	// Stop the video when the modal closed
	$("#voir").on('hidden.bs.modal', function (e) {
	    $("#voir video").attr("src", $("#voir video").attr("src"));
	});

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

	// clear showing errors when closing modal
	$('.fermer').click(function (e) {
		$('.error-title, .error-desc').text('');
	});

	// make modal dynamic
	// apercu button
	$('.apercu, .edit, .delete').click(function (e) {
		const $videoName = $(this).parent().parent().find('span')[0].textContent;
		$('.nom-video').text($videoName);
		$('#mp4-video').attr('src', `./videos/${$videoName}.mp4`);

		// delete video
		const $deletedVideo = $(this).parent().parent();
		$('#delete-video').click(function (event) {
			$deletedVideo.remove();
			// close modal
			$('.btn-close').click();
		});
	});
	

	// validation for title and description
	$('#apply-btn').click(function (event) {
		const desc = {
			inputValue : removeTags($('#description').val()),
			label : 'desc',
			maxCara : 600,
			regExp : /[]/
		};

		const title = {
			inputValue : $('#title').val(),
			label : 'title',
			maxCara : 50,
			regExp : /^[a-zA-Z0-9]+$/
		};

		const isInputValid = ({ inputValue, label, maxCara, regExp }) => {
			if(inputValue.length > maxCara){
				$('.error-' + label).text(`Le nombre maximum de caractères est ${maxCara}`);
				return false;
			}

			if(inputValue.length < 6){
				$('.error-' + label).text('Le nombre minimum de caractères est 5');
				return false;
			}

			if(label === 'title' && !inputValue.match(regExp)){
				$('.error-' + label).text('Le title ne doit pas contient des caractères speciaux.');
				return false;
			}

			$('.error-' + label).text('');
			return true;
		}

		if(desc.inputValue.length !== 0){
			if(isInputValid(desc)){
				console.log('Ajax Call');
			}
		}

		if(title.inputValue.length !== 0){
			if(isInputValid(title)){
				console.log('Ajax Call');
			}
		}

	});


});



