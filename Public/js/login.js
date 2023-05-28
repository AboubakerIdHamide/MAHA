const errorSpans_email = document.querySelector("#error-email")
  , errorSpans_mdp = document.querySelector("#error-mdp")
  , mainForm = document.querySelector(".mainForm")
  , err = document.querySelectorAll(".error")
  , togglePassword = document.querySelector("#togglePassword")
  , password = document.querySelector("#password")
  , mahaLoginBtn = document.getElementById("maha-login")
  , facebookLoginBtn = document.getElementById("facebook-login")
  , googleLoginBtn = document.getElementById("google-login")
  , loginTypeContainer = document.querySelector(".login-type")
  , mahaLoginFields = document.querySelector(".maha-fields")
  , loginTypeError = document.querySelector(".connection-error");

// show & hide password :

togglePassword.addEventListener("click", function() {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    // toggle the icon
    if (this.classList.contains('fa-eye')) {
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
    }
});

// E-mail validation :

function validateEmail() {
    let emailInp = document.getElementById("email")
      , Errors = []
      , emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!emailInp.value.match(emailRe)) {
        Errors.push({
            id: "error-email",
            msg: "L'email que vous saisi est invalide"
        });
    }

    if (emailInp.value == "" || emailInp.value == null) {
        Errors.push({
            id: "error-email",
            msg: "L'e-mail est obligatoire"
        });
    }

    return Errors;
}

// password validation :

function validateMotDePasse() {
    let mdpInp = document.getElementById("password")
      , Errors = [];

    if (!mdpInp.value.match(/[!@#$%^&*()\-__+.]/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contient spécial character",
        });
    }
    if (!mdpInp.value.match(/\d/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contenir au moins 1 chiffres",
        });
    }
    if (!mdpInp.value.match(/[a-zA-Z]/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contenir au moins 1 lettre",
        });
    }

    if (mdpInp.value == "" || mdpInp.value == null || mdpInp.value.length < 10) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit comporter au moins 10 caractères",
        });
    }

    if (mdpInp.value.length > 50) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit comporter au maximum 50 caractères",
        });
    }

    return Errors;
}

// submit validation event : 

mainForm.onsubmit = function(e) {
    for (let i = 0; i < err.length; i++) {
        err[i].textContent = "";
    }
    var er_email = validateEmail()
    if (er_email.length != 0) {
        e.preventDefault();
        for (let i = 0; i < er_email.length; i++) {
            errorSpans_email.textContent = er_email[i].msg;
        }
    }
    var er_mdp = validateMotDePasse()
    if (er_mdp.length != 0) {
        e.preventDefault();
        for (let i = 0; i < er_mdp.length; i++) {
            errorSpans_mdp.textContent = er_mdp[i].msg;
        }
    }
}

// =================================== Login Type Handling ===============================
mahaLoginBtn.addEventListener("click", ()=>{
    hideRegisterType();
})

function hideRegisterType(){
    loginTypeContainer.classList.add("hide");
    mahaLoginFields.classList.remove("hide");
}

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
      loginTypeError.innerHTML = 'Please log into this app.';
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
                alert("Error Server!");
            }
        }
    }
}