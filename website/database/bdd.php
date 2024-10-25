<?php

$host = "db";  // Utilisation du nom du service Docker
$dbname = "GameHub";
$user = "root";
$pass = "n&3@3-4DN_.e";
$port = 3306;  // Utilisation du port interne à Docker


try {
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;", $user, $pass);
    // Configurer PDO pour afficher les erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
