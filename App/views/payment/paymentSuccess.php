<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Congratulation</title>
	<!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    	body {
    		height: 100vh;
    		display: flex;
    		/* flex-direction: column; */
    		align-items: center;
    		justify-content: center;
    		padding: 3rem;
    	}
    </style>
</head>
<body>
	<div class="alert alert-success">
		<h2>Bonjour! Félicitations pour votre achat de la plateforme MAHA. Nous espérons que cela répondra à vos besoins et améliorera votre productivité et votre efficacité.</h2>
		<a href="<?= URLROOT.'/etudiants/dashboard' ?>" class="btn btn-info mt-3">Voire Mes Formations</a>
	</div>
</body>
</html>