<?php
session_start();

if (isset($_SESSION['auth'])) {
    header('Location: profil.php?info=already_co');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>_Connexion</title>
    <link rel="stylesheet" type="text/css" href="./assets/css.css" />
</head>

<body>

    <header>
        <h1>Se connecter</h1>
    </header>

    <main>

        <div class="box-main">

            <!-- Alert -->
            <div class="alert error">
                <!-- error -->
                <?php if (isset($_SESSION['alert'])) : ?>
                    <ul>
                        <?php foreach ($_SESSION['alert'] as $msg) : ?>
                            <li><?= $msg ?></li>
                        <?php endforeach ?>
                    </ul>
                    <?php unset($_SESSION['alert']) ?>
                    <!-- <php header('Refresh: 3') ?> -->
                <?php endif ?>
            </div>

            <div>
                <form action="./traitement_connexion.php" method="POST">
                    <div>
                        <label for="user_email">Email*</label>
                        <input type="text" name="user_email" id="user_email" placeholder="Adresse Email" />
                    </div>
                    <div>
                        <label for="password">Mot de passe*</label>
                        <input type="text" name="password" id="password" placeholder="Mot de passe" />
                    </div>
                    <div>
                        <button type="submit">Connexion</button>
                    </div>
                    <a style="float:right;" href="register.php">Inscription</a>
                </form>
            </div>

        </div>

    </main>

</body>

</html>