<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <!-- Font Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Swiper JS  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.4/swiper-bundle.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/main.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
    </style>

</head>

<body>
    <!-- Header -->
    <header>
        <div class="loding-bar"></div>
        <div class="container">
            <h1 class="logo"><a href="<?php echo URLROOT . "/pages/index" ?>">M<span>A</span>H<span>A</span></a></h1>
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
