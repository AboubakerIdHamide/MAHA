$(function(){

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
            }
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
		      url: `${URLROOT}/etudiant/edit`, 
		      type: 'POST',
		      data: formData,
		      processData: false,
		      contentType: false,
		      success: function({data: etudiant, messages}) {
		      	currentAccountValues = newValues;
		      	if(etudiant?.img){
		      		$('.avatar').attr('src', `${URLROOT}/public/images/${etudiant.img}`);
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
		        // alert(messages);

                console.log(messages)
		      },
              complete: function(){
                $('#edit-account-form :input').not('#code').prop('disabled', false);
                $('#btn-account').removeClass('is-loading is-loading-sm').prop('disabled', false);
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
		      url: `${URLROOT}/etudiant/edit`, 
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
				url: `${URLROOT}/etudiant/changeEmail`, 
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
});