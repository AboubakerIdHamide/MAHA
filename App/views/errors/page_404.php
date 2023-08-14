<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Maha a modern educational site" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title>Page non trouvée | <?= SITENAME ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- BASE CSS -->
    <link href="<?= CSSROOT ?>/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/common.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/errorPages/404.css" rel="stylesheet" />
    <link href="<?= CSSROOT ?>/vendors.css" rel="stylesheet" />
</head>
<body>
    <div id="page" class="theia-exception">
        <header class="header menu_2">
            <div id="preloader">
                <div data-loader="circle-side"></div>
            </div><!-- /Preload -->
            <div id="logo">
                <a href="<?= URLROOT ?>"><img class="logo" src="<?= LOGO ?>" width="149" height="42" alt="logo Maha"></a>
            </div>
            <ul id="top_menu">
                <li><a href="javascript:void(0)" class="search-overlay-menu-btn">Search</a></li>
                <?php if (!session('user')->get()) : ?>
                    <li class="hidden_tablet"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se Connecter</a></li>
                <?php else: ?>
                    <?php if (session('user')->get()->type === 'formateur') : ?>
                        <li class="hidden_tablet"><a href="<?= URLROOT . "/formateur/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiant/dashboard" ?>" class="btn_1 rounded">Mes Cours</a>
                        </li>
                    <?php endif ?>
                <?php endif ?>
            </ul>
            <!-- /top_menu -->
            <a href="#menu" class="btn_mobile">
                <div class="hamburger hamburger--spin" id="hamburger">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <nav id="menu" class="main-menu">
                <ul>
                    <li><span><a href="<?= URLROOT ?>">Accueil</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/courses/search">Formations</a></span></li>
                    <li><span><a href="<?= URLROOT ?>/#contact-us">Contactez-nous</a></span></li>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li><span><a href="<?= URLROOT ?>/user/register">S'inscrire</a></span></li>
                    <?php endif ?>
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/user/login" ?>">Se Connecter</a></li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_formateur'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/formateur/dashboard" ?>">Dashboard</a>
                        </li>
                    <?php endif ?>
                    <?php if (isset($_SESSION['id_etudiant'])) : ?>
                        <li class="d-lg-none"><a href="<?= URLROOT . "/etudiant/dashboard" ?>">Mes Cours</a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
            <!-- Search Menu -->
            <div class="search-overlay-menu">
                <span class="search-overlay-close"><span class="closebt"><i class="fa-solid fa-xmark"></i></span></span>
                <form role="search" class="searchForm" method="GET" action="<?= URLROOT ?>/courses/search">
                    <input id="input-search" name="q" type="text" placeholder="Recherche..." />
                    <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div><!-- End Search Menu -->
        </header>
        <!-- /header -->
		<main>
			<div id="error_page">
				<div class="container">
					<div class="row justify-content-center text-center">
						<div class="col-xl-8 col-lg-9">
							<h2>404 <i class="fa-solid fa-triangle-exclamation"></i></h2>
							<p class="error-message">Nous sommes désolés, mais la page que vous recherchez n'existe pas.</p>
							<form class="searchForm" method="GET" action="<?= URLROOT ?>/courses/search" role="search">
								<div class="search_bar_error">
									<input name="q" type="text" class="form-control" placeholder="Que cherchez-vous ?">
									<input type="submit" value="Rechercher">
								</div>
							</form>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /error_page -->
		</main>
		<!--/main-->
	    <footer>
	        <div class="container p-4">
	            <div class="row justify-content-between">
	                <div class="col-lg-4 col-md-12">
	                    <p><img src="<?= LOGO ?>" width="149" height="42" alt="maha logo"></p>
	                    <p>
	                        MAHA Est Un Site Internet De Formation En Ligne Qui Contient Des Cours Et Des Vidéos
	                        d'apprentissage
	                        Dans Plusieur Domains Tels Que Le Web Development, E-commerce, Digital Marketing ...
	                    </p>
	                </div>
	                <div class="col-lg-4 col-md-6 ml-lg-auto">
	                    <h5>Liens utiles</h5>
	                    <ul class="links">
	                        <li><a href="<?= URLROOT ?>">Accueil</a></li>
	                        <li><a href="<?= URLROOT ?>/courses/search">Formations</a></li>
	                        <li><a href="<?= URLROOT ?>/#contact-us">Contactez-Nous</a></li>
	                    </ul>
	                </div>
	                <div class="col-lg-4 col-md-6">
	                    <h5>En contact avec nous</h5>
	                    <ul class="contacts">
	                        <li><a href="tel://0524345057"><i class="fa-solid fa-mobile"></i> (+212) 524 34 50 57</a></li>
	                        <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-envelope"></i> mahateamisgi@gmail.com</a></li>
	                        <li><a href="mailto:mahateamisgi@gmail.com"><i class="fa-solid fa-location-dot"></i> Boulevard de Mohammedia</a></li>
	                    </ul>
	                </div>
	            </div>
	            <!--/row-->
	            <hr>
	            <div class="row">
	                <div class="col">
	                    <div id="copy">© Copyright <strong><span>MAHA</span></strong>. All Rights Reserved (2023)</div>
	                </div>
	            </div>
	        </div>
	    </footer>
    <!--/footer-->
	</div>

    <!-- Scripts -->
    <script src="<?= JSROOT ?>/plugins/jquery-3.6.3.min.js"></script>
    <script src="<?= JSROOT ?>/plugins/theia-sticky-sidebar.js"></script>
    <script src="<?= JSROOT ?>/plugins/jquery.mmenu.js"></script>
    <script src="<?= JSROOT ?>/common.js"></script>
</body>
</html>