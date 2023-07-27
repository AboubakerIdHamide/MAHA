<!-- Header -->
<header>
    <span id="overlay"></span>
    <div class="logo" data-user-name="<?= $_SESSION['user']->prenom ?>">
        <img src="<?= $_SESSION['user']->img ?>" alt="avatar">
    </div>
    <nav>
        <div class="menu-i">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="hide-menu">
            <li id="notifications" class="justify-content-center">
                <a href="<?= URLROOT . '/etudiant/notifications' ?>">
                    <i style="font-size:25px;" class="fa-solid fa-bell position-relative">
                        <?php if ($data["nbrNotifications"]->totalNew != 0) : ?>
                            <span style="font-size: 9px;" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger nbr-notifications">
                                <?= $data["nbrNotifications"]->totalNew ?>
                            </span>
                        <?php endif ?>
                    </i>
                </a>
            </li>
            <li id="dashboard"><a href="<?= URLROOT . '/etudiant/dashboard' ?>"><i class="fa-solid fa-graduation-cap"></i><span>Formations</span></a></li>
            <li id="paiment"><a href="<?= URLROOT . '/etudiant/watchedVideos' ?>"><i class="fa-solid fa-check"></i><span>regardé</span></a></li>
            <li id="paiment"><a href="<?= URLROOT . '/etudiant/bookmarkedVideos' ?>"><i class="far fas fa-bookmark"></i><span>Signets</span></a></li>
            <li id="statistics"><a href="<?= URLROOT . '/etudiant/updateInfos' ?>"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
            <li id="disconnect"><a href="<?= URLROOT . '/user/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
        </ul>
    </nav>
</header>
<!-- end Header -->