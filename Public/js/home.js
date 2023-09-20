$(function(){
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

    const $contactUsForm = $("#contact-form");
    const $btnSubmit = $('#submit-contact');
  
    // Contact Us form validation
    $contactUsForm.validate({
        rules : {
            name : "required",
            email : {
                required: true,
                email: true
            },
            subject: "required",
            message : "required"
        },
        messages: {
            name: "Le nom est requis.",
            email: {
                required: "L'adresse e-mail est requise.",
                email: "Veuillez saisir une adresse e-mail valide."
            },
            subject: "Le sujet est requis.",
            message: "Le message est requis."
        },
        errorPlacement: function(error, element){
            const name = element.attr('name');
            error.appendTo($(`.${name}_error`));
        },
        submitHandler: function(form){
            $.ajax({
                url: `${URLROOT}/user/contactUs`,
                type: "POST",
                dataType: "json",
                data: $(form).serialize(),
                beforeSend: function(){
                    $('small.error').text('');
                    $btnSubmit.prop('disabled', true);
                    $btnSubmit.html(`
                        <div class="spinner-border spinner-border-sm text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `);
                },
                success: function ({data: message}) {
                    $('#message-contact').html(`
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div>${message}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                error: function({responseJSON: response}){
                    if(response.status === 500){
                        $('#message-contact').html(`
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div>${response.data}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }else{
                        const { messages: errors } = response;
                        for(let error in errors){
                            $(`small.${error}`).text(errors[error]);
                        }
                    }
                },
                complete: function(){
                    $btnSubmit.prop('disabled', false);
                    $btnSubmit.html("Envoyer Mon Message");
                }
            });
        }
    });

    // WoW - animation on scroll
    const wow = new WOW({
        boxClass:     'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset:       0,          // distance to the element when triggering the animation (default is 0)
        mobile:       true,       // trigger animations on mobile devices (default is true)
        live:         true,       // act on asynchronously loaded content (default is true)
        callback:     function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null // optional scroll container selector, otherwise use window
    });

    wow.init();

    // Popular Courses
    $('#reccomended').owlCarousel({
        center: true,
        items: 2,
        loop: true,
        margin: 0,
        responsive: {
            0: {
                items: 1
            },
            767: {
                items: 2
            },
            1000: {
                items: 3
            },
            1400: {
                items: 4
            }
        }
    });

    // Best Selling Instructors.
    $('#instructors').owlCarousel({
        center: true,
        items: 2,
        loop: true,
        margin: 0,
        responsive: {
            0: {
                items: 1
            },
            767: {
                items: 2
            },
            1000: {
                items: 3
            },
            1400: {
                items: 4
            }
        }
    });

    // Set type user in localStorage 
    $('.join').click(function(){
        localStorage.setItem('type', $(this).data('type'));
    });
});