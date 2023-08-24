$(function(){
	const URLROOT = 'http://localhost/MAHA';
	// Video Player
	const player = new Plyr('#player', {captions: {active: true}});

	// ================= Custom validations =================
    // Add a custom method for validating accepted file types
    $.validator.addMethod('allowedTypes', function(value, element, allowedTypes) {
	    const file = element.files[0];
	    if (!file) {
	    	return true;
	    }

	    return allowedTypes.indexOf(file.type) !== -1;
  	}, function(allowedTypes){return 'Please select a valid image file (' + allowedTypes.join(', ') + ').'});

  // Add a custom method for maximum file size validation
  	$.validator.addMethod('maxFileSize', function(value, element, maxSizeMB) {
	    const file = element.files[0];
	    if (!file) {
	      return true;
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
    const $addCourseForm = $('#edit-course-form');

    const $editCousesBtn = $('#edit-course');

    //id_formateur, mass_horaire, description
    $addCourseForm.validate({
    	// ignore: [],
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
        		required : {
                    depends: function(element) {
                        return $(element).val().trim().length > 0;
                    }
                },
                maxFileSize: 1024, // Maximum file size in bytes (1GB)
        		allowedTypes: ['video/mp4', 'video/mov', 'video/avi', 'video/x-matroska'],
                maxTime: 50
        	},
            image: {
            	required : {
                    depends: function(element) {
                        return $(element).val().trim().length > 0;
                    }
                },
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
                if($(element).prop('files').length > 0){
                    const blobURL = URL.createObjectURL($(element).prop('files')[0]);
                    $('#image-placeholder').prop('src', blobURL);
                }
            }
        },
        submitHandler: function(form){
        	const progressWrapper = $('#progressWrapper');
  			const progressBar = $('.progress-bar');
        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
            // Display the progress bar
		    progressWrapper.show();
		    // loading button
		    $editCousesBtn
		    	.addClass('is-loading')
		    	.addClass('is-loading-sm')
		    	.prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#edit-course-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/api/courses/${$('input#id_formation').val()}`, 
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
		      success: function({messages}) {
		      	$('#message').html(`
                    <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <strong>${messages}</strong>
                    </div>
                `);
		      },
		      error: function(response) {
		        alert('Failed to submit the form.');
		      },
              complete: function(){
                progressWrapper.hide(); // Hide the progress bar
                $('#edit-course-form :input').prop('disabled', false);
                $editCousesBtn
                .removeClass('is-loading')
                .removeClass('is-loading-sm')
                .prop('disabled', false);
              }
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