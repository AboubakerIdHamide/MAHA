$(function(){
	const URLROOT = 'http://localhost/maha';

	const phoneInput = document.querySelector("#tel");
  	const iti = intlTelInput(phoneInput, {
  		initialCountry: "auto",
    	utilsScript: `${URLROOT}/public/js/plugins/utils.js`,
    	formatOnDisplay: false, // Disable automatic formatting
    	nationalMode: false,   // Set to false to input international numbers
    	separateDialCode: true // Add a separate dial code input
  	});

	const Delta = Quill.import('delta');
	const quill = new Quill('#editor-container', {
		theme: 'snow' 
	});

	quill.on('text-change', function(delta, oldDelta, source) {
		$('#biography').val(quill.container.firstChild.innerHTML);
	});

	//================= Validation rules ====================
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

  	// Check phone validation
  	$.validator.addMethod('phoneNumber', function(value) {
	    if(value){
	    	return iti.isPossibleNumber();
	    }
    	return true;
  	}, "That's not a valid phone number.");

  	// Check strong password
  	$.validator.addMethod("passwordRequirements", function (value, element) {
	    // Password must contain at least one special character
	    const specialCharacterRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
	    // Password must contain at least one digit
	    const digitRegex = /\d/;
	    // Password must contain at least one letter
	    const letterRegex = /[a-zA-Z]/;
	    return this.optional(element) ||
	        (specialCharacterRegex.test(value) &&
	        digitRegex.test(value) &&
	        letterRegex.test(value));
	}, "Le xxxx doit contenir au moins un caractère spécial, un chiffre et une lettre.");

	$.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Le xxxx ne peut contenir que des lettres.");

	$.validator.addMethod("lettersWithSpaces", function(value, element) {
		return this.optional(element) || /^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/.test(value.trim());
	}, "Please enter only letters and spaces.");

	//==================== Validate Edit Profil =================
	//======================== Account Tab ====================
	const $editAccountForm = $('#edit-account-form');
	// get current values, don't send request unless they are different than current values.
	let currentAccountValues = $editAccountForm.serialize();
	$editAccountForm.validate({
    	// ignore: [],
        // debug: true,
        errorElement: "div",
        rules: {
        	nom: {
        		required: true,
		        minlength: 3,
		        maxlength: 15,
		        lettersonly: true
        	},
        	prenom: {
        		required: true,
		        minlength: 3,
		        maxlength: 15,
		        lettersonly: true
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
            tel : {
            	phoneNumber: true,
            },
            paypalMail : {
            	required : {
                    depends: function(element) {
                        return $(element).val().trim().length > 0;
                    }
                },
                email: true,
                maxlength: 100
            }
        },
        errorPlacement: function(error, element){
        	if($(element).attr('id') !== 'tel')
            	error.addClass('invalid-feedback').appendTo(element.parent());
            else
            	error.addClass('invalid-feedback').appendTo($(element).closest('.input-group'));
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form){
        	const newValues = $(form).serialize();
        	if(currentAccountValues === newValues && $('[name="image"]').val().length === 0){
        		return;
        	}

        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
        	formData.append('tab', 'AccountTab');
           	
		    $('#btn-account').addClass('is-loading is-loading-sm').prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#edit-account-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/formateur/edit`, 
		      type: 'POST',
		      data: formData,
		      processData: false,
		      contentType: false,
		      success: function({data: formateur, messages}) {
		      	currentAccountValues = newValues;
		      	if(formateur?.img){
		      		$('#avatar').attr('src', `${URLROOT}/public/images/${formateur.img}`);
		      	}
		      	$('#account-alert').html(`
		      		<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
		      			<div class="d-flex">
                        	<i class="material-icons text-success mr-3">check_circle</i>
                        	<div class="text-body">${messages}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>
                    </div>
                `);
		      },
		      error: function({responseJSON: {messages}}) {
		        alert(messages);
		      },
              complete: function(){
                $('#edit-account-form :input').not('#code').prop('disabled', false);
                $('#btn-account').removeClass('is-loading is-loading-sm').prop('disabled', false);
              }
		    });
        }
    });

    // Copy to Clipboard Button
	$('#btn-copy').click(function(){
		// Get the text field
		const copyText = document.getElementById("code");
		const copyBtn = $(this);

		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices

		// Copy the text inside the text field
		navigator.clipboard.writeText(copyText.value);
		copyBtn.html(`<i class="material-icons">done</i>`).prop('disabled', true);
		setTimeout(function(){
		  copyBtn.html(`<i class="material-icons">content_copy</i>`).prop('disabled', false);
		}, 5000);
	});

	// AutoRenew Button
	$('#btn-autorenew').click(function(){
		const renewBtn = $(this);

		renewBtn.addClass('is-loading is-loading-sm').prop('disabled', true);
		$.ajax({
			url : `${URLROOT}/formateur/refreshCode`,
			type : 'POST',
			data: {method: "PUT"},
			success: function({data, messages}){
				$('[name="code"]').val(data);
				$('#account-alert').html(`
					<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
                        <div class="d-flex">
                        	<i class="material-icons text-success mr-3">check_circle</i>
                        	<div class="text-body">${messages}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>                            
                    </div>
				`);
			},
			error: function({responseJSON: {messages}}){
				alert(messages);
			},
			complete: function(){
				renewBtn.removeClass('is-loading is-loading-sm').prop('disabled', false);
			}
		})
	});

    //======================== Public Tab =====================
	const $editPublicForm = $('#edit-public-form');
    let currentPublicValues = $editPublicForm.serialize();
	$editPublicForm.validate({
    	ignore: [],
        // debug: true,
        errorElement: "div",
        rules: {
        	categorie: {
		        required: true,
		    },
		    speciality: {
		        required: true,
		        minlength: 3,
		        maxlength: 25,
		        lettersWithSpaces: true
		    },
		    biography: {
		        required: true,	
		        minlength: 15,
		        maxlength: 700,
		    },
		    background: {
		    	required : {
                    depends: function(element) {
                        return $(element).val().trim().length > 0;
                    }
                },
                allowedTypes: ['image/jpeg', 'image/png', 'image/gif'],
                maxFileSize: 10,
		    },
        },
        messages: {
		    categorie: {
		        required: "Veuillez sélectionner une catégorie.",
		    },
		    speciality: {
		        required: "votre specialité est requis.",
		        minlength: "votre specialité doit comporter au moins {0} caractères.",
		        maxlength: "votre specialité ne doit pas dépasser {0} caractères.",
		        lettersWithSpaces: "votre specialité ne peut pas contenir 2 espaces successives."
		    },
		    biography: {
		        required: "votre biographie est requise.",
		        minlength: "votre biographie doit comporter au moins {0} caractères.",
		        maxlength: "votre biographie ne doit pas dépasser {0} caractères.",
		    },
		},
        errorPlacement: function(error, element){
           	error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
            if($(element).attr('id') === 'biography'){
            	$('.ql-toolbar')
            		.css({borderColor: '#f44336'})
            		.next()
            		.css({borderColor: '#f44336'});
            }
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
            if($(element).attr('id') === 'biography'){
            	$('.ql-toolbar')
            		.css({borderColor: '#f0f1f2'})
            		.next()
            		.css({borderColor: '#f0f1f2'});
            }
        },
        submitHandler: function(form){
        	const newValues = $(form).serialize();
        	if(currentPublicValues === newValues && $('[name="background"]').val().length === 0){
        		return;
        	}

        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
        	formData.append('tab', 'PublicTab');
           	
		    $('#btn-public').addClass('is-loading is-loading-sm').prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#edit-public-form :input').prop('disabled', true);

		    $.ajax({
				url: `${URLROOT}/formateur/edit`, 
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function({data: formateur, messages}) {
					currentPublicValues = newValues;
			      	if(formateur?.background_img){
			      		$('#background').attr('src', `${URLROOT}/public/images/${formateur.background_img}`);
			      	}
			      	$('#public-alert').html(`
			      		<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
			      			<div class="d-flex">
	                        	<i class="material-icons text-success mr-3">check_circle</i>
	                        	<div class="text-body">${messages}</div>
	                        </div>
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
							</button>
	                    </div>
                	`);
				},
				error: function({responseJSON: {messages}}) {
					alert(messages);
				},
				complete: function(){
					$('#edit-public-form :input').prop('disabled', false);
					$('#btn-public').removeClass('is-loading is-loading-sm').prop('disabled', false);
				}
		    });
        }
    });

    //======================== Private Tab =====================
	const $editPrivateForm = $('#edit-private-form');
	$editPrivateForm.validate({
        errorElement: "div",
        rules: {
        	cmdp : {
        		required: true,
		    	minlength: 10,
		        maxlength: 50,
		        passwordRequirements: true
        	},
        	mdp: {
		    	required: true,
		    	minlength: 10,
		        maxlength: 50,
		        passwordRequirements: true
		    },
		    vmdp: { equalTo: "#mdp" },
        },
        messages: {
        	cmdp: {
		        required: "Le mot de passe est requis.",
		        minlength: "Le mot de passe doit comporter au moins {0} caractères.",
		        maxlength: "Le mot de passe ne doit pas dépasser {0} caractères.",
		        passwordRequirements: "Le mot de passe doit contenir au moins un caractère spécial, un chiffre et une lettre."
		    },
		   	mdp: {
		        required: "Le mot de passe est requis.",
		        minlength: "Le mot de passe doit comporter au moins {0} caractères.",
		        maxlength: "Le mot de passe ne doit pas dépasser {0} caractères.",
		        passwordRequirements: "Le mot de passe doit contenir au moins un caractère spécial, un chiffre et une lettre."
		    },
		    vmdp: {
		    	equalTo: "La confirmation doit être identique au mot de passe."
		    },
		},
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
        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
        	formData.append('tab', 'PrivateTab');
           	
		    $('#btn-private').addClass('is-loading is-loading-sm').prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#edit-private-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/formateur/edit`, 
		      type: 'POST',
		      data: formData,
		      processData: false,
		      contentType: false,
		      success: function({messages}) {
		      	$('#private-alert').html(`
		      		<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
		      			<div class="d-flex">
                        	<i class="material-icons text-success mr-3">check_circle</i>
                        	<div class="text-body">${messages}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>
                    </div>
		      	`);
		      },
		      error: function({responseJSON: {messages}}) {
		      	$('#private-alert').html(`
		      		<div class="alert alert-light border-1 border-left-3 border-left-danger d-flex justify-content-between">
                        <div class="d-flex">
                        	<i class="material-icons text-danger mr-3">error</i>
                        	<div class="text-body">${messages.cmdp_error}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>
                    </div>
		      	`);
		      },
              complete: function(){
                $('#edit-private-form :input').prop('disabled', false);
                $('#btn-private').removeClass('is-loading is-loading-sm').prop('disabled', false);
              }
		    });
        }
    });
	
	//======================== Change Email ====================
	const $emailInput = $('#email');
	let oldEmail = $emailInput.val();
	const $sendEmail = $('#send-email');

	const $changeEmail = $('#change-email');
	$changeEmail.validate({
		rules: {
			email: {
				required : true,
                email: true,
                maxlength: 100
			}
		},
		errorPlacement: function(error, element){
           	error.addClass('invalid-feedback').appendTo(element.parent());
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
            $sendEmail.prop('disabled', true);
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
            $sendEmail.prop('disabled', false);
        },
        submitHandler: function(form){
        	const formData = new FormData(form);
        	if(oldEmail === $emailInput.val()){
        		$sendEmail.prop('disabled', true);
        		return;
        	}

        	oldEmail = $emailInput.val();
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
           	
		    $sendEmail.addClass('is-loading is-loading-sm').prop('disabled', true);
		    $emailInput.prop('disabled', true);

		    $.ajax({
				url: `${URLROOT}/formateur/changeEmail`, 
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function({messages}) {
					$('#emailChange-alert').html(`
						<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
                            <div class="d-flex">
	                        	<i class="material-icons text-success mr-3">check_circle</i>
                            	<div class="text-body">${messages}</div>
	                        </div>
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
							</button>                            
                        </div>
                    `);
				},
				error: function({responseJSON: {messages}}) {
					$('#emailChange-alert').html(`
						<div class="alert alert-light border-1 border-left-3 border-left-danger d-flex justify-content-between">
							<div class="d-flex">
	                        	<i class="material-icons text-danger mr-3">error</i>
                            	<div class="text-body">${messages?.email_error}</div>
	                        </div>
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
							</button>
                        </div>
                    `);
				},
				complete: function(){
					$emailInput.prop('disabled', false);
					$sendEmail.removeClass('is-loading is-loading-sm').prop('disabled', false);
				}
		    });
        }
	});

	//======================== Social Tab ========================
	const $editSocialForm = $('#edit-social-form');
	let currentSocialValues = $editSocialForm.serialize();
	$editSocialForm.validate({
        errorElement: "div",
        rules: {
        	facebook : {
        		maxlength: 50,
        		minlength: 5,
        	},
        	linkedin : {
        		maxlength: 50,
        		minlength: 5,
        	},
        	twitter : {
        		maxlength: 50,
        		minlength: 5,
        	},
        },
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
        	const newValues = $(form).serialize();
        	if(currentSocialValues === newValues && $('[name="background"]').val().length === 0){
        		return;
        	}

        	const formData = new FormData(form);
        	$(form).serializeArray().forEach((field) => formData.append(field.name, field.value))
        	formData.append('method', 'PUT');
        	formData.append('tab', 'SocialTab');
           	
		    $('#btn-social').addClass('is-loading is-loading-sm').prop('disabled', true);
		    // Disable all inputs within the form.
		    $('#edit-social-form :input').prop('disabled', true);

		    $.ajax({
		      url: `${URLROOT}/formateur/edit`, 
		      type: 'POST',
		      data: formData,
		      processData: false,
		      contentType: false,
		      success: function({messages}) {
		      	$('#social-alert').html(`
		      		<div class="alert alert-light border-1 border-left-3 border-left-success d-flex justify-content-between">
		      			<div class="d-flex">
                        	<i class="material-icons text-success mr-3">check_circle</i>
                        	<div class="text-body">${messages}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>
                    </div>
		      	`);
		      },
		      error: function({responseJSON: {messages}}) {
		        $('#social-alert').html(`
					<div class="alert alert-light border-1 border-left-3 border-left-danger d-flex justify-content-between">
						<div class="d-flex">
                        	<i class="material-icons text-danger mr-3">error</i>
                        	<div class="text-body">${messages}</div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
						</button>
                    </div>
                `);
		      },
              complete: function(){
                $('#edit-social-form :input').prop('disabled', false);
                $('#btn-social').removeClass('is-loading is-loading-sm').prop('disabled', false);
              }
		    });
        }
    });
});