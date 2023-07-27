<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
	<title><?= SITENAME ?> | Congratulation</title>
	<!-- Bootstrap Vapor -->
	<link href="<?= CSSROOT ?>/vapor.min.css" rel="stylesheet" />
	<style>
		body {
			height: 100vh;
			margin: 0;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #eee;
			flex-direction: column;
		}

		#animContainer {
			width: 50%;
			height: 50%;
		}
	</style>
</head>

<body>
	<div class="container bg-dark p-3 rounded">
		<div class="d-flex justify-content-center">
			<div id="animContainer"> </div>
		</div>
		<h6 class="text-center text-white">Félicitations pour votre achat de la plateforme MAHA. Nous espérons que cela
			répondra à
			vos besoins
			et améliorera votre productivité et votre efficacité.</h6>
		<div class="text-center">
			<a href="<?= URLROOT . '/etudiant/dashboard' ?>" class="btn btn-success mt-3">Mes
				Cours</a>
		</div>
	</div>
	<script src="<?= JSROOT ?>/lottie.min.js"></script>
	<script>
		var animation = bodymovin.loadAnimation({
			container: document.getElementById('animContainer'),
			renderer: 'svg',
			loop: false,
			autoplay: true,
			path: '<?= IMAGEROOT ?>/payment-successful.json' // lottie file path
		})
	</script>
</body>

</html>