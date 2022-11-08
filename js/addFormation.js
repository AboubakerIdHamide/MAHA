/* =========================== Global Variables =========================== */
let sectionIndex = 0,
	sectionSlyder = document.getElementById("fieldSectionSlyder"),
	prevBtn = document.getElementById("prev"),
	nextBtn = document.getElementById("next"),
	errorSpans = document.querySelectorAll(".error"),
	progressBar = document.getElementById("prog_bar"),
	progressBarWidth = 0,
	textareaDesc = document.getElementById("description"),
	textareaLen = document.getElementById("txtLen"),
	ImageINput = document.getElementById("image"),
	UploadFileContainer = document.querySelector(".image-uploader"),
	videosInput = document.getElementById("videos"),
	videosContainer = document.getElementById("uplodedVideosContainer"),
	videosHiddenInp = document.getElementById("jsonVideos"),
	videoErrorSpan = document.getElementById("error_videos"),
	imageINputErrors = [],
	videoINputErrors = [],
	videoJsObjects = [],
	Files = [],
	canISubmit = false;

/* =========================== Event Listeners =========================== */
nextBtn.addEventListener("click", function (e) {
	let Errors = [];
	switch (sectionIndex) {
		case 0:
			Errors = validateSectionOne();
			break;
		case 1:
			Errors = [...validateSectionTwo(), ...imageINputErrors];
			nextBtn.textContent = "Valider";
			break;
		case 2:
			if (Files.length == 0) {
				videoINputErrors.push({
					id: "error_videos",
					msg: "Le chargement des vidéos est obligatoire",
				});
			} else {
				videoINputErrors = [];
			}
			Errors = videoINputErrors;
			break;
		default:
			Errors = [];
	}

	// clear all errors
	errorSpans.forEach((errSpan) => {
		errSpan.textContent = "";
	});

	// prevent if not the last section
	if (canISubmit == false || sectionIndex != 2) {
		e.preventDefault();
	}

	if (Errors.length > 0) {
		e.preventDefault();
		Errors.forEach((error) => {
			document.getElementById(`${error.id}`).textContent = error.msg;
		});
	} else {
		sectionIndex < 2 ? sectionIndex++ : sectionIndex;
		// Remove not-allowed class prevBtn
		if (sectionIndex > 0) {
			prevBtn.classList.remove("not-allowed");
		}
		progressBar.style.width = `${
			progressBarWidth < 100 ? (progressBarWidth += 50) : progressBarWidth
		}%`;
		sectionSlyder.style.setProperty(
			"transform",
			`translateX(-${sectionIndex * 100}%)`
		);
	}
});

prevBtn.addEventListener("click", function (e) {
	nextBtn.textContent = "Suivant";
	e.preventDefault();
	sectionIndex > 0 ? sectionIndex-- : sectionIndex;
	if (sectionIndex <= 0) {
		prevBtn.classList.add("not-allowed");
	}
	progressBar.style.width = `${
		progressBarWidth > 0 ? (progressBarWidth -= 50) : progressBarWidth
	}%`;
	sectionSlyder.style.setProperty(
		"transform",
		`translateX(-${sectionIndex * 100}%)`
	);
});

textareaDesc.addEventListener("keyup", function () {
	textareaLen.textContent = `${this.value.length}/700`;
});

ImageINput.addEventListener("change", function () {
	let imgName = ImageINput.files[0].name.split("."),
		photoErrorSpan = document.getElementById("error_image"),
		imgExt = imgName[imgName.length - 1],
		allowedExt = ["png", "jpg", "jpeg", "svg", "ico"];

	// Clear Image Error
	photoErrorSpan.textContent = "";
	imageINputErrors = [];

	const reader = new FileReader();
	reader.addEventListener("load", () => {
		if (!allowedExt.includes(imgExt)) {
			photoErrorSpan.textContent = "Fichier non supporté !";
			imageINputErrors.push({
				id: "error_image",
				msg: "Fichier non supporté !",
			});
		} else {
			UploadFileContainer.style.backgroundImage = `url(${reader.result})`;
		}
	});
	reader.readAsDataURL(this.files[0]);
	reader.onerror = () => {
		imageINputErrors.push({
			id: "error_image",
			msg: "Une erreur s'est produite lors du téléchargement de cette image",
		});
	};
});

videosInput.addEventListener("change", function () {
	let allowedExt = ["video/mp4", "video/webm", "video/ogg"],
		NewFiles = [...this.files];

	// Clear HTML elements
	videosContainer.innerHTML = "";
	videoErrorSpan.textContent = "";

	NewFiles.forEach((file) => {
		if (allowedExt.includes(file.type)) {
			Files.push(file);
		} else {
			videoErrorSpan.textContent = "seules les vidéos seront téléchargées !";
		}
	});

	// Create Each Of Video Element And Upload It
	Files.forEach((file, i) => {
		videosContainer.innerHTML += `
			<div class="video" file-title="${file.name}" id="${i}">
					<div class="video-progress" id="video_prog_${i}"></div>
					<i class="fa fa-video"></i>
					<div class="title">${file.name}</div>
					<i class="fa fa-check check-icon"></i>
			</div>
		`;
		uploadVideo(file, i);
	});
});

