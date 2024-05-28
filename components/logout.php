<?php

    require_once "connect_server.php";
    require_once "../objects/Instants.php";
    require_once "data_requests.php";

    session_start();
    global $bdd;

    // On enregistre la déconnexion 
    // On récupère la requête
    $user = $_SESSION['user'];
    if(!empty($user)) {
        // On récupère le type connexion 
        $sql = "SELECT * FROM types WHERE Intitule = :Intitule";
        $result = get_request($bdd, $sql, ["Intitule" => "Deconnexion"], true, true);
        // On implémente
        $type = $result['Intitule'];
        $type_id = $result['Id'];

        try {
            // On génère l'instant actuel (date et heure actuelles)
            $instants = Instants::currentInstants();

        } catch(InvalideInstantExceptions $e){
            $_SESSION['erreur'] = $e;
            // On redirige la page
            header("Location: ../view.erreur.php");
            exit;
        } 

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

        // On ajoute l'action à la base de données
        $sql = "INSERT INTO actions (Intitule, Id_Utilisateurs, Id_Types, Id_Instants) VALUES (:intitule,   :user_id, :type_id, :instant_id)";
        // On vérifie que l'intitulé de l'action a bien été récupéré
        if(empty($intitule)) 
        $intitule = "Deconnexion de ".$user["identifiant"];
        $data = [
            "intitule" => $intitule,
            "user_id" => $user['cle'],
            "type_id" => $type_id,
            "instant_id" => $instant_id
        ];
        post_request($bdd, $sql, $data);
    }

    // Supprime toutes les variables de session
    $_SESSION = array();

    // Si vous souhaitez détruire complètement la session, supprimez également le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Détruit la session
    session_destroy();

    // Redirige l'utilisateur vers la page de connexion
    header("Location: ../view/connexion.php");
    exit;
?>