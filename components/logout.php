<?php
    session_start();

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