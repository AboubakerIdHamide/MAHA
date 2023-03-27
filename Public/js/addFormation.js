/* =========================== Global Variables =========================== */
let sectionIndex = 0
  , sectionSlyder = document.getElementById("fieldSectionSlyder")
  , prevBtn = document.getElementById("prev")
  , nextBtn = document.getElementById("next")
  , errorSpans = document.querySelectorAll(".error")
  , progressBar = document.getElementById("prog_bar")
  , progressBarWidth = 0
  , textareaDesc = document.getElementById("description")
  , textareaLen = document.getElementById("txtLen")
  , ImageINput = document.getElementById("image")
  , UploadFileContainer = document.querySelector(".image-uploader")
  , videosInput = document.getElementById("videos")
  , videosContainer = document.getElementById("uplodedVideosContainer")
  , videosHiddenInp = document.getElementById("jsonVideos")
  , videoErrorSpan = document.getElementById("error_videos")
  , imageINputErrors = []
  , videoINputErrors = []
  , videoJsObjects = []
  , Files = []
  , canISubmit = false;

/* =========================== Event Listeners =========================== */
nextBtn.addEventListener("click", function(e) {
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
    errorSpans.forEach((errSpan)=>{
        errSpan.textContent = "";
    }
    );

    // prevent if not the last section
    if (canISubmit == false || sectionIndex != 2) {
        e.preventDefault();
    }

    if (Errors.length > 0) {
        e.preventDefault();
        Errors.forEach((error)=>{
            document.getElementById(`${error.id}`).textContent = error.msg;
        }
        );
    } else {
        sectionIndex < 2 ? sectionIndex++ : sectionIndex;
        // Remove not-allowed class prevBtn
        if (sectionIndex > 0) {
            prevBtn.classList.remove("not-allowed");
        }
        progressBar.style.width = `${progressBarWidth < 100 ? (progressBarWidth += 50) : progressBarWidth}%`;
        sectionSlyder.style.setProperty("transform", `translateX(-${sectionIndex * 100}%)`);
    }
});

prevBtn.addEventListener("click", function(e) {
    nextBtn.textContent = "Suivant";
    e.preventDefault();
    sectionIndex > 0 ? sectionIndex-- : sectionIndex;
    if (sectionIndex <= 0) {
        prevBtn.classList.add("not-allowed");
    }
    progressBar.style.width = `${progressBarWidth > 0 ? (progressBarWidth -= 50) : progressBarWidth}%`;
    sectionSlyder.style.setProperty("transform", `translateX(-${sectionIndex * 100}%)`);
});

textareaDesc.addEventListener("keyup", function() {
    textareaLen.textContent = `${this.value.length}/700`;
});

ImageINput.addEventListener("change", function() {
    let imgName = ImageINput.files[0].name.split(".")
      , photoErrorSpan = document.getElementById("error_image")
      , imgExt = imgName[imgName.length - 1]
      , allowedExt = ["png", "jpg", "jpeg", "svg", "ico"];

    // Clear Image Error
    photoErrorSpan.textContent = "";
    imageINputErrors = [];

    const reader = new FileReader();
    reader.addEventListener("load", ()=>{
        if (!allowedExt.includes(imgExt)) {
            photoErrorSpan.textContent = "Fichier non supporté !";
            imageINputErrors.push({
                id: "error_image",
                msg: "Fichier non supporté !",
            });
        } else {
            UploadFileContainer.style.backgroundImage = `url(${reader.result})`;
        }
    }
    );
    reader.readAsDataURL(this.files[0]);
    reader.onerror = ()=>{
        imageINputErrors.push({
            id: "error_image",
            msg: "Une erreur s'est produite lors du téléchargement de cette image",
        });
    }
    ;
});

videosInput.addEventListener("change", function() {
    let allowedExt = ["video/mp4", "video/webm", "video/ogg"]
      , NewFiles = [...this.files];

    // Clear HTML elements
    videosContainer.innerHTML = "";
    videoErrorSpan.textContent = "";
    videosInput.value = ""

    NewFiles.forEach((file)=>{
        if (allowedExt.includes(file.type)) {
            Files.push(file);
        } else {
            videoErrorSpan.textContent = "seules les vidéos seront téléchargées !";
        }
    }
    );

    // Create Each Of Video Element And Upload It
    Files.forEach((file,i)=>{
        if (file.size < 41943040) {
            videosContainer.innerHTML += `
				<div class="video" file-title="${file.name}" id="${i}">
						<div class="video-progress" id="video_prog_${i}"></div>
						<i class="fa fa-video"></i>
						<div class="title">${file.name}</div>
						<i class="fa fa-check check-icon"></i>
				</div>
			`;
            uploadVideos(file);
        } else {
            videoErrorSpan.textContent = "les vidéos de plus de 40 Mo ne sont pas valides";
        }
    }
    );
});

