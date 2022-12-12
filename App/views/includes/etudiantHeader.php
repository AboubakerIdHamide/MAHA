<!-- Header -->
<header>
    <span id="overlay"></span>
    <div class="logo" data-user-name="<?=$_SESSION['user']['prenom']?>">
        <img src="<?= $_SESSION['user']['avatar'] ?>" alt="avatar">
    </div>
    <nav>
        <div class="menu-i">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="hide-menu">
            <li id="addnews"><a href="<?= URLROOT.'/etudiant/dashboard' ?>"><i class="fa-solid fa-graduation-cap"></i><span>Formations</span></a></li>
            <li id="paiment"><a href="<?= URLROOT . '/etudiant/watchedVideos' ?>"><i class="fa-solid fa-check"></i><span>regardé</span></a></li>
            <li id="paiment"><a href="<?= URLROOT . '/etudiant/bockMarckedVideos' ?>"><i class="far fas fa-bookmark"></i><span>Signets</span></a></li>
            <li id="statistics"><a href="<?= URLROOT . '/etudiant/editProfile' ?>"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
            <li id="disconnect"><a href="<?= URLROOT . '/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
        </ul>
    </nav>
</header>
<!-- end Header -->
