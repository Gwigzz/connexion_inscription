<?php
// Demarre la session si nécessaire
// session_status() === PHP_SESSION_NONE ?? session_start();
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if (isset($_SESSION['auth'])) {
    header('Location: profil.php?info=already_co');
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="./assets/css.css" />
</head>

<body>
    <header>
        <h1>S'enregistrer</h1>
    </header>

    <main>

        <div class="box-main">
            <!-- Alert -->
            <div class="alert error">
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
                <form action="./traitement_inscription.php" method="POST">
                    <div>
                        <label for="user_name">Nom*</label>
                        <input type="text" name="user_name" name="user_name" placeholder="Votre nom" />
                    </div>
                    <div>
                        <label for="user_email">Email*</label>
                        <input type="text" name="user_email" id="user_email" placeholder="Adresse Email" />
                    </div>
                    <div>
                        <label for="password">Mot de passe*</label>
                        <input type="text" name="password" id="password" placeholder="Mot de passe" />
                    </div>
                    <div>
                        <label for="password">Répéter mot de passe*</label>
                        <input type="text" name="repeat_password" placeholder="Répéter mot de passe" />
                    </div>
                    <div>
                        <button type="submit">S'enregistrer</button>
                    </div>
                    <a style="float:right;" href="index.php">Se connecter</a>
                </form>
            </div>
        </div>
    </main>

</body>

</html>