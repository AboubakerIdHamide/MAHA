<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>COURS - PHP & MYSQL</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/cours-details.css">
</head>
<body>
  <!-- Header -->
    <header>
        <div class="loding-bar"></div>
        <div class="container">
            <h1 class="logo"><a href="#">M<span>A</span>H<span>A</span></a></h1>
            <div class="burger-icon" id="menuBtn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul id="navBarUl" class="hide">
                <li><a href="#landing">Accueil</a></li>
                <li><a href="#catalogue">Catalogue</a></li>
                <li class="menu-drop-down">
                  <span id="dropMenu">Autre <i class='fa fa-chevron-down'></i></span>
                  <ul id="droppedMenu" class="hide">
                    <li><a href="#">S'inscrire</a></li>
                    <li><a href="#popular">Les Plus Populaires</a></li>
                    <li><a href="#equipe">Notre équipe </a></li>
                    <li><a href="#contact">Contactez-Nous</a></li>
                    <li><a href="#">Formations</a></li>
                  </ul>
                </li>
                <li class="search-bar">
                  <i class="fa fa-search" id="searchIcon"></i>
                  <form action="" class="hide" id="seacrhForm"><input type="text"></form>
                </li>
                <li class="sign-in"><a href="#">Se Connecter</a></li>
            </ul>
        </div>
    </header>
    <!-- Fin Header -->
    <section class="media-header">
    <div class="container mt-3" >
      <div class="row">
        <div class="col-xl-3">
          <img class="img-fluid" src="./images/thumb.jpg" alt="formation image">
        </div>
        <div class="col-xl-7">
          <div class="group d-flex flex-column justify-content-center">
                <h3 class="title">Complete Intro to SQL & PostgreSQL</h3>
                <p>Formation catégorie <span>Code</span></p>
                <div class="instructor d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-2">
                    <img src="./images/membre.jpg" alt="" class="formateur-img">
                  <div class="instructor-info">
                    <h5>Brian Holt</h5>
                    <p class="specialite mb-0">Full Stack Developer</p>
                  </div>
                  </div>
                  <div class="voir-profil d-flex align-items-center gap-2">
                    <a href="#">Voir Profil</a>
                  </div>
                </div>
                <div class="mt-3 masse-h d-flex flex-row justify-content-between">
                  <p><i class="fa-solid fa-clock"></i> 7 hours, 20 minutes</p>
                  <p><i class="fa-solid fa-language"></i> Francais</p>
                </div>
          </div>
        </div>
          <div class="col-xl-2 align-self-center">
             <div class="info-plus">
                <div class="text-center mb-1 apprenants-nbr">
                  <p class="nbr">5,984</p>
                  <p>Apprenants</p>
                </div>
                <div class="fomation-niveau text-center mb-1">
                  <div class="level-indicator">
                    <!-- <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4h6v2H9z" fill="#8887FF"></path><path d="M23 4h6v2h-6z" fill="#E5E5E5"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle cx="19" cy="5" r="5" fill="#8887FF"></circle><circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle></svg> -->

                    <!-- <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#8887FF" d="M9 4h6v2H9zM23 4h6v2h-6z"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle fill="#8887FF" cx="19" cy="5" r="5"></circle><circle fill="#8887FF" cx="33" cy="5" r="5"></circle></svg> -->

                    <svg width="58" height="30" viewBox="0 0 38 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#E5E5E5" d="M9 4h6v2H9zM23 4h6v2h-6z"></path><circle cx="5" cy="5" r="5" fill="#8887FF"></circle><circle fill="#E5E5E5" cx="19" cy="5" r="5"></circle><circle fill="#E5E5E5" cx="33" cy="5" r="5"></circle></svg>
                  </div>
                  <p>Niveau Débutant</p>
                </div>
                <div class="text-center">
                  <p class="nbr">100</p>
                  <p>Likes</p>
                </div>
              </div>
          </div>
        </div>
        </div>
      </section>
      <section class="video-description">
        <div class="container">
          <div class="row">
            <div class="col">
               <!-- Apercu Head -->
            <section class="section-title mt-2" id="catalogue">
              <div class="container">
                <div>
                    <p>Aperçu</p>
                </div>
              </div>
            </section> 
            <!-- Fin Apercu Head -->
            </div>
          </div>
          <div class="row">
          <div class="col-lg-6 align-self-center">
            <div class="video-preview pt-2">
              <video src="./videos/mosh.mp4" controls></video>
            </div>
          </div>
          <div class="col-lg-6 preview-prix">
            <div class="description-formation pt-2">
              <p>SQL is a timeless skillset you'll find in nearly every modern application! Using the popular PostgreSQL database, you'll learn to set up, model, and query your data through real-world projects. You'll also understand how to model complex relationships in your data and query data from large datasets.</p>
            </div>
            <p class="date-pub">Published: October 3, 2022</p>
            <div class="pay pt-3">
              <h2 class="text-center prix">$105</h2>
              <div>
               <div id="paypal-button-container"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
          <!-- DESCRIPTION Head -->
            <section class="section-title mt-2" id="catalogue">
              <div class="container">
                <div>
                    <h2>DESCRIPTION</h2>
                    <p>À propos de cette formation</p>
                </div>
              </div>
            </section> 
            <!-- Fin DESCRIPTION Head -->
        </div>
        <div class="row">
            <div class="col">
              <p class="desc">Améliorez vos compétences en gestion de projet en compagnie du directeur de projets logiciels Matt Corroboy !

