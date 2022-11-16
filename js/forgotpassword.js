let emailInp = document.getElementById("email"),
    submitBtn= document.getElementById("submit"),
    mdpInp = document.getElementById("mdp"),
    vmdpInp = document.getElementById("vmdp"),
    errorSpans = document.querySelectorAll(".error"),
    Errors = [],
    emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


submitBtn.addEventListener("click", (e)=>{
    // clear error spans
    errorSpans.forEach((span) => {
        span.textContent = "";
    });

    // validate data
    validateData();

    // show errors
    if(Errors.length!=0){
        e.preventDefault();
        Errors.forEach((error) => {
            document.querySelector(`#${error.id}`).textContent = error.msg;
        });
    }
})

function validateData(){
    // Email Validation
    if (!emailInp.value.match(emailRe)) {
        Errors.push({
          id: "error-email",
          msg: "L'email que vous saisi est invalide",
        });
      }
    if (emailInp.value == "" || emailInp.value == null) {
        Errors.push({ id: "error-email", msg: "L'é-mail est obligatoire" });
    }

    // Password Validation
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
    if (vmdpInp.value == "" || vmdpInp.value != mdpInp.value) {
    Errors.push({
        id: "error-vmdp",
        msg: "Les deux mots de passe doivent être identiques",
    });
    }
}
