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
            echo "Bonjour !";
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

