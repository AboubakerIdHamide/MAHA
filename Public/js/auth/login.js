$(function () {
    // Validate login form
    const $loginForm = $('#login-form');

    $loginForm.validate({
       rules: {
            email: {
                required: true,
                email: true,
            },
            mdp: {
                required: true,
                minlength: 10,
                maxlength: 50,
            },
        },
        messages: {
            email: {
                required: "L'adresse e-mail est requise.",
                email: "Veuillez saisir une adresse e-mail valide.",
            },
            mdp: {
                required: "Le mot de passe est requis.",
                minlength: "Le mot de passe doit comporter au moins {0} caractères.",
                maxlength: "Le mot de passe ne doit pas dépasser {0} caractères.",
            },
        },
        errorPlacement: function(error, element){
            const name = element.attr('name');
            $(`#error-${name}`).html(error);
        },
        highlight: function(element) {
            $(element).next().addClass("input_error");
        },
        unhighlight: function(element) {
            $(element).next().removeClass("input_error");
        },
    });

    // On click hide all items except the clicked button and two radio buttons to choose between
    function socialAuthManager(provider, otherButtonsToHide, providerRef) {
        if($(`.user-types-${provider}`).length) {
            const $errorType = $('#error-type');
            const $checkedType = $('[name="type-user"]:checked');
            if($checkedType.length === 0) {
                $errorType.html(`
                    <label id="type-error" class="error" for="type">S'il vous plaît sélectionner le type de compte.</label>
                `)
            }else{
                $errorType.empty();

                const loginLink = providerRef.attr('href');

                $.post(`${URLROOT}/user/setUserType`, { user_type: $checkedType.first().val() }, function(data, status) {
                    window.location.href = loginLink;
                });
            }
            return;
        }
        const elementToToggle = `.user-types, .form-group, .divider, #btn-login, ${otherButtonsToHide}`;
        $(elementToToggle).fadeOut();
        providerRef.before(`
            <div class="mb-2 user-types-${provider}">
                <span class="back-icon"><i class="fa-solid fa-arrow-left"></i></span>
                <label style="color: #999">Veuillez choisir entre les deux options suivantes:</label>
                <div class="radio-tile-group">
                    <div class="input-container w-50">
                      <input id="etudiant" class="radio-button" type="radio" name="type-user" value="etudiant" />
                      <div class="radio-tile">
                        <div class="icon">
                          <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <label for="drive" class="radio-tile-label">Etudiant</label>
                      </div>
                    </div>

                    <div class="input-container w-50">
                      <input id="formateur" class="radio-button" type="radio" name="type-user" value="formateur" />
                      <div class="radio-tile">
                        <div class="icon">
                          <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <label for="fly" class="radio-tile-label">Formateur</label>
                      </div>
                    </div>
                </div>
                <small class="error-message d-inline-block text-center" id="error-type"></small>
            </div>
        `);

        $('.back-icon').one('click', function () {
            $(elementToToggle).fadeIn();
            $(`.user-types-${provider}`).remove();
        });
    }

    // SOCIAL AUTH
    const $socialButtons = $('.social_bt');
    $socialButtons.on('click', function(e){
        e.preventDefault();
        const providerName = $(this).attr('id');
        const otherButtonsToHide = '#' + $socialButtons.map((i, element) => {
            if(element.id !== providerName){
                return element.id;   
            }
        }).get().join(', #');

        socialAuthManager(providerName, otherButtonsToHide, $(this));
    });

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

    // Toggle Password
    $(".toggle-eye").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        $("#password").attr("type", function(_, attr) { return attr === "password" ? "text" : "password"; });
    });
});