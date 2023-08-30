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
                <li class="hidden_tablet"><a href="<?= URLROOT . "/formateur" ?>" class="btn_1 rounded">Dashboard</a>
                </li>
            <?php else: ?>
                <li class="hidden_tablet"><a href="<?= URLROOT . "/etudiant" ?>" class="btn_1 rounded">Mes Cours</a>
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
            <?php if (!session('user')->get()) : ?>
                <li class="hidden_desktop"><a href="<?= URLROOT . "/user/login" ?>" class="btn_1 rounded">Se Connecter</a></li>
            <?php else: ?>
                <?php if (session('user')->get()->type === 'formateur') : ?>
                    <li class="hidden_desktop"><a href="<?= URLROOT . "/formateur/dashboard" ?>" class="btn_1 rounded">Dashboard</a>
                    </li>
                <?php else: ?>
                    <li class="hidden_desktop"><a href="<?= URLROOT . "/etudiant/dashboard" ?>" class="btn_1 rounded">Mes Cours</a>
                    </li>
                <?php endif ?>
            <?php endif ?>
        </ul>
    </nav>
    <!-- Search Menu -->
    <div class="search-overlay-menu">
        <span class="search-overlay-close"><span class="closebt"><i class="fa-solid fa-xmark"></i></span></span>
        <form role="search" class="searchForm">
            <input id="input-search" name="q" type="text" placeholder="Recherche..." />
            <button type="submit"><i id="searchIcon" class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div><!-- End Search Menu -->
</header>