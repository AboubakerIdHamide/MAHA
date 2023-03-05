<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Annulé</title>
	<!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    	body {
    		height: 100vh;
    		display: flex;
    		align-items: center;
    		justify-content: center;
    		padding: 3rem;
    	}
    </style>
</head>
<body>
	<div class="alert alert-danger">
		<h2>Bonjour. Je suis désolé d'apprendre que votre achat a été annulé.</h2>
		<a href="<?= URLROOT.'/pageFormations/coursDetails/'.$data['idFormation'] ?>" class="btn btn-info mt-3">Retour au Cours</a>
	</div>
</body>
</html>