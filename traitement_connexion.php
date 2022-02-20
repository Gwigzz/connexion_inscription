<?php
session_start();

// Unset last session
if (isset($_SESSION['alert'])) {
    unset($_SESSION['alert']);
}

$error = 0;
$alert = NULL;

if (
    isset($_POST['user_email']) && !empty($_POST['user_email'])
    && isset($_POST['password']) && !empty($_POST['password'])
) {

    $user_email = htmlspecialchars($_POST['user_email']);       # Log Email
    $user_password = htmlspecialchars($_POST['password']);      # Log Password

    // Verify Email
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $alert[] = 'Adresse email invalide.';
        $error = 1;
    }

    require_once './db/db.php'; # DB

    // Check if email existe or not
    $req = $db->prepare('SELECT * FROM user WHERE user_email = :log_email');
    $req->bindValue(':log_email', $user_email, PDO::PARAM_STR);
    $req->execute();

    $fetch = $req->fetch();
    $row = $req->rowCount();

    // if email exist in db
    if ($row === 1) {

        // Check password
        if (password_verify($user_password, $fetch['user_password'])) {

            /* Connecte user */

            // Creat a session with personal informations
            $_SESSION['auth'] = [
                'id' => $fetch['id'],
                'name' => $fetch['user_name'],
                'email' => $fetch['user_email']
            ];

            $_SESSION['success'] = '<p class="success">Vous êtes connectée.</p>';

            // Redirect to "profil"
            header('Location: profil.php?auth=' . $fetch['id'] . '');
            exit();
            #
        } else {
            $alert[] = 'Informations invalide.';
            $error = 1;
        }

    } else {
        $alert[] = 'Email non Enregistrée/Trouvé.';
        $error = 1;
    }

    // Error(s)
    if (1 === $error) {

        $_SESSION['alert'] = $alert;

        // Redirect login page
        header('Location: index.php');
        exit();
    }
}else{
    $_SESSION['alert'] = ['Champs Imcomplets/Invalides.'];

    header('Location: index.php');
    exit();
}