<?php 

require_once('define.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');

// On démarre la session de l'utilisateur
session_start();

// On lance la connexion à la base de données
env_start();

if(isset($_GET['login'])) {
    $login = new LoginController();
    switch($_GET['login']) {
        // On connecte l'utilisateur     
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
                $login->displayErreur($e);
                exit;
            }

            try {
                $login->checkIdentification($identifiant, $motdepasse);

            } catch(Exception $e) {
                $login->displayErreur($e);
                return ;
            }

            break;

        // On inscrit l'utilisateur    
        case 'inscription' : 
            try {
                // On récupère les données saisies
                $identifiant = $_POST["identifiant"];
                $email = $_POST["email"];
                $motdepasse = $_POST["motdepasse"];
                $confirmation = $_POST["confirmation"];
    
                // On vérifie leur intégrité
                if(empty($identifiant)) {
                    throw new Exception("Le champs identifiant doit être rempli !");
                } elseif(empty($email)) {
                    throw new Exception("Le champs email doit être rempli !");
                }  elseif(empty($motdepasse)) {
                    throw new Exception("Le champs mot de passe doit être rempli !");
                }  elseif(empty($confirmation)) {
                    throw new Exception("Le champs confirmation doit être rempli !");
                } elseif($motdepasse != $confirmation) {
                    throw new Exception("Les champs mot de passe et confirmation doivent être identiques");
                }

            } catch(Exception $e){
                $login->displayErreur($e);
                exit;
            }

            try {
                $login->createIdentification($identifiant, $email, $motdepasse);

            } catch(Exception $e) {
                $login->displayErreur($e);
                exit;
            }

            break;    

        // On déconnecte l'utilisateur    
        case 'deconnexion' : 
            $login->closeSession();
            break;

        // On retourne le formulaire de connexion
        case 'get_connexion' :
            $login->displayLogin(); 
            break;

        // On retourne le formulaire d'inscription
        case 'get_inscription' : 
            $login->displaySignin();
            break;    

        default : 
            $c->displayLogin();
            break;
    }

} elseif(isset($_SESSION['user_cle'])) {
    $home = new HomeController();
    $home->displayHome();

} else {
    $c = new LoginController();
    $c->displayLogin();
}