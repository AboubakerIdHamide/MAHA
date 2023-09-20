$(function(){
    /*================ Handle forgot password ====================*/
    const $forgotForm = $('#forgot-form');
    
    $.validator.addMethod("validateUserEmail", function(value, element) {
        const email = $('#email').val();
        const isThisEmailNew = $.ajax({
            type: "POST",
            url: URLROOT + '/ajax/checkEmail',
            data: { email },
            async:false,
        }).responseText;

        return !JSON.parse(isThisEmailNew);
    }, "Nous ne trouvons pas d'utilisateur avec cette adresse e-mail.");

    $forgotForm.validate({
        onkeyup: false,
        onfocusout: false,
        rules: {
            email: {
                required: true,
                email: true,
                validateUserEmail: true,
            },
        },
        messages: {
            email: {
                required: "L'adresse e-mail est requise.",
                email: "Veuillez saisir une adresse e-mail valide.",
            },
        },
        highlight: function(element) {
            $(element).addClass("input_error");
        },
        unhighlight: function(element) {
            $(element).removeClass("input_error");
        },
        submitHandler: function(form){
            const $btnReset = $('#reset');
            const $showMessage = $('#message');
            starTimer(20);
            
            $.ajax({
                url: `${URLROOT}/user/forgot`,
                type: "POST",
                dataType: "json",
                data: $(form).serialize(),
                beforeSend: function(){
                    $('#email').prop('readonly', true);
                    $btnReset.prop('disabled', true);
                    $showMessage.empty();
                    $resentContainer.fadeIn(700);
                    $btnReset.html(`
                        <div class="spinner-border spinner-border-sm text-white" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `);
                },
                success: function ({messages}) {
                    $showMessage.html(`
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div>${messages}</div>
                        </div>
                    `);
                },
                error: function({responseJSON: {messages}}){
                    $showMessage.html(`
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div>${messages}</div>
                        </div>
                    `);
                },
                complete: function(){
                    $btnReset.prop('disabled', false);
                    $btnReset.text("Renvoyer");
                    $resentContainer.hide();
                }
            });
        }
    });

    /*========================== Handle Reset Password ====================  */
    const $resetForm = $('#reset-form');
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
    }, "");

    $resetForm.validate({
         rules: {
            password: {
                required: true,
                minlength: 10,
                maxlength: 50,
                passwordRequirements: true
            },
            password_confirmation: { equalTo: "#password" },
        },
        messages: {
            password: {
                required: "Le mot de passe est requis.",
                minlength: "Le mot de passe doit comporter au moins {0} caractères.",
                maxlength: "Le mot de passe ne doit pas dépasser {0} caractères.",
                passwordRequirements: "Le mot de passe doit contenir au moins un caractère spécial, un chiffre et une lettre."
            },
            password_confirmation: {
                equalTo: "La confirmation doit être identique au mot de passe."
            },
        },
        highlight: function(element) {
            $(element).addClass("input_error");
        },
        unhighlight: function(element) {
            $(element).removeClass("input_error");
        }
    });

    // Page Loader
    document.body.style.overflow = "hidden";
    $(window).on('load', function () {
        document.body.style.overflow = "auto";
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350);
        $(window).scroll();
    });

    /*================= Resend Verification Email ==================*/
    const $btnResend = $('#resend');
    $btnResend.click(function() {
        resendVerificationEmail($(this));
        starTimer(15);

        function resendVerificationEmail(btnResend) { 
            $.ajax({
                url : `${URLROOT}/user/sendEmailVerification`,
                type: 'POST',
                dataType: 'json',
                beforeSend: function(){
                    $('.resent-message').remove();
                    $resentContainer.fadeIn(700);
                    btnResend
                    .prop('disabled', true)
                    .html(`
                        <div class="spinner-border spinner-border-sm text-white" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `);
                },
                success: function({messages}){
                    $resentContainer.after(`
                        <div class="alert alert-success w-100 resent-message">
                            ${messages}
                        </div>
                    `);
                },
                error: function({responseJSON: { messages, status }}){
                    if(status === 500) {
                        $resentContainer.after(`
                            <div class="alert text-center alert-danger w-100 resent-message">
                                ${messages}
                            </div>
                        `);
                    }else{
                        window.location.href = URLROOT;
                    }
                },
                complete: function(){
                    btnResend.prop('disabled', false).text('Renvoyer');
                    $resentContainer.hide();
                }
            });
        };
    });

    /*=============== Timer helper ===================*/
    const $resentContainer = $('.resent-container');
    
    function starTimer(waitingTime) {
        const $timer = $('#timer');
        $timer.text(waitingTime);
        const intervalTimer = setInterval(() => {
            $timer.text(--waitingTime);
            if(waitingTime === 0) stopTimer();
        }, 1000);

        function stopTimer(){
            clearInterval(intervalTimer);
        }
    }
})