/* =========================== validation functions =========================== */
function validateSectionOne() {
    let nomForamtionInp = document.getElementById("nom")
      , prixForamtionInp = document.getElementById("prix")
      , niveauForamtionInp = document.getElementById("niveau")
      , categorieForamtionInp = document.getElementById("categorie")
      , Errors = [];

    if (nomForamtionInp.value == "" || nomForamtionInp.value.length < 5 || nomForamtionInp.value == null) {
        Errors.push({
            id: "error_nom",
            msg: "Le nom de formation doit comporter au moins 5 caractères",
        });
    }
    if (nomForamtionInp.value.length > 50) {
        Errors.push({
            id: "error_nom",
            msg: "Le nom doit comporter au maximum 50 caractères",
        });
    }
    if (prixForamtionInp.value == "" || prixForamtionInp.value < 5 || prixForamtionInp.value == null) {
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
    if (niveauForamtionInp.value == "" || niveauForamtionInp.value == null) {
        Errors.push({
            id: "error_niveau",
            msg: "choisir le niveau de formation"
        });
    }
    if (categorieForamtionInp.value == "" || categorieForamtionInp.value == null) {
        Errors.push({
            id: "error_categorie",
            msg: "choisir la categorie de formation",
        });
    }

    return Errors;
}
function validateSectionTwo() {
    let textareaDesc = document.getElementById("description")
      , Errors = [];

    if (textareaDesc.value.length < 80 || textareaDesc.value == null) {
        Errors.push({
            id: "error_description",
            msg: "La description de formation doit avoir au moins 60 caractères",
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
// ============================= video functions =============================
// XHR
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

//  Ajax
function uploadVideos(file) {
    const progsDiv = document.querySelectorAll(`.video-progress`);
    const checkIcons = document.querySelectorAll(`.check-icon`);

    const formData = new FormData();
    formData.append('file', file);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/maha/ajax/uploadVideo", true);

    xhr.upload.addEventListener('progress', ({loaded, total})=>{
        let per = (loaded * 100) / total;
        progsDiv.forEach((el)=>{
            el.style.width = `${per}%`;
        }
        );
        nextBtn.classList.add("not-allowed");
        canISubmit = false;
    }
    )

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // video info in variables
                let videoName = file.name
                  , videoPath = JSON?.parse(xhr.responseText)?.videoPath;

                // correct video name
                videoName = videoName.split(".");
                videoName.pop();
                videoName = videoName.join(" ");

                // get the duration and continue
                getVideoDuration(file).then(function(duration) {
                    // styling
                    checkIcons.forEach((icon)=>{
                        icon.style.color = "#47B5FF";
                    }
                    );
                    nextBtn.classList.remove("not-allowed");

                    // preparing data for back-end
                    canISubmit = true;

                    videoJsObjects.push({
                        name: videoName,
                        duree: duration,
                        videoPath,
                    });

                    videosHiddenInp.value = JSON.stringify(videoJsObjects);
                }).catch(function(error) {
                    console.error('Error de la video:', error);
                });

            } else {
                alert("Upload Server Error!");
                videoErrorSpan.textContent = "Erreur De Telechargement !";
            }
        }
    }

    xhr.send(formData);
}

function getVideoDuration(file) {
    return new Promise((resolve,reject)=>{
        // Create a new FileReader object
        var reader = new FileReader();

        // When the file has been loaded
        reader.addEventListener('load', function() {
            // Create a new video element
            var video = document.createElement('video');

            // When the video has loaded its metadata
            video.addEventListener('loadedmetadata', function() {
                // Get the duration of the video in seconds
                var duration = this.duration;

                // Resolve the promise with the duration
                resolve(duration);
            });

            // Set the video source to the selected file
            video.src = reader.result;

            // Load the video
            video.load();
        });

        // If there's an error reading the file, reject the promise
        reader.addEventListener('error', function() {
            reject(reader.error);
        });

        // Read the selected file as a data URL
        reader.readAsDataURL(file);
    }
    );
}
