<?php
session_start();

if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
    // On détruit la variable et la session
    unset($_SESSION['auth']);
    session_destroy();
}

// Retourne sur la page index
header('Location: index.php');
exit();
