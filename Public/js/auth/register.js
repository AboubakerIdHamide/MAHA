$(function () {
	// Input field effect
    (function () {
        if (!String.prototype.trim) {
            (function () {
                // Make sure we trim BOM and NBSP
                const rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function () {
                    return this.replace(rtrim, '');
                };
            })();
        }
        [].slice.call(document.querySelectorAll('input.input_field, textarea.input_field')).forEach(function (inputEl) {
            // in case the input is already filled..
            if (inputEl.value.trim() !== '') {
                classie.add(inputEl.parentNode, 'input--filled');
            }

            // events:
            inputEl.addEventListener('focus', onInputFocus);
            inputEl.addEventListener('blur', onInputBlur);
        });
        function onInputFocus(ev) {
            classie.add(ev.target.parentNode, 'input--filled');
        }
        function onInputBlur(ev) {
            if (ev.target.value.trim() === '') {
                classie.remove(ev.target.parentNode, 'input--filled');
            }
        }
    })();

    // Loader
    document.body.style.overflow = "hidden";
    $(window).on('load', function () {
        document.body.style.overflow = "auto";
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350);
        $(window).scroll();
    });

	// Check selected type user from home page
	const typeUser = localStorage.getItem('type');
	if(typeUser){
		$(`input[value="${typeUser}"]`).prop("checked", true);
		localStorage.removeItem('type');
	}

    // Register form validation
    const $registerForm = $("#register-form");

    // Register Button
    const $btnRegister = $('#register-btn');

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
  
    $registerForm.validate({
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
		    email: {
		        required: true,
		        email: true,
		        remote: {
	                url: URLROOT + '/ajax/checkEmail', // Replace with your backend validation URL
	                type: "POST",
	                data: {
                    	'email': function () { return $('#email').val(); }
                	},
            	}
		    },
		    mdp: {
		    	required: true,
		    	minlength: 10,
		        maxlength: 50,
		        passwordRequirements: true
		    },
		    vmdp: { equalTo: "#mdp" },
		    type: "required"
		},
		messages: {
		    nom: {
		        required: "Le nom est requis.",
		        minlength: "Le nom doit comporter au moins {0} caractères.",
		        maxlength: "Le nom ne doit pas dépasser {0} caractères.",
		        lettersonly: "Le nom ne peut contenir que des lettres."
		    },
		    prenom: {
		        required: "Le prénom est requis.",
		        minlength: "Le prénom doit comporter au moins {0} caractères.",
		        maxlength: "Le prénom ne doit pas dépasser {0} caractères.",
		        lettersonly: "Le prénom ne peut contenir que des lettres."
		    },
		    email: {
		        required: "L'adresse e-mail est requise.",
		        email: "Veuillez saisir une adresse e-mail valide.",
		        remote: "Adresse e-mail déjà utilisée."
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
		    type: "S'il vous plaît sélectionner le type de compte."
		},
        errorPlacement: function(error, element){
            const name = element.attr('name');
            error.appendTo($(`#error-${name}`));
        },
		highlight: function(element) {
		    $(element).next().addClass("input_error");
		},
		unhighlight: function(element) {
		    $(element).next().removeClass("input_error");
		},
		submitHandler: function(form){
            $.ajax({
                url: `${URLROOT}/user/register`,
                type: "POST",
                dataType: "json",
                data: $(form).serialize(),
                beforeSend: function(){
                    $('.register-message').text('');
                    $btnRegister.prop('disabled', true);
                    $btnRegister.html(`
                        <div class="spinner-border spinner-border-sm text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `);
                },
                success: function () {
                    window.location.href = URLROOT + '/user/verify';
                },
                error: function({responseJSON: response}){
					$('.divider').after(`
						<div class="alert alert-danger alert-dismissible register-message" role="alert">
							<div>${response.messages}</div>
						</div>
					`);
                },
                complete: function(){
                    $btnRegister.prop('disabled', false);
                    $btnRegister.text("S'inscrire");
                }
            });
        }
    });
});