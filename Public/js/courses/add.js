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
    const $addCourseForm = $('#add-course-form');
    const $addCousesBtn = $('#add-course');

    $addCourseForm.validate({
    	ignore: [],
        errorElement: "div",
        rules: {
            attached : {
                allowedTypes: ['application/zip'],
                maxFileSize: 50,
            },
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
            background: {
                allowedTypes: ['image/jpeg', 'image/png', 'image/gif'],
                maxFileSize: 10,
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
                $('#image-placeholder').html(`<i class="material-icons text-muted-light md-36" style="height: 250px;line-height: 250px">photo</i>`);
            }

            if($(element).attr('id') === 'background'){
                $('#background-placeholder').html(`<i class="material-icons text-muted-light md-36" style="height: 250px;line-height: 250px">photo</i>`);
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
            	$('#image-placeholder').html(`<img src="${blobURL}" alt="image formation" class="img-fluid" />`);
            }

            if($(element).attr('id') === 'background' && $(element).prop('files')[0]){
                const blobURL = URL.createObjectURL($(element).prop('files')[0]);
                $('#background-placeholder').html(`<img src="${blobURL}" alt="background formation" class="img-fluid" />`);
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
		    $addCousesBtn.addClass('is-loading is-loading-sm').prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#add-course-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/api/courses`, 
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
		      success: function({data}) {
		      	window.location.href = `${URLROOT}/courses/${data.id_formation}/videos`;

		        progressWrapper.hide(); // Hide the progress bar
		      },
		      error: function({responseJSON: {messages}}) {
		        // alert(messages);
                console.log(messages);
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

    $('#formation_image, #background').change(function(){$(this).blur()});
});