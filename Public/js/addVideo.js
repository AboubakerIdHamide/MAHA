/* =========================== Global Variables =========================== */
let sectionIndex = 0,
	nextBtn = document.getElementById("next"),
	prevBtn = document.getElementById("prev"),
	progressBar = document.getElementById("prog_bar"),
	videosInput = document.getElementById("videos"),
	videosContainer = document.getElementById("uplodedVideosContainer"),
	videosHiddenInp = document.getElementById("jsonVideos"),
	videoErrorSpan = document.getElementById("error_videos"),
	myForm=document.getElementById("form");
	videoINputErrors = [{id:"error_videos", msg:"Telecharger Un Video Au Minumum !"}],
	videoJsObjects = [],
	Files = [];

/* =========================== Event Listeners =========================== */
nextBtn.addEventListener("click", function (e) {
	e.preventDefault();
	if(videoINputErrors.length>0){
		videoINputErrors.forEach(error => {
			document.getElementById(error.id).innerText=error.msg;
		});
	}else{
		document.body.classList.add("not-allowed")
		myForm.style.pointerEvents='none';
		Files.forEach((file)=>{
			uploadVideo(file);
		})
	}
});

prevBtn.addEventListener("click", (e)=>{
	e.preventDefault();
	Files=[];
	createVideosElements();
	videoINputErrors.push({id:"error_videos", msg:"Telecharger Un Video Au Minumum !"});
});

videosInput.addEventListener("change", function () {
	let allowedExt = ["video/mp4", "video/webm", "video/ogg"],
		NewFiles = [...this.files];

	// Clear HTML elements
	videoErrorSpan.textContent = "";
	videoINputErrors=[];

	NewFiles.forEach((file) => {
		if (allowedExt.includes(file.type)) {
			Files.push(file);
		} else {
			videoErrorSpan.textContent = "seules les vidéos seront téléchargées !";
			videoINputErrors.push({id:"error_videos", msg:"seules les vidéos seront téléchargées !"})
		}
	});

	// Create Each Of Video Element And Upload It
	createVideosElements();
});
/*============================ Functions =============================== */
function removeFile(i) {
	Files=Files.filter((f, index)=>{return index!=i});
	createVideosElements();
}

function createVideosElements(){
	videosContainer.innerHTML = "";
	Files.forEach((file, i) => {
		videosContainer.innerHTML += `
			<div class="video" file-title="${file.name}">
					<div class="video-progress" id="video_prog_${i}"></div>
					<i class="fa fa-video"></i>
					<div class="title">${file.name}</div>
					<i class="fa fa-remove check-icon" onclick="removeFile(${i})"></i>
			</div>
		`;
	});
}
/* =========================== pCloud Script =========================== */
const pcloudSdk = window.pCloudSdk;
const locationid = 1;

// Create `client` using an oAuth token:
const client = pcloudSdk.createClient(
	"RMiu7ZMHkx8X1cEMzZM8uWc7ZJVsOoA1ivS8mjThYfGA97ytfhmh7"
);

// Upload Video Function
function uploadVideo(file) {
	let progsDiv = document.querySelectorAll(`.video-progress`),
		checkIcons = document.querySelectorAll(`.check-icon`);

	// change the icon to checked
	checkIcons.forEach((icon)=>{
		icon.classList.replace("fa-remove", "fa-check");
		icon.classList.add("active");
	})

	// Upload The Files
	client.upload(file, theFolderId, {
		onProgress: function (e) {
			let per = (e.loaded * 100) / e.total;
			progsDiv.forEach((el) => {
				el.style.width = `${per}%`;
			});
			progressBar.style.width = `${per}%`;
		},
		onFinish: function (fileMetadata) {
			// video info in variables
			let videoName = fileMetadata.metadata.name,
				duration = fileMetadata.metadata.duration,
				fileId = fileMetadata.metadata.fileid,
				fileAlreadyExist = false;

			// preparing data for back-end
			videoJsObjects.forEach((obj) => {
				if (obj.file_id == fileId) {
					fileAlreadyExist = true;
				}
			});
			if (!fileAlreadyExist) {
				videoJsObjects.push({
					name: videoName,
					duree: duration,
					file_id: fileId,
				});
			}
			videosHiddenInp.value = JSON.stringify(videoJsObjects);
			myForm.submit();
		},
	})
	.catch(function (error) {
		videoErrorSpan.textContent = "Erreur De Telechargement !";
	});
}
