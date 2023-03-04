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
	filesUploaded = 0,
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

		Files.map((file) =>{
			uploadVideo(file)
			.then(() => {
				filesUploaded++;
				if(filesUploaded==Files.length){
					myForm.submit();
				}
			})
		});
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
	videosInput.value="";

	NewFiles.forEach((file) => {
		if (allowedExt.includes(file.type)) {
			if(file.size<41943040){
				Files.push(file);
			}else{
				videoErrorSpan.textContent = "les vidéos de plus de 40 Mo ne sont pas valides";
				videoINputErrors.push({id:"error_videos", msg:"seules les vidéos seront téléchargées !"})
			}
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

// Upload Video Function
// function uploadVideo(file) {
// 	let progsDiv = document.querySelectorAll(`.video-progress`),
// 		checkIcons = document.querySelectorAll(`.check-icon`);

// 	// change the icon to checked
// 	checkIcons.forEach((icon)=>{
// 		icon.classList.replace("fa-remove", "fa-check");
// 		icon.classList.add("active");
// 	})

// 	// Upload The Files
// 	client.upload(file, theFolderId, {
// 		onProgress: function (e) {
// 			let per = (e.loaded * 100) / e.total;
// 			progsDiv.forEach((el) => {
// 				el.style.width = `${per}%`;
// 			});
// 			progressBar.style.width = `${per}%`;
// 		},
// 		onFinish: function (fileMetadata) {
// 			// video info in variables
// 			let videoName = fileMetadata.metadata.name,
// 				duration = fileMetadata.metadata.duration,
// 				fileId = fileMetadata.metadata.fileid,
// 				fileAlreadyExist = false;

// 			// preparing data for back-end
// 			videoJsObjects.forEach((obj) => {
// 				if (obj.file_id == fileId) {
// 					fileAlreadyExist = true;
// 				}
// 			});
// 			if (!fileAlreadyExist) {
// 				videoJsObjects.push({
// 					name: videoName,
// 					duree: duration,
// 					file_id: fileId,
// 				});
// 			}
// 			videosHiddenInp.value = JSON.stringify(videoJsObjects);
// 			myForm.submit();
// 		},
// 	})
// 	.catch(function (error) {
// 		videoErrorSpan.textContent = "Erreur De Telechargement !";
// 	});
// }


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
function uploadVideo(file){
	return new Promise((resolve, reject)=>{
		const progsDiv = document.querySelectorAll(`.video-progress`);
		const checkIcons = document.querySelectorAll(`.check-icon`);
	
	
		// change the icon to checked
		checkIcons.forEach((icon)=>{
			icon.classList.replace("fa-remove", "fa-check");
			icon.classList.add("active");
		})
	
		const formData = new FormData();
		formData.append('file', file);
		const xhr = new XMLHttpRequest();
		xhr.open('POST', "http://localhost/maha/ajax/uploadVideo", true);
	
		xhr.upload.addEventListener('progress', ({ loaded, total }) => {
			let per = (loaded * 100) / total;
			progsDiv.forEach((el) => {
				el.style.width = `${per}%`;
			});
			progressBar.style.width = `${per}%`;
		})
	
	
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
				// video info in variables
				let videoName = file.name,
					videoPath=JSON?.parse(xhr.responseText)?.videoPath;
	
				// correct video name
				videoName=videoName.split(".");
				videoName.pop();
				videoName=videoName.join(" ");
	
				// get the duration and continue
				getVideoDuration(file).then(function(duration) {
					videoJsObjects.push({
						name: videoName,
						duree: duration,
						videoPath,
					});
					videosHiddenInp.value = JSON.stringify(videoJsObjects);
					resolve();
				}).catch(function(error) {
					reject(`Upload error: ${error}`);
				});
	
				} else {
					alert("Upload Server Error!");
					videoErrorSpan.textContent = "Erreur De Telechargement !";
				}
			}
		}
		xhr.send(formData);
	})
}

function getVideoDuration(file) {
	return new Promise((resolve, reject) => {
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
	});
}