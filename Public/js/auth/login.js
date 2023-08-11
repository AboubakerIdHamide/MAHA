$(function () {
    const facebookLoginBtn = document.getElementById("facebook-login");
    const googleLoginBtn = document.getElementById("google-login");
    const loginTypeError = document.querySelector(".connection-error");

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
                passwordRequirements: true
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
                passwordRequirements: "Le mot de passe doit contenir au moins un caractère spécial, un chiffre et une lettre."
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

    //======== Google Auth =========
    googleLoginBtn.addEventListener("click", ()=>{
        google.accounts.id.initialize({
            client_id: '778408900492-6dbjf9arq9mo3thm3l4fr4fid6sjcis6.apps.googleusercontent.com',
            callback: handleCredentialResponse
        });
        google.accounts.id.prompt();
    })

    function handleCredentialResponse(response){
        const {credential} = response;    
        tokenSender(credential, "googleLogin");
    }

    //======== Facebook Auth =========
    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            const { accessToken }=response?.authResponse;
            tokenSender(accessToken, "facebookLogin");
        } else {
          loginTypeError.innerHTML = 'Veuillez vous connecter à cette application.';
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId: '254302633937045',
            cookie: true,
            xfbml: true,
            version: 'v17.0'
        });

        facebookLoginBtn.addEventListener('click', function() {
          FB.login(checkLoginState);
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    //======== Helpers ======
    function getxhr() {
        try {
            xhr = new XMLHttpRequest();
        } catch (e) {
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e1) {
                try {
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e2) {
                    alert("Ajax n'est pas supporté par votre navigateur !");
                }
            }
        }
        return xhr;
    }

    function tokenSender(token, route){
        xhr = getxhr();
        xhr.open("POST", `http://localhost/maha/ajax/${route}`, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`token=${token}`);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);
                    if(response?.authorized){
                        window.location=response?.url;
                        loginTypeError.innerHTML=response?.message;
                    }else{
                        loginTypeError.innerHTML=response?.message;
                    }
                } else {
                    alert("Erreur serveur!");
                }
            }
        }
    }

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