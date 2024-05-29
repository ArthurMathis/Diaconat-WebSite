<?php 

require_once 'define.php';
require_once MODELS.DS.'Connexion.php';
require_once CONTROLLERS.DS.'LoginController.php';

// On démarre la session de l'utilisateur
session_start();

// On lance la connexion à la base de données
env_start();

global $bdd;

if(isset($_GET['login'])) {
    switch($_GET['login']) {
        case 'connexion' : 
            try {
                // On récupère les données saisies
                $identifiant = $_POST["identifiant"];
                $motdepasse = $_POST["motdepasse"];
                
                // On vérifie leur intégrité
                if(empty($identifiant)) {
                    throw new Exception("Le champs identifiant doit être rempli !");
                } elseif(empty($motdepasse)) {
                    throw new Exception("Le champs mot de passe doit être rempli !");
                } 
    
            } catch(Exception $e){
                session_start();
                $_SESSION['erreur'] = $e;
                // On redirige la page
                header("Location: erreur.php");
                exit;
            }

            try {
                $login = new LoginController();
                $login->checkIdentification($identifiant, $motdepasse);
                
            } catch(Exception $e) {
                echo "<script>alert('Erreur: " . $e->getMessage() . "');</script>";
            }

            echo "Bonjour " . $_SESSION['user_identifiant'] . " !";
            break;

        case 'deconnexion' : 
            break;

        default : 
            $c = new LoginController();
            $c->displayLogin();
            break;
    }

} else {
    $c = new LoginController();
    $c->displayLogin();
}

