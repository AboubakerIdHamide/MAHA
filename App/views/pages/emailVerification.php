<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME?></title>
    <link rel="stylesheet" href="<?php echo URLROOT."/Public/css/emailVerification.css"?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="main-form-heading">
                <h1 class="logo"><a href="<?php echo URLROOT."/pages/index"?>">M<span>A</span>H<span>A</span></a></h1>
            </div>
            <p>Tu es presque! Nous avons envoyé un code de vérification à <span class="user-email"><?php echo $data[0]["email"]?></span> .</p>
            <label for="code">Entrez simplement ce code ici pour vérifier votre identité</label>
            <input type="text" id="code" placeholder="code" name="code" value="<?php echo $data[1]["code"]?>">
            <span class="error" id="error"><?php echo $data[1]["code_err"]?></span>
            <button class="submit-btn" id="sbmtBtn">Vérifier</button>
            <button class="resend-link" name="resend" value="true" id="resend">renvoyer</button>
        </form>
    </div>
    <script src="<?php echo URLROOT."/Public/js/emailVerification.js"?>"></script>
</body>

</html>
