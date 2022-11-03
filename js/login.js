const  errorSpans_email = document.querySelector("#error-email"),
errorSpans_mdp = document.querySelector("#error-mdp"),
mainForm = document.querySelector(".mainForm"),
err = document.querySelectorAll(".error"),
togglePassword = document.querySelector("#togglePassword"),
password = document.querySelector("#password");

// show & hide password :

togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    // toggle the icon
    this.classList.toggle("bi-eye");
});

// E-mail validation :

function validateEmail() {
    let emailInp = document.getElementById("email"),
    Errors = [],
    emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;        
    if (!emailInp.value.match(emailRe)) {
        Errors.push({
        id: "error-email",
        msg: "L'email que vous saisi est invalide"
        });
    }
        
    if (emailInp.value == "" || emailInp.value == null) {
        Errors.push({ id: "error-email", msg: "L'e-mail est obligatoire" });
    }
        
        return Errors;
}

// password validation :
        
function validateMotDePasse() {
            let mdpInp = document.getElementById("password"),
                Errors = [];
            
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

mainForm.onsubmit = function(e){
        for (let i = 0; i<err.length; i++){
            err[i].textContent = "";
        }
        var er_email = validateEmail()
        if(er_email.length != 0){
            e.preventDefault();
            for (let i = 0; i<er_email.length; i++){
                errorSpans_email.textContent = er_email[i].msg;
            } 
        } 
        var er_mdp = validateMotDePasse()
        if(er_mdp.length != 0){
            e.preventDefault();
            for (let i = 0; i<er_mdp.length; i++){
                errorSpans_mdp.textContent = er_mdp[i].msg;
            } 
        } 
    }           