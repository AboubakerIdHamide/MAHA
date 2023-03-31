let imagesInputs=document.querySelectorAll("input[type='file']"),
    errors=[],
    submtBtn=document.getElementById("subBtn");

imagesInputs.forEach((imgInp)=>{
    imgInp.addEventListener("change", function() {
        let imgName = imgInp.files[0].name.split(".")
          , errorSpanId = imgInp.getAttribute("data-error-id")
          , photoErrorSpan = document.getElementById(errorSpanId)
          , imgExt = imgName[imgName.length - 1]
          , allowedExt = ["png", "jpg", "jpeg", "svg", "ico"]
          , UploadFileContainer=imgInp.parentElement;
    
        // Clear Image Error
        photoErrorSpan.textContent = "";

        const reader = new FileReader();
        reader.addEventListener("load", ()=>{
            if (!allowedExt.includes(imgExt)) {
                UploadFileContainer.style.backgroundImage = UploadFileContainer.getAttribute("data-img");
                photoErrorSpan.textContent = "Fichier non supporté !";
                errors.push({
                    id: errorSpanId,
                    msg: "Fichier non supporté !",
                });
            } else {
                errors=errors.filter((err)=>err.id!=errorSpanId);
                UploadFileContainer.style.backgroundImage = `url(${reader.result})`;
            }
        }
        );
        reader.readAsDataURL(this.files[0]);
        reader.onerror = ()=>{
            errors.push({
                id: errorSpanId,
                msg: "Une erreur s'est produite lors du téléchargement de cette image",
            });
        }
        ;
    })
})

submtBtn.addEventListener("click", (e)=>{
    if(errors.length > 0){
        e.preventDefault();
        errors.forEach((err)=>{
            document.getElementById(err.id).innerText=err.msg
        })
    }
})