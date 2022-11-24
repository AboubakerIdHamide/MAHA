<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Formations</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo URLROOT;?>/public/css/dashBoardNav.css">
	<link rel="stylesheet" href="<?php echo URLROOT;?>/public/css/dashboard-formateur.css" />
	<link rel="stylesheet" href="<?= URLROOT ?>/public/css/videos.css" />
</head>
<body>
		<!-- Header -->
	<header>
		<span id="overlay"></span>
		<div class="logo">
			<img src="<?= $_SESSION['user']['avatar'] ?>" alt="avatar">
		</div>
		<nav>
			<div class="menu-i">
				<span></span>
				<span></span>
				<span></span>
			</div>

			<ul class="hide-menu">
				<li id="search"><a href="profil-settings.html"><i class="fas fas fa-chart-bar"></i><span>Statistiques</span></a></li>
				<li id="addnews"><a href="#"><i class="fa-solid fa-graduation-cap"></i><span>Formations</span></a></li>
				<li id="paiment"><a href="#"><i class="far fa-credit-card"></i><span>Paiement</span></a></li>
				<li id="statistics"><a href="#"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
				<li id="disconnect"><a href="<?= URLROOT.'/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
			</ul>
		</nav>
	</header>
	<!-- end Header -->