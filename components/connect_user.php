<?php

require_once "../components/connect_server.php";
require_once "../objects/Instants.php";
require_once "data_requests.php";

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

    // On récupère le type connexion 
    $sql = "SELECT * FROM types WHERE Intitule = :Intitule";
    $result = get_request($bdd, $sql, ["Intitule" => "Connexion"], true, true);
    // On implémente
    $type = $result['Intitule'];
    $type_id = $result['Id'];

    try {
        // On génère l'instant actuel (date et heure actuelles)
        $instants = Instants::currentInstants();
        // J'enregistre mon instant dans la base de données
        $sql = "INSERT INTO Instants (Jour, Heure) VALUES (:jour, :heure)";
        $data = $instants->exportToSQL();
        post_request($bdd, $sql, $data);

        // On récupère l'id de mon instant 
        $sql = "SELECT * FROM instants WHERE Jour = :jour AND Heure = :heure";
        $query = $bdd->prepare($sql);
        // On implémente
        $result = get_request($bdd, $sql, $data, true, true);
        $instant_id = $result['Id'];

    } catch(InvalideInstantExceptions $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view.erreur.php");
        exit;
    } 

    // On ajoute l'action à la base de données
    $sql = "INSERT INTO actions (Intitule, Id_Utilisateurs, Id_Types, Id_Instants) VALUES (:intitule,   :user_id, :type_id, :instant_id)";
    // On vérifie que l'intitulé de l'action a bien été récupéré
    if(empty($intitule)) 
    $intitule = "Connexion de ".$user["identifiant"];
    $data = [
        "intitule" => $intitule,
        "user_id" => $user['cle'],
        "type_id" => $type_id,
        "instant_id" => $instant_id
    ];
    post_request($bdd, $sql, $data);
}