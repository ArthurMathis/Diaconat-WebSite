<?php
/// Adresse du serveur MySQL
$host = "localhost:3306";
///  Nom de la base de données
$dbname = "diaconat_database";
/// Nom d'utilisateur MySQL
$username = "root";
/// Mot de passe MySQL
$password = "";

try {
    // Connexion à la base de données MySQL en utilisant PDO
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuration de PDO pour générer des exceptions en cas d'erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Notification de connexion réussie
    $message = "Connexion à " . $dbname . " réussie !";
    echo "<script> console.log(\"".$message."\"); </script>";

// On récupère les ventuelles erreurs de connexion
} catch (PDOException $e) {
    // On prépare la redirection de l'utilisateur
    session_start();
    $_SESSION['erreur'] = $e;
    // On redirige la page
    header("Location: ../view/erreur.php");
    exit;
}