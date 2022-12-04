<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Formations</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<!-- BootStrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<!-- Custom Styles -->
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/dashBoardNav.css">
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/dashboard-formateur.css" />
	<link rel="stylesheet" href="<?= URLROOT ?>/public/css/videos.css" />
	<!-- FontFamily -->
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
	</style>
</head>

<body>
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
				<li id="addnews"><a href="<?= URLROOT.'/formateur/dashboard' ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
				<li id="paiment"><a href="#"><i class="far fa-credit-card"></i><span>Paiement</span></a></li>
				<li id="statistics"><a href="#"><i class="fas fa-user-gear"></i><span>Paramètre</span></a></li>
				<li id="disconnect"><a href="<?= URLROOT . '/users/logout' ?>"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
			</ul>
		</nav>
	</header>
	<!-- end Header -->
