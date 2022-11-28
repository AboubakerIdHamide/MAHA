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

// ==========================================
var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    spaceBetween: 25,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints:{
        0: {
            slidesPerView: 1,
        },
        520: {
            slidesPerView: 2,
        },
        950: {
            slidesPerView: 3,
        },
    },
    autoplay: {
        delay: 4000,
    },
  });
<<<<<<< HEAD

=======
// strat function add card coures
function add_courses(name_formation, img_formation, name_formateur, img_formateur, prix_formation, categorie, mass_horaire, description, likes, members){
  let $container_courses = $('.poplularCourses .courses')[0];
  $container_courses.innerHTML += `
        <!-- start card -->
        <div class="card swiper-slide card_coures">
            <!-- img formation -->
            <div class="img">
                <img src="${img_formation}" alt="photo">
                <div class="duree">
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    <div class="time">${mass_horaire}</div>
                </div>
            </div>
            <!-- informations formation -->
            <div class="info_formation">
                <div class="categorie">${categorie}</div>
                <div class="prix">${prix_formation}</div>
            </div>
            <!-- name formation -->
            <h1>${name_formation}</h1>
            <!-- description -->
            <div class="description">
                <p>${description}</p>
            </div>
            <div class="footer">
                <!-- infotrmation formateur -->
                <div class="formateur">
                    <div class="img_formateur">
                        <img src="${img_formateur}" alt="photo">
                    </div>
                    <h2>${name_formateur}</h2>
                </div>
                <!-- informations -->
                <div class="info">
                    <div class="etd">${likes}</div>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <div class="likes">${members}</div>
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <!-- end card -->
    `;
}
add_courses('Name formation', 'images/istockphoto-836667296-1024x1024.jpg', 'Nom', 'images/avatar-05.png', 112, 'Developement', '10:00', 'desciption', 20, 50);
// strat function add card coures
>>>>>>> dd0c7cebe874638ddfed7dbcae2a8836d9f45125
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

