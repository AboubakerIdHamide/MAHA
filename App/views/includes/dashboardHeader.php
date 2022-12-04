<!-- Header -->
<header>
    <span id="overlay"></span>
    <div class="logo" user-name="<?=$_SESSION['user']['prenom']?>">
        <img src="<?= $_SESSION['user']['avatar'] ?>" alt="avatar">
    </div>
    <nav>
        <div class="menu-i">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="hide-menu">
            <li id="addnews"><a href="<?= URLROOT.'/formateur/index' ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
            <li id="paiment"><a href="#"><i class="far fa-credit-card"></i><span>Paiement</span></a></li>
            <li id="statistics"><a href="#"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
            <li id="disconnect"><a href="<?= URLROOT . '/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
        </ul>
    </nav>
</header>
<!-- end Header -->
