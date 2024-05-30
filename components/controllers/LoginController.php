<?php

require_once 'Controller.php';

class LoginController extends Controller {
    /// Constructeur du controller
    public function __construct() {
        parent::__construct();
        $this->loadModel('Login');
        $this->loadView('LoginView');
    }

    /// Méthode publique retournant le formulaire de connexion
    function displayLogin() {
        return $this->View->getContent();
    }
    /// Méthode publique retournant le formulaire de connexion
    function displaySignin() {
        return $this->View->getSigninContent();
    }

    /// Méthode publique connectant un utilisateur à l'application
    public function checkIdentification($identifiant, $motdepasse) {
        $this->Model->connectUser($identifiant, $motdepasse);
        header('Location: index.php');
        exit;
    }
    /// Méthode publique inscrivant un utilisateur à l'application
    public function createIdentification($identifiant, $email, $motdepasse) {
        $this->Model->firstConnectUser($identifiant, $email, $motdepasse);
        header('Location: index.php');
        exit;
    }
    /// Méthode publique déconnectant un utilisateur à l'application
    public function closeSession() {
        $this->Model->deconnectUser();
        header('Location: index.php');
        exit;
    }
}