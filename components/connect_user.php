<?php

require_once("../components/connect_server.php");
require_once('../objects/Instants.php');
include ("../components/data_requets.php");

// On récupère la requête
$user = $_SESSION['user'];
$intitule = $_SESSIon['intitule'];

if(empty($user)) {
    $e = new Exception("Profil utilisateur introuvable");
    $_SESSION['erreur'] = $e;
    header("Location: ../view/erreur.php");
    exit;

} else {
    // On récupère l'accès à la base de données
    global $bdd;

    $sql = "SELECT * FROM types WHERE Intitule = :Intitule";
    $data = ["Intitule" => "Connexion"];
    $result = get_request($bdd, $sql, $data);
    $type = $result['Intitule'];
    $type_id = $result['Id'];

    try {
        // On génère l'instant actuel (date et heure actuelles)
        $instants = Instants::currentInstants();
        // J'enregistre mon instant dans la base de données
        $sql = "INSERT INTO Instants (Jour, Heure) VALUES (:jour, :heure)";
        $query = $bdd->prepare($sql);
        $query->execute($instants->exportToSQL());


        // On récupère l'id de mon instant 
        $sql = "SELECT * FROM instants WHERE Jour = :jour AND Heure = :heure";
        $query = $bdd->prepare($sql);
        $query->execute($instants->exportToSQL());

        // On récupère le résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) 
            throw new Exception("Erreur de récupération du type d'action");
        else $instant_id = $result['Id'];

    } catch(InvalideInstantExceptions $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view.erreur.php");
        exit;
    } catch(PDOException $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view.erreur.php");
        exit;
    }

    try {
        // On prépare la requête d'ajout à la base de données
        $sql = "INSERT INTO actions (Intitule, Id_Utilisateurs, Id_Types, Id_Instants) VALUES (:intitule,   :user_id, :type_id, :instant_id)";
        $query = $bdd->prepare($sql);
        // On vérifie que l'intitulé de l'action a bien été récupéré
        if(empty($intitule)) 
            $intitule = "Connexion de ".$user["identifiant"];
        // On envoie la requête au serveur
        $query->execute([
            "intitule" => $intitule,
            "user_id" => $user['cle'],
            "type_id" => $type_id,
            "instant_id" => $instant_id
        ]);
        
    } catch(PDOException $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: erreur.php");
        exit;
    }
}