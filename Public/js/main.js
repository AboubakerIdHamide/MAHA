$(".icon-box").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});

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
    inputSerch = searchForm.querySelector('input');

searchIcon.addEventListener("click", ()=>{
    searchForm.classList.toggle("hide");
    if(searchIcon.classList.contains("fa-search")){
        searchIcon.classList.replace("fa-search","fa-xmark");
    }else{
        searchIcon.classList.replace("fa-xmark", "fa-search");
    }
})

searchForm.onsubmit = (e)=>{
    let valRech = inputSerch.value;
    if(!(valRech.length < 1 && valRech.length >200)){
        window.location.href = `http://localhost/MAHA/pageFormations/rechercheFormations/${valRech}`;
    }
    e.preventDefault();
}

// Window Event
window.onresize= ()=>{hideNavBar()}
window.onload= ()=>{hideNavBar()}
window.onscroll= ()=>{hideNavBar();hideDropMenu(MenuDropped)}

// start overflow p description
let $p_decription = $('.card_coures p');
for(let i=0;i<$p_decription.length;i++){
    if($p_decription[i].textContent.length > 80){
        let text = $p_decription[i].textContent.slice(0, 80);
        $p_decription[i].textContent = `${text} ...`;
    }
}
// end overflow p description


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

