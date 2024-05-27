<?php

require_once("../components/connect_server.php");
require_once('../objects/Instants.php');

// On récupère la requête
$user = $_SESSION['user'];
if(empty($user)) {
    $e = new Exception("Profil utilisateur introuvable");
    $_SESSION['erreur'] = $e;
    header("Location: ../view/erreur.php");
    exit;

} else {
    // On récupère l'accès à la base de données
    global $bdd;

    try {
        // On récupère les types d'actions
        $sql = "SELECT * FROM types WHERE Intitule = :Intitule";
        $query = $bdd->prepare($sql);
        $query->execute(["Intitule" => "Connexion"]);

        // On récupère le résultat de la requête
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) 
            throw new Exception("Erreur de récupération du type d'action");
        else {
            $type = $result['Intitule'];
            $type_id = $result['Id'];
        }

    } catch(PDOException $e){
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: ../view/erreur.php");
        exit;
    }

    global $type;
    global $type_id;

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
        $sql = "INSERT INTO actions (Intitule, Id_Utilisateurs, Id_Types, Id_Instants) VALUES (:intitule,   :user_id, :type_id, :instant_id)";
        $query = $bdd->prepare($sql);


        echo "<script>console.log(\"Clé utilisateur : " . $user["cle"] . "\");</script>";

        $query->execute([
            "intitule" => "Connexion de ".$user["identifiant"],
            "user_id" => $user['cle'],
            "type_id" => $type_id,
            "instant_id" => $instant_id
        ]);
    } catch(PDOException $e){
        /* 
        $_SESSION['erreur'] = $e;
        // On redirige la page
        header("Location: erreur.php");
        exit;
        */
    }
}