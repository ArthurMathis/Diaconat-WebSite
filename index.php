<?php 

require_once 'define.php';
require_once MODELS.DS.'Connexion.php';
require_once CONTROLLERS.DS.'LoginController.php';

// On démarre la session de l'utilisateur
session_start();

// On lance la connexion à la base de données
env_start();
$server = new Connexion();

$c = new LoginController();
$c->displayLogin();