/* =========================== validation functions =========================== */
function validateSectionOne() {
	let nomForamtionInp = document.getElementById("nom"),
		prixForamtionInp = document.getElementById("prix"),
		niveauForamtionInp = document.getElementById("niveau"),
		categorieForamtionInp = document.getElementById("categorie"),
		Errors = [];

	if (
		nomForamtionInp.value == "" ||
		nomForamtionInp.value.length < 3 ||
		nomForamtionInp.value == null
	) {
		Errors.push({
			id: "error_nom",
			msg: "Le nom de formation doit comporter au moins 3 caractères",
		});
	}
	if (nomForamtionInp.value.length > 100) {
		Errors.push({
			id: "error_nom",
			msg: "Le nom doit comporter au maximum 100 caractères",
		});
	}
	if (
		prixForamtionInp.value == "" ||
		prixForamtionInp.value < 5 ||
		prixForamtionInp.value == null
	) {
		Errors.push({
			id: "error_prix",
			msg: "Le prix devrait être supérieur à 5$",
		});
	}
	if (isNaN(prixForamtionInp.value)) {
		Errors.push({
			id: "error_prix",
			msg: "Le prix doit être un nombre",
		});
	}
	if (prixForamtionInp.value > 10000) {
		Errors.push({
			id: "error_prix",
			msg: "Le prix devrait être inférieur à 10000$",
		});
	}
	if (niveauForamtionInp.value == "aucun" || niveauForamtionInp.value == null) {
		Errors.push({ id: "error_niveau", msg: "choisir le niveau de formation" });
	}
	if (
		categorieForamtionInp.value == "aucun" ||
		categorieForamtionInp.value == null
	) {
		Errors.push({
			id: "error_categorie",
			msg: "choisir la categorie de formation",
		});
	}

	return Errors;
}
function validateSectionTwo() {
	let textareaDesc = document.getElementById("description"),
		Errors = [];

	if (textareaDesc.value.length < 150 || textareaDesc.value == null) {
		Errors.push({
			id: "error_description",
			msg: "La description de formation doit avoir au moins 150 caractères",
		});
	}

	if (textareaDesc.value.length > 700) {
		Errors.push({
			id: "error_description",
			msg: "La description de formation doit comporter au maximum 700 caractères",
		});
	}

	return Errors;
}
/* =========================== pCloud Script =========================== */
const pcloudSdk = window.pCloudSdk;
const locationid = 1;

// Create `client` using an oAuth token:
const client = pcloudSdk.createClient(
	"RMiu7ZMHkx8X1cEMzZM8uWc7ZJVsOoA1ivS8mjThYfGA97ytfhmh7"
);
let folderName = "Yasser",
	theFolderId = 15175160528; // Default Folder Id

// New Folder For The User
client.createfolder(folderName, 15171390512)
	.then((result) => {
		theFolderId = result.folderid;// setting id of the new folder
	})
	.catch((err) => {
		client.listfolder(15171390512) 
		.then((result)=>{
			let subFolders=[...result.contents];
			subFolders.forEach((folder)=>{
				if(folder.name==folderName){
					theFolderId=folder.folderid;// setting id of the folder if already exists
				}
			})
		}).catch((error)=>{
			theFolderId=15175160528;
		});
	});

// Upload Video Function
function uploadVideo(file) {
	let progsDiv = document.querySelectorAll(`.video-progress`),
		checkIcons = document.querySelectorAll(`.check-icon`);

	client.upload(file, theFolderId, {
		onProgress: function (e) {
			let per = (e.loaded * 100) / e.total;
			progsDiv.forEach((el) => {
				el.style.width = `${per}%`;
			});
			nextBtn.classList.add("not-allowed");
			canISubmit = false;
		},
		onFinish: function (fileMetadata) {
			// video info in variables
			let videoName = fileMetadata.metadata.name.replace(/\s/g, "%20"),
				videoPath = `https://filedn.com/l1sJvviJhEwJbwl4JNQhunX/${folderName}/${videoName}`,
				duration = fileMetadata.metadata.duration,
				fileId = fileMetadata.metadata.fileid,
				fileAlreadyExist = false;

			// styling
			checkIcons.forEach((icon) => {
				icon.style.color = "#47B5FF";
			});
			nextBtn.classList.remove("not-allowed");

			// preparing data for back-end
			canISubmit = true;
			videoJsObjects.forEach((obj) => {
				if (obj.file_id == fileId) {
					fileAlreadyExist = true;
				}
			});
			if (!fileAlreadyExist) {
				videoJsObjects.push({
					name: videoName,
					path: videoPath,
					duree: duration,
					file_id: fileId,
				});
			}
			videosHiddenInp.value = JSON.stringify(videoJsObjects);
		},
	})
	.catch(function (error) {
		videoErrorSpan.textContent = "Erreur De Telechargement !";
	});
}
