<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= URLROOT.'/public' ?>/images/favicon.ico">
    <title><?php echo SITENAME; ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Styles --> 
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/main.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/pageFormations.css" />
    <!-- WOW js -->
    <link rel="stylesheet" href="<?= URLROOT ?>/public/WOW/css/animate.css">

    <!-- Slice Card -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" />
</head>

<body>
    <!-- Header -->
    <header class="wow slideInDown" data-wow-delay="1s">
        <div class="loding-bar"></div>
        <div class="container">
            <h1 class="logo"><a href="<?= URLROOT ?>"><img src="<?= $data['theme']['logo']?>"/></a></h1>
            <div class="burger-icon" id="menuBtn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul id="navBarUl" class="hide">
                <li><a href="#catalogue">Catalogue</a></li>
                <li><a href="<?php echo URLROOT . "/pageFormations/" ?>">Formations</a></li>
                <li class="menu-drop-down">
                    <span id="dropMenu">Autre <i class='fa fa-chevron-down'></i></span>
                    <ul id="droppedMenu" class="hide">
                        <?php if(!isset($_SESSION['user'])) : ?>
                            <li><a href="<?php echo URLROOT . "/users/register" ?>">S'inscrire</a></li>
                        <?php endif ?>
                        <li><a href="#popular">Les Plus Populaires</a></li>
                        <li><a href="#equipe">Notre équipe </a></li>
                        <li><a href="#contact">Contactez-Nous</a></li>
                    </ul>
                </li>
                <li class="search-bar">
                    <i class="fa fa-search" id="searchIcon"></i>
                    <form action="" class="hide" id="seacrhForm"><input type="text"></form>
                </li>
                <?php if(!isset($_SESSION['user'])) : ?>
                    <li class="sign-in"><a href="<?php echo URLROOT . "/users/login" ?>">Se Connecter</a></li>
                <?php endif ?>
                <?php if(isset($_SESSION['id_formateur'])) : ?>
                    <li class="sign-in"><a href="<?php echo URLROOT . "/formateurs/dashboard" ?>">Dashboard</a></li>
                <?php endif ?>
                <?php if(isset($_SESSION['id_etudiant'])) : ?>
                    <li class="sign-in"><a href="<?php echo URLROOT . "/etudiants/dashboard" ?>">Mes Cours</a></li>
                <?php endif ?>
            </ul>
        </div>
    </header>
    <!-- Fin Header -->
