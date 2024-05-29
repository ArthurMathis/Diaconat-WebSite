<?php 

require_once 'define.php';
require_once MODELS.DS.'Connexion.php';

session_start();
env_start();

$server = new Connexion();


/*
require_once CONTROLLERS.DS.'Controller.php';
require_once CONTROLLERS.DS.'LoginController.php';



if(isset($_GET['login'])){
    echo "Bienvenu";

} else {
    $c = new LoginController();
    $c->displayLogin();
}
*/