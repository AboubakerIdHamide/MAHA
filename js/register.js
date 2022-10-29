let stepsDivs = document.querySelectorAll(".steps div"),
  inputsSlider = document.getElementById("inputsSlider"),
  formProgress = document.querySelector(".form-progress"),
  fillProgress = document.getElementById("fillSpan"),
  lastStepTitle = document.querySelector(".last-step"),
  fillProgWidth = 0,
  sectionFieldIndex = 0,
  transformXPixels = 0,
  nextBtn = document.getElementById("next"),
  prevBtn = document.getElementById("prev"),
  lastSection = document.getElementById("lastSection"),
  showIcon = document.getElementById("showPassIcon"),
  ImageINput = document.getElementById("photoInp"),
  UploadFileContainer = document.querySelector(".img-profile-wrapper"),
  imageINputErrors = [];

// =================================== Validation Functions =================================
function validateNomPrenom() {
  let nomInp = document.getElementById("nom"),
    prenomInp = document.getElementById("prenom"),
    Errors = [];

  if (nomInp.value == "" || nomInp.value.length < 3 || nomInp.value == null) {
    Errors.push({
      id: "error-nom",
      msg: "Le nom doit comporter au moins 3 caractères",
    });
  }

  if (
    prenomInp.value == "" ||
    prenomInp.value.length < 3 ||
    prenomInp.value == null
  ) {
    Errors.push({
      id: "error-prenom",
      msg: "Le prenom doit comporter au moins 3 caractères",
    });
  }

  if (nomInp.value.length > 30) {
    Errors.push({
      id: "error-nom",
      msg: "Le nom doit comporter au maximum 30 caractères",
    });
  }

  if (prenomInp.value.length > 30) {
    Errors.push({
      id: "error-prenom",
      msg: "Le prenom doit comporter au maximum 30 caractères",
    });
  }

  return Errors;
}

function validateEmailTele() {
  let emailInp = document.getElementById("email"),
    teleInp = document.getElementById("tele"),
    Errors = [],
    emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    phoneRe = /^((06|07)\d{8})+$/gi;

  if (!emailInp.value.match(emailRe)) {
    Errors.push({
      id: "error-email",
      msg: "L'email que vous saisi est invalide",
    });
  }
  if (!teleInp.value.match(phoneRe) || teleInp.value.length != 10) {
    Errors.push({
      id: "error-tele",
      msg: "Le numéro de telephone que vous saisi est invalide",
    });
  }

  if (emailInp.value == "" || emailInp.value == null) {
    Errors.push({ id: "error-email", msg: "L'é-mail est obligatoire" });
  }
  if (teleInp.value == "" || teleInp.value == null) {
    Errors.push({
      id: "error-tele",
      msg: "Le numéro de telephone est obligatoire",
    });
  }
  return Errors;
}

function validateMotDePasse() {
  let mdpInp = document.getElementById("mdp"),
    vmdpInp = document.getElementById("vmdp"),
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

  if (vmdpInp.value == "" || vmdpInp.value != mdpInp.value) {
    Errors.push({
      id: "error-vmdp",
      msg: "Les deux mots de passe doivent être identiques",
    });
  }

  return Errors;
}

function validateBioPmail() {
  let pmailInp = document.getElementById("pmail"),
    specInp = document.getElementById("spec"),
    bioTextarea = document.getElementById("bio"),
    emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    Errors = [];

  if (!pmailInp.value.match(emailRe)) {
    Errors.push({
      id: "error-pmail",
      msg: "L'email que vous saisi est invalide",
    });
  }

  if (pmailInp.value == "" || pmailInp.value == null) {
    Errors.push({
      id: "error-pmail",
      msg: "L'é-mail de Paypal est obligatoire",
    });
  }

  if (specInp.value == "aucun" || specInp.value == null) {
    Errors.push({ id: "error-spec", msg: "Choisissez une spécialité" });
  }

  if (bioTextarea.value.length < 130 || bioTextarea.value == null) {
    Errors.push({
      id: "error-bio",
      msg: "le résumé doit avoir au moins 130 caractères !",
    });
  }

  if (bioTextarea.value.length > 500) {
    Errors.push({
      id: "error-bio",
      msg: "La Biography doit comporter au maximum 500 caractères",
    });
  }

  return Errors;
}

function formateurOrEtudiant() {
  let formateur = document.getElementById("formateur"),
    etudiant = document.getElementById("etudiant");

  if (formateur.checked) {
    return true;
  }
  return false;
}

// =================================== Prev & Next Events & Show Pass Icon ==================
nextBtn.addEventListener("click", (e) => {
  // Clear All Error Messages
  let errorSpans = document.querySelectorAll(".error");
  errorSpans.forEach((span) => {
    span.textContent = "";
  });

  // Validat The Current Section Errors
  let Errors = [];
  if (sectionFieldIndex == 0) {
    Errors = validateNomPrenom();
  } else if (sectionFieldIndex == 1) {
    Errors = validateEmailTele();
  } else if (sectionFieldIndex == 2) {
    Errors = validateMotDePasse();
  } else if (sectionFieldIndex == 3) {
    Errors = imageINputErrors;
  } else if (sectionFieldIndex == 4) {
    Errors = validateBioPmail();
  } else {
    Errors = [];
  }
  // Controll Error And Input Slider
  if (Errors.length != 0) {
    e.preventDefault();
    Errors.forEach((error) => {
      document.querySelector(`#${error.id}`).textContent = error.msg;
    });
  } else {
    if (sectionFieldIndex == 3) {
      if (formateurOrEtudiant()) {
        lastSection.innerHTML = `
				<div class="input-box">
                        <div class="field">
                            <label for="pmail">Email Paypal :</label>
                            <input type="email" id="pmail" name="pmail">
                            <span class="error" id="error-pmail"></span>
                        </div>
                        <div class="field">
                            <label spec="bio">Spécialité :</label>
                            <select name="specialite" id="spec">
                                <option value="aucun">Aucun</option>
                                <option value="dev">Devlopment Web</option>
                                <option value="wd">Web Design</option>
                                <option value="uiux">UI/UX Design</option>
                            </select>
                            <span class="error" id="error-spec"></span>
                        </div>
                        <div class="field">
                            <label for="bio">Biography :</label>
                            <textarea name="biography" id="bio"></textarea>
                            <span class="error" id="error-bio"></span>
                        </div>
                    </div>
				`;
        if (
          lastStepTitle.classList.contains("hide") &&
          !formProgress.classList.contains("hide")
        ) {
          lastStepTitle.classList.remove("hide");
          formProgress.classList.add("hide");
        }
      } else {
        lastSection.innerHTML = `
				<div class="alert-regiter-msg">
					Vous avez terminé l'opération d'inscription
					merci de valider
                </div>
				`;
        if (
          !lastStepTitle.classList.contains("hide") &&
          formProgress.classList.contains("hide")
        ) {
          lastStepTitle.classList.add("hide");
          formProgress.classList.remove("hide");
        }
      }
      nextBtn.textContent = "Valider";
    } else {
      nextBtn.textContent = "Suivant";
    }
    if (sectionFieldIndex != 4) {
      e.preventDefault();
    }

    fillProgWidth == 99 ? 99 : (fillProgWidth += 33);
    transformXPixels = (sectionFieldIndex + 1) * 100;

    fillProgress.style.setProperty("width", `${fillProgWidth}%`);
    inputsSlider.style.setProperty(
      "transform",
      `translateX(-${transformXPixels}%)`
    );
    stepsDivs[sectionFieldIndex > 3 ? 3 : sectionFieldIndex].classList.add(
      "active"
    );
    sectionFieldIndex++;

    if (sectionFieldIndex != 0) {
      prevBtn.classList.remove("not-allowed");
    }
  }
});

prevBtn.addEventListener("click", (e) => {
  e.preventDefault();
  if (sectionFieldIndex != 3) {
    nextBtn.textContent = "Suivant";
    lastSection.innerHTML = `
		<div class="alert-regiter-msg">
			Vous avez terminé l'opération d'inscription
			merci de valider
		</div>
		`;
    if (
      !lastStepTitle.classList.contains("hide") &&
      formProgress.classList.contains("hide")
    ) {
      lastStepTitle.classList.add("hide");
      formProgress.classList.remove("hide");
    }
  }

  sectionFieldIndex == 0 ? sectionFieldIndex : sectionFieldIndex--;
  fillProgWidth == 0 ? 0 : (fillProgWidth -= 33);
  transformXPixels == 0 ? transformXPixels : (transformXPixels -= 100);

  fillProgress.style.setProperty("width", `${fillProgWidth}%`);
  inputsSlider.style.setProperty(
    "transform",
    `translateX(-${transformXPixels}%)`
  );
  stepsDivs[sectionFieldIndex].classList.remove("active");

  if (sectionFieldIndex == 0) {
    prevBtn.classList.add("not-allowed");
  }
});

showIcon.onclick = () => {
  let mdpInp = document.getElementById("mdp"),
    vmdpInp = document.getElementById("vmdp");
  if (mdpInp.type == "password") {
    mdpInp.type = "text";
    vmdpInp.type = "text";
    showIcon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    mdpInp.type = "password";
    vmdpInp.type = "password";
    showIcon.classList.replace("fa-eye-slash", "fa-eye");
  }
};

// Upload Image Effects
ImageINput.addEventListener("change", function () {
  let imgName = ImageINput.files[0].name.split("."),
    photoErrorSpan = document.getElementById("error-photo"),
    imgExt = imgName[imgName.length - 1],
    allowedExt = ["png", "jpg", "jpeg", "svg", "ico"];

  // Clear Image Error
  photoErrorSpan.textContent = "";
  imageINputErrors = [];

  const reader = new FileReader();
  reader.addEventListener("load", () => {
    if (!allowedExt.includes(imgExt)) {
      UploadFileContainer.style.backgroundImage = `url(./images/default.jpg)`;
      photoErrorSpan.textContent = "Fichier non supporté !";
      imageINputErrors.push({
        id: "error-photo",
        msg: "Fichier non supporté !",
      });
    } else {
      UploadFileContainer.style.backgroundImage = `url(${reader.result})`;
    }
  });
  reader.readAsDataURL(this.files[0]);
  reader.onerror = () => {
    imageINputErrors.push({
      id: "error-photo",
      msg: "Une erreur s'est produite lors du téléchargement de cette image",
    });
  };
});