Qu'est-ce qui distingue un bon gestionnaire de projet d'un excellent gestionnaire de projet ? La réponse se résume à une bonne communication et de bons échanges avec les parties prenantes clés d'un projet. Rejoignez Matt dans ce cours où il explique comment mieux comprendre, analyser et gérer les parties prenantes pour assurer la meilleure exécution possible de votre projet.

Avec Matt, vous apprendrez à :

    Mieux aligner les parties prenantes clés d'un projet en les comprenant, elles et leurs besoins
    Analyser les parties prenantes clés d'un projet pour comprendre leurs besoins individuels
    Interagir et gérer les parties prenantes pour assurer le succès du projet

Peu importe l'ampleur de votre projet, ce cours vous aidera à optimiser les relations entre vos différentes parties prenantes clés des débuts à l'achèvement de votre projet.

Le cours de Matt s'adresse aux chefs de projets de tous niveaux, mais tous les apprenants sont les bienvenus.</p>
            </div>
          </div>
      </div>
      </section>

      <section>
        <div class="container">
          <div class="row">
            <div class="col">
              <!-- Contenu Head -->
            <section class="section-title mt-2" id="catalogue">
              <div class="container">
                <div>
                    <h2>Contenu du cours</h2>
                    <p>50 leçons</p>
                </div>
              </div>
            </section> 
            <!-- Fin Contenu Head -->
            </div>
          </div>
        </div>
      </section>
      <section class="playlist-formation">
        <div class="container">
          <div class="row mb-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre">1. Intro to Course and Python</span>
              <span class="lesson-time">2hr 12min</span>
            </div>
          </div>
        </div>
        <div class="row my-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre">2. Intro to Course and Python</span>
              <span class="lesson-time">2hr 12min</span>
            </div>
          </div>
        </div>
        <div class="row my-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre">3. Intro to Course and Python</span>
              <span class="lesson-time">2hr 12min</span>
            </div>
          </div>
        </div>
        <div class="row my-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre">4. Intro to Course and Python</span>
              <span class="lesson-time">2hr 12min</span>
            </div>
          </div>
        </div>
        <div class="row my-2">
          <div class="col">
            <div class="lesson d-flex justify-content-between">
              <span class="lesson-titre">5. Intro to Course and Python</span>
              <span class="lesson-time">2hr 12min</span>
            </div>
          </div>
        </div>
        </div>
      </section>
    
     <!-- Footer -->
  <footer class="mt-5" id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 footer-contact">
            <h1 class="logo"><a href="#">M<span>A</span>H<span>A</span></a></h1>
            <p>
              Boulevard de Mohammedia <br>
              QI Azli 40150<br>
              Maroc <br><br>
              <strong>Phone:</strong> (+212) 524 34 50 57<br>
              <strong>Email:</strong> info@maha.com<br>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container d-md-flex py-4">
      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          © Copyright <strong><span>MAHA</span></strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer>
  <!-- Fin Footer -->
  <!-- To-up Button -->
<span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
<!-- To-up Button -->
  <!-- Fin Equipe -->
  <script src="jQuery/jquery-3.6.0.min.js"></script>
  <script src="./js/cours-details.js"></script>
  <!-- Sample PayPal credentials (client-id) are included -->
  <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD&intent=capture&enable-funding=venmo" data-sdk-integration-source="integrationbuilder"></script>
  <script src="./js/paypal.js"></script>
</body>
</html>