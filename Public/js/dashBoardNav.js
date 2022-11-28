// ================== Menu ==================
let menuBtn=document.querySelector("header .menu-i"),
smallSpan=document.querySelector("header .menu-i span:nth-child(2)"),
headerUl=document.querySelector("header nav ul"),
allHeaderLi=document.querySelectorAll("header nav ul li");


window.onscroll= function(){
        var phoneMedia=window.matchMedia("(max-width: 767px)");
        if(phoneMedia.matches){
            if(!headerUl.classList.contains("hide-menu")){
                headerUl.classList.add("hide-menu");
            }
            if(smallSpan.classList.contains("fullWidth")){
                smallSpan.classList.remove("fullWidth");
            }
        }
    }

menuBtn.addEventListener('click', function(){
     headerUl.classList.toggle("hide-menu");
     smallSpan.classList.toggle("fullWidth");
})

function setHideMenuClass(){
    var notPhoneMedia=window.matchMedia("(min-width: 768px)");
    if(notPhoneMedia.matches){
        if(headerUl.classList.contains("hide-menu")){
            headerUl.classList.remove("hide-menu");
        }
        if(smallSpan.classList.contains("fullWidth")){
            smallSpan.classList.remove("fullWidth");
        }
    }
}
window.onload=()=>{
    setHideMenuClass();
}
window.onresize=()=>{
    setHideMenuClass();
}
//overlay
let overLay=document.getElementById("overlay"),
header=document.querySelector("header");
header.addEventListener("mouseenter", ()=>{overLay.classList.add("header-overlay")});
overLay.addEventListener("mouseenter", ()=>{overLay.classList.remove("header-overlay")});


// destro flash messages
function destroyMsg(){
    let msgContainer=document.querySelector(".alert-info");
    if(msgContainer){
        window.setInterval(()=>{msgContainer.remove()}, 5000);
    }
}
destroyMsg();