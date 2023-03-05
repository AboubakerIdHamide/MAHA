$(document).ready(function () {
	const inputsIcons = [];
	const $updateBtn = $("#update-info");

	inputsIcons.push($("#nom-icon"));
	inputsIcons.push($("#prenom-icon"));
	inputsIcons.push($("#bio-icon"));
	inputsIcons.push($(".eye-icon"));
	inputsIcons.push($("#phone-icon"));

	for (let inputIcon of inputsIcons) {
		inputIcon.click(function (event) {
			const $parent = $(this).parent();
			let element = "input";

			if ($(this).hasClass("eye-icon")) {
				let $icon = $parent.find("i");
				$parent
					.find(element)
					.attr("type", (_, attr) =>
						attr == "text" ? "password" : "text"
					);
				if ($icon.hasClass("fa-eye-slash"))
					$icon.removeClass("fa-eye-slash").addClass("fa-eye");
				else $icon.removeClass("fa-eye").addClass("fa-eye-slash");
				return;
			}

			if ($(this).hasClass("bio-icon")) {
				element = "textarea";
				$parent
					.find(element)
					.removeAttr("disabled")
					.focus()
					.blur(function () {
						$(this).attr("disabled", "true");
					});
			} else {
				$parent
					.find(element)
					.removeAttr("disabled")
					.focus()
					.blur(function () {
						$(this).attr("disabled", "true");
					});
			}
		});
	}
	// ====================  Update Avatar  ================
	$('#avatar').change(function (event) {
		const allowedExt = ['image/jpeg', 'image/png', 'image/jpg'];
		const fileType = event.target.files[0].type;

		if(!allowedExt.includes(fileType))
			return;

		// console.log('Ajax Call');

		var fd = new FormData();
		var files = event.target.files[0];
		fd.append('img',files);
		$.ajax({
			url: 'http://localhost/maha/Formateurs/changeImg/',
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			success: function(response){
				console.log(response);
				if(response == false){
					$("#avatar-profil").attr("src",response.img);
				}else{
					$('#error-img-avatar').textContent = response.img_err;
				}
			},
		});

		// const x = URL.createObjectURL(event.target.files[0]);
		// $('#avatar-profil').attr('src', x);
	});


	// =================================== Validation Functions =================================
	function validateNomPrenom() {
		let nomInp = document.getElementById("nom"),
			prenomInp = document.getElementById("prenom"),
			Errors = [];

		if (nomInp.value.match(/[0-9]/)) {
			Errors.push({
				id: "error-nom",
				msg: "Le nom ne doit pas contient des nombres",
			});
			return Errors;
		}

		if (prenomInp.value.match(/[0-9]/)) {
			Errors.push({
				id: "error-prenom",
				msg: "Le prenom ne doit pas contient des nombres",
			});
			return Errors;
		}

		if (nomInp.value.includes(" ")) {
			Errors.push({
				id: "error-nom",
				msg: "Le nom ne doit pas contient des espaces",
			});
			return Errors;
		}

		if (prenomInp.value.includes(" ")) {
			Errors.push({
				id: "error-prenom",
				msg: "Le prenom ne doit pas contient des espaces",
			});
			return Errors;
		}

		if (
			nomInp.value == "" ||
			nomInp.value.length < 3 ||
			nomInp.value == null
		) {
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

	function validateTele() {
		let teleInp = document.getElementById("tele"),
			Errors = [],
			phoneRe = /^((06|07)\d{8})+$/gi;

		
		if (!teleInp.value.match(phoneRe) || teleInp.value.length != 10) {
			Errors.push({
				id: "error-tele",
				msg: "Le numéro de telephone que vous saisi est invalide",
			});
		}

		if (teleInp.value == "" || teleInp.value == null) {
			Errors.push({
				id: "error-tele",
				msg: "Le numéro de telephone est obligatoire",
			});
		}
		return Errors;
	}

	function validateMotDePasse(motDePasse = "mdp-c") {
		let mdpInp = document.getElementById(motDePasse),
			Errors = [];

		if(motDePasse === "mdp-c" && mdpInp.value === ""){
			Errors.push({
				id: "error-mdp-c",
				msg: "Veuillez remplir ce champ pour effectue le changement.",
			});
			return Errors;
		}

		if (!mdpInp.value.match(/[!@#$%^&*()\-__+.]/)) {
			Errors.push({
				id: "error-" + motDePasse,
				msg: "Le mot de passe doit contient spécial character",
			});
		}
		if (!mdpInp.value.match(/\d/)) {
			Errors.push({
				id: "error-" + motDePasse,
				msg: "Le mot de passe doit contenir au moins 1 chiffres",
			});
		}
		if (!mdpInp.value.match(/[a-zA-Z]/)) {
			Errors.push({
				id: "error-" + motDePasse,
				msg: "Le mot de passe doit contenir au moins 1 lettre",
			});
		}

		if (
			mdpInp.value == "" ||
			mdpInp.value == null ||
			mdpInp.value.length < 10
		) {
			Errors.push({
				id: "error-" + motDePasse,
				msg: "Le mot de passe doit comporter au moins 10 caractères",
			});
		}

		if (mdpInp.value.length > 50) {
			Errors.push({
				id: "error-" + motDePasse,
				msg: "Le mot de passe doit comporter au maximum 50 caractères",
			});
		}

		return Errors;
	}

	function validateBioSpec() {
		let specInp = document.getElementById("spec"),
			bioTextarea = document.getElementById("bio"),
			Errors = [];

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
	// ======================================================================= //
	$updateBtn.click((e) => {
		// Clear All Error Messages
		let errorSmalls = document.querySelectorAll(".error");
		errorSmalls.forEach((small) => {
			small.textContent = "";
		});

		let Errors = [];

		// change password
		const newMdp = $("#mdp");
		if(newMdp.val() != ''){
			if (validateMotDePasse("mdp").length != 0) Errors.push(validateMotDePasse("mdp"));
		}

		if (validateNomPrenom().length != 0) Errors.push(validateNomPrenom());
		if (validateTele().length != 0) Errors.push(validateTele());
		if (validateMotDePasse().length != 0) Errors.push(validateMotDePasse());
		if (validateBioSpec().length != 0) Errors.push(validateBioSpec());

		if (Errors.length != 0) {
			e.preventDefault();
			Errors.forEach((errorss) => {
				errorss.forEach((error) => {
					document.querySelector(`#${error.id}`).textContent =
						error.msg;
				});
			});
		} 
		else {
			const updateFormateurInfo = {
				nom : $('#nom').val(),
				prenom : $('#prenom').val(),
				specialite : $('#spec').val(),
				biographie : $('#bio').val(),
				tel : $('#tele').val(),
				c_mdp : $('#mdp-c').val(),
				n_mdp : $('#mdp').val(),
			};
			
			// console.log('Ajax Call', updateFormateurInfo);
			xhr=getxhr();
			xhr.open("POST", "http://localhost/maha/Formateurs/updateInfos/", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // for protection
			xhr.send(`nom=${updateFormateurInfo.nom}&prenom=${updateFormateurInfo.prenom}&tel=${updateFormateurInfo.tel}&specialite=${updateFormateurInfo.specialite}&biographie=${updateFormateurInfo.biographie}&c_mdp=${updateFormateurInfo.c_mdp}&n_mdp=${updateFormateurInfo.n_mdp}`);

			
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						console.log(xhr.responseText);
						let response=JSON.parse(xhr.responseText);
						console.log(response);
						if(response.thereIsError==true){
							Errors.push(
								{id: "error-nom", msg: response.nom_err},
								{id: "error-prenom", msg: response.prenom_err},
								{id: "error-tele", msg: response.tel_err},
								{id: "error-spec", msg: response.specId_err},
								{id: "error-bio", msg: response.bio_err},
								{id: "error-mdp-c", msg: response.c_mdp_err},
								{id: "error-mdp", msg: response.n_mdp_err}
							);
							Errors.forEach((error) => {	
								document.querySelector(`#${error.id}`).textContent = error.msg;
							});
						}else{
							$("p.success-msg").html(`
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Success!</strong> Your profil has been updated!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
							`);
							$('p.speciality-display').text(response.categorie);
							$('p.bio-display').text(response.bio);
							$('h5.nom-prenom').text(response.nom + ' ' + response.prenom);
							if(newMdp.val() != '') updateFormateurInfo.newPassword = newMdp.val();
						}
					} else {
						alert("Error Server!");
					}
				}
			}
		}
	});
	function getxhr(){
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
});