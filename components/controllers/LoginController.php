<?php

require_once 'Controller.php';

class LoginController extends Controller {
    /// Constructeur du controller
    public function __construct() {
        $this->loadModel('LoginModel');
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
        alert_manipulation::alert([
            'title' => 'Connexion réussie',
            'msg' => 'Bienvene ' . strtoupper($_SESSION['user_nom']) . ' ' . forms_manip::nameFormat($_SESSION['user_prenom']),
            'direction' => 'index.php'
        ]);
    }
    /// Méthode publique déconnectant un utilisateur à l'application
    public function closeSession() {
        $this->Model->deconnectUser();
        header('Location: index.php');
    }
}