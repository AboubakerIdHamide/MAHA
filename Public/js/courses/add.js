$(function(){
	const URLROOT = 'http://localhost/MAHA';
	// Video Player
	const player = new Plyr('#player', {captions: {active: true}});

	// ================= Custom validations =================
    // Add a custom method for validating accepted file types
    $.validator.addMethod('allowedTypes', function(value, element, allowedTypes) {
	    const file = element.files[0];
	    if (!file) {
	    	return false;
	    }

	    return allowedTypes.indexOf(file.type) !== -1;
  	}, function(allowedTypes){return 'Please select a valid image file (' + allowedTypes.join(', ') + ').'});

  // Add a custom method for maximum file size validation
  	$.validator.addMethod('maxFileSize', function(value, element, maxSizeMB) {
	    const file = element.files[0];
	    if (!file) {
	      return false;
	    }

    	const maxSizeBytes = maxSizeMB * 1024 * 1024;
    	return file.size <= maxSizeBytes;
  	}, function (maxSizeMB){ return 'File size exceeds ' + maxSizeMB + 'MB limit.'});

    // Add a custom method for validating time in HH:MM format
    $.validator.addMethod("maxTime", function(value, element, time) {
        if (element.files && element.files.length > 0) {
        	const duration = $('#player')[0].duration.toFixed(2) ?? 0;
            return duration < 60 * time;
        }

        return true; 
    }, function(time){return `La durée maximale est de ${time} minutes.`});

    // ====================== END =======================================

    $('#preview-video').change(function (event) {
        const file = event.target.files[0];
        const fileName = file.name;

        const blobURL = URL.createObjectURL(file);
        $('#player').prop('src', blobURL);
		
		setTimeout(() => {
			$('label[for="preview-video"]').html('<div class="loader loader-secondary"></div>');
			if($(this).valid()){
				$('.preview-wrapper').removeClass('d-none');
				$('label[for="preview-video"]').text(fileName);
				$('#preview-name').val(fileName.substring(0, fileName.length - 4));
			}else{
    			$('#player').prop('src', '#');
        		$('.preview-wrapper').addClass('d-none');
        		$('label[for="preview-video"]').text('Choose video');
    		}
		}, 300);
    });

	// add course form 
    const $addCourseForm = $('#add-course-form');

    const $addCousesBtn = $('#add-course');

    //id_formateur, mass_horaire, description
    $addCourseForm.validate({
    	ignore: [],
        // debug: true,
        errorElement: "div",
        // onfocusout: false,
        // focusInvalid: false,
        rules: {
        	nom: {
        		required: true,
        		minlength: 3,
                maxlength: 80,
        	},
        	prix: {
        		required: true,
        		number: true,
        		min: 10,
        		max: 1000
        	},
        	preview :{
        		required: true,
                maxFileSize: 1024, // Maximum file size in bytes (1GB)
        		allowedTypes: ['video/mp4', 'video/mov', 'video/avi', 'video/x-matroska'],
                maxTime: 50
        	},
            image: {
            	required: true,
                allowedTypes: ['image/jpeg', 'image/png', 'image/gif'],
                maxFileSize: 5,
            },
            etat: {
                required: true,
            },
            id_niveau: {
                required: true,
            },
            id_categorie: {
                required: true,
            },
            id_langue: {
                required: true,
            },
            description: {
            	required: true,
            	minlength: 15,
		        maxlength: 700,	
            }
        },
        // messages: {
        	
        // },
        errorPlacement: function(error, element){
            error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
            if($(element).attr('id') === 'description'){
            	$('.ql-toolbar')
            		.css({borderColor: '#f44336'})
            		.next()
            		.css({borderColor: '#f44336'});
            }

            if($(element).attr('id') === 'formation_image'){
            	$('#image-placeholder').prop('src', `${URLROOT}/public/images/formations/formation_image_placeholder.jpg`);
            }
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
            if($(element).attr('id') === 'description'){
            	$('.ql-toolbar')
            		.css({borderColor: '#f0f1f2'})
            		.next()
            		.css({borderColor: '#f0f1f2'});
            }
            
            if($(element).attr('id') === 'formation_image'){
            	const blobURL = URL.createObjectURL($(element).prop('files')[0]);
            	$('#image-placeholder').prop('src', blobURL);
            }
        },
        submitHandler: function(form){
        	const progressWrapper = $('#progressWrapper');
  			const progressBar = $('.progress-bar');
        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	// Display the progress bar
		    progressWrapper.show();
		    // loading button
		    $addCousesBtn
		    	.addClass('is-loading')
		    	.addClass('is-loading-sm')
		    	.prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#add-course-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/courses/add`, 
		      type: 'POST',
		      data: formData,
		      processData: false,
		      contentType: false,
		      xhr: function() {
		        const xhr = $.ajaxSettings.xhr();
		        xhr.upload.addEventListener('progress', function(event) {
		          if (event.lengthComputable) {
		            const percentComplete = parseInt((event.loaded / event.total) * 100);
		            progressBar.width(percentComplete + '%').attr('aria-valuenow', percentComplete);
		            progressBar.text(percentComplete + '%');
		          }
		        });
		        return xhr;
		      },
		      success: function({status, data}) {
		      	if(status === 201){
		      		window.location.href = `${URLROOT}/courses/${data.id_formation}/videos`;
		      	}

		        progressWrapper.hide(); // Hide the progress bar
		      },
		      error: function(response) {
		        alert('Failed to submit the form.');
		        progressWrapper.hide(); // Hide the progress bar
		      },
		    });
        }
    });

    const quill = new Quill('#editor-container', {
        theme: 'snow' 
    });

    quill.on('text-change', function(delta, oldDelta, source) {
        $('#description').val(quill.container.firstChild.innerHTML).valid();
    });

    $('#formation_image').change(function(){$(this).blur()});
});