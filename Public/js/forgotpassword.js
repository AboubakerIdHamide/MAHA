let emailInp = document.getElementById("email")
  , submitBtn = document.getElementById("submit")
  , mdpInp = document.getElementById("mdp")
  , vmdpInp = document.getElementById("vmdp")
  , errorSpans = document.querySelectorAll(".error")
  , emailBackEndError = []
  , Errors = []
  , emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

// =========================== EventListeners ===========================
submitBtn.addEventListener("click", (e)=>{
    // clear error array and spans
    Errors = [];
    errorSpans.forEach((span)=>{
        span.textContent = "";
    }
    );

    // validate data
    Errors = [...emailBackEndError, ...validateData()];

    // show errors
    if (Errors.length != 0) {
        e.preventDefault();
        Errors.forEach((error)=>{
            document.querySelector(`#${error.id}`).textContent = error.msg;
        }
        );
    }
}
)

emailInp.addEventListener("keyup", ()=>{
    emailBackEndError = [];
    xhr = getxhr();
    xhr.open("POST", "http://localhost/maha/ajax/checkEmail", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // for protection
    xhr.send(`email=${emailInp.value}`);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.thereIsError == false) {
                    emailBackEndError.push({
                        id: "error-email",
                        msg: "Aucun utilisateur avec cet e-mail"
                    })
                }
            } else {
                alert("Erreur serveur!");
            }
        }
    }
}
)

// =========================== Functions & Ajax ===========================
function validateData() {
    let Errors = [];
    // Email Validation
    if (!emailInp.value.match(emailRe)) {
        Errors.push({
            id: "error-email",
            msg: "E-mail invalide",
        });
    }
    if (emailInp.value == "" || emailInp.value == null) {
        Errors.push({
            id: "error-email",
            msg: "L'e-mail est obligatoire"
        });
    }

    // Password Validation
    if (!mdpInp.value.match(/[!@#$%^&*()\-__+.]/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contient au moin un caractère spécial",
        });
    }
    if (!mdpInp.value.match(/\d/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contenir au moins un chiffre",
        });
    }
    if (!mdpInp.value.match(/[a-zA-Z]/)) {
        Errors.push({
            id: "error-mdp",
            msg: "Le mot de passe doit contenir au moins une lettre",
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
    if (vmdpInp.value == "" || vmdpInp.value != mdpInp.value) {
        Errors.push({
            id: "error-vmdp",
            msg: "Les deux mots de passe doivent être identiques",
        });
    }

    return Errors;
}

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
