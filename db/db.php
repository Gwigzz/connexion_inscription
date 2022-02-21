<?php

try {
    // DB NAME
    define('DB_NAME', 'exercice_connexion_inscription');
    // DB LOG
    define('DB_LOG', 'root');

    $db = new PDO(
        'mysql:host=localhost;dbname=' . DB_NAME . ';charset=utf8',
        DB_LOG,
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
