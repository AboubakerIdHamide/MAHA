/*========================================== Header Scripts =========================================*/
// Menu Button
let menuBtn=document.getElementById("menuBtn"),
    navBar=document.getElementById("navBarUl");

menuBtn.addEventListener('click', ()=>{
    let PhoneMedia = window.matchMedia("(max-width: 768px)");
    if (PhoneMedia.matches) {
        menuBtn.classList.toggle('active');
        navBar.classList.toggle('hide');
    }
})

function hideNavBar(){
    let notPhoneMedia = window.matchMedia("(min-width: 768px)");
    if (notPhoneMedia.matches) {
        if(navBar.classList.contains('hide')){
            navBar.classList.remove('hide');
            if(menuBtn.classList.contains('active')){
                menuBtn.classList.remove('active');
            }
        }
    }else{
        if(!navBar.classList.contains('hide')){
            navBar.classList.add('hide');
            if(menuBtn.classList.contains('active')){
                menuBtn.classList.remove('active');
            }
        }
    }
}


// Loding Bar
document.onreadystatechange=()=>{
    let lodBar=document.querySelector(".loding-bar");
    if(document.readyState=="interactive"){
        lodBar.style.setProperty("width", `50%`);
    }else if(document.readyState=="complete"){
        lodBar.style.setProperty("width", `100%`);
        setTimeout(()=>{lodBar.style.display="none"}, 1000);
    }
}

// Drop Menu
let dropMenuBtn=document.getElementById("dropMenu"),
    MenuDropped=document.getElementById("droppedMenu");

dropMenuBtn.addEventListener("click",()=>{
    MenuDropped.classList.toggle("hide");
})

MenuDropped.addEventListener("mouseleave",()=>{
    MenuDropped.classList.add("hide");
})

function hideDropMenu(el){
    el.classList.add("hide");
}

// Search Bar 
let searchForm=document.getElementById("seacrhForm");
    searchIcon=document.getElementById("searchIcon");

searchIcon.addEventListener("click", ()=>{
    searchForm.classList.toggle("hide");
    if(searchIcon.classList.contains("fa-search")){
        searchIcon.classList.replace("fa-search","fa-xmark");
    }else{
        searchIcon.classList.replace("fa-xmark", "fa-search");
    }
})

// Window Event
window.onresize= ()=>{hideNavBar()}
window.onload= ()=>{hideNavBar()}
window.onscroll= ()=>{hideNavBar();hideDropMenu(MenuDropped)}

// to-tp button

let $toTop = $('.to-top');

window.addEventListener('scroll', () => {
    if(window.pageYOffset > 150)
        $toTop.addClass('active');
    else
        $toTop.removeClass('active');
});

$toTop.click(function (e) {
    e.preventDefault();
    window.scrollTo(0, 0);
})

