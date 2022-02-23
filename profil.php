<?php
// Demarre la session si nécessaire
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['auth'])) {
    header('Location: index.php?info=no_auth');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?= $_SESSION['auth']['name'] ?></title>
    <link rel="stylesheet" type="text/css" href="./assets/css.css" />
</head>

<body>

    <header>
        <h1>Bienvenue sur votre profil <span class="name-auth"><?= $_SESSION['auth']['name'] ?></span></h1>
        <a href="./deconnexion.php">Déconnexion</a>
    </header>

    <main>
        <div class="box-main">
            <!-- alert -->
            <div class="alert">
                <?php if (isset($_SESSION['success'])) : ?>
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']) ?>
                    <!-- <php header('Refresh: 3') ?> -->
                <?php endif ?>
            </div>

            <div>
                <h2>Vos Informations : </h2>
                <ul>
                    <li>Nom : <b><?= $_SESSION['auth']['name'] ?></b></li>
                    <li>Email : <b><?= $_SESSION['auth']['email'] ?></b></li>
                </ul>
            </div>
        </div>
    </main>


</body>

</html>