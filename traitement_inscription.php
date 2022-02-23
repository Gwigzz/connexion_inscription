<?php
// Demarre la session si nécessaire
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Unset last session
if (isset($_SESSION['alert'])) {
    unset($_SESSION['alert']);
}

$error = 0;
$alert = NULL;

// Traitement Form
if (
    isset($_POST['user_name']) && !empty($_POST['user_name'])
    && isset($_POST['user_email']) && !empty($_POST['user_email'])
    && isset($_POST['password']) && !empty($_POST['password'])
    && isset($_POST['repeat_password']) && !empty($_POST['repeat_password'])
) {

    $user_name = htmlspecialchars($_POST['user_name']);                 # name
    $user_email = htmlspecialchars($_POST['user_email']);               # email
    $password = htmlspecialchars($_POST['password']);                   # psw
    $repeat_password = htmlspecialchars($_POST['repeat_password']);     # repeat psw

    // Name
    if (strlen($user_name) < 3 || strlen($user_name) > 10) {
        $alert[] = 'Votre pseudo doit comporter entre 3 et 10 caractères maximum.';
        $error = 1;
    }

    /*          !!!         !!!         !!!
    * Ajouter des regex pour le champ "user_name"..... 
    * Pour filtrer les caractères bizares
    */

    // Email
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $alert[] = 'L\'email doit être valide.';
        $error = 1;
    }

    // Password
    if ($password !== $repeat_password) {
        $alert[] = 'Les mots de passe doivent être identique.';
        $error = 1;
    }

    // Hash psw
    $options_hash = ['cost' => 12];
    $password = password_hash($password, PASSWORD_BCRYPT, $options_hash);

    require_once 'db/db.php'; # DB

    // Check if email exist or not
    $req = $db->prepare('SELECT * FROM user WHERE user_email = :user_email');
    $req->bindValue(':user_email', $user_email, PDO::PARAM_STR);
    $req->execute();

    if ($req->rowCount() > 0) {
        $alert[] = 'Cette adresse email est déjà enregistrée.';
        $error = 1;
    }


    if ($error === 1) {
        // Save message errors in session
        $_SESSION['alert'] = $alert;

        // Redirect
        header('Location: register.php');
        exit();
    }

    // Insert datas
    $request_datas = $db->prepare(
        'INSERT INTO user(user_name, user_email, user_password) VALUES(:firstname, :email, :password)'
    );
    $request_datas->bindValue(':firstname', $user_name, PDO::PARAM_STR);
    $request_datas->bindValue(':email', $user_email, PDO::PARAM_STR);
    $request_datas->bindValue(':password', $password, PDO::PARAM_STR);

    // Execute request register datas
    if (!$request_datas->execute()) {
        $alert[] = 'Une erreur est survenue pendant l\'enregistrement.';
    }

    /* Success register */
    $alert[] = '<span class="success">Vos informatios ont bien étaient enregistrées. Vous pouvez vous connecter.</span>';
    $_SESSION['alert'] = $alert;

    // Redirect to "connexion"
    header('Location: index.php');
    exit();
} else {
    // Invalide champs
    $_SESSION['alert'] = ['Champs Imcomplets/Invalides.'];

    header('Location: register.php');
    exit();
}
