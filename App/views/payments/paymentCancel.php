<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= IMAGEROOT ?>/favicon.ico" />
    <title><?= SITENAME ?> | Paiement annulé</title>
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
        <h6 class="text-center text-white">Nous sommes désolé d'apprendre que votre achat a été annulé.
        </h6>
        <div class="text-center">
            <a href="<?= URLROOT ?>/courses/<?= $slug ?>" class="btn btn-primary mt-3">Retour au Cours</a>
        </div>
    </div>
    <script src="<?= JSROOT ?>/plugins/lottie.min.js"></script>
    <script>
    const animation = bodymovin.loadAnimation({
        container: document.getElementById('animContainer'),
        renderer: 'svg',
        loop: false,
        autoplay: true,
        path: '<?= IMAGEROOT ?>/payment-failed.json' // lottie file path
    })
    </script>
</body>

</html>