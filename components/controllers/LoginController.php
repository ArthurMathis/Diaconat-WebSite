<?php

require_once 'Controller.php';

class LoginController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Login');
        $this->loadView('LoginView');
    }

    function displayLogin() {
        return $this->View->getContent();
    }
    function displaySignin() {
        return $this->View->getSigninContent();
    }

    public function checkIdentification($identifiant, $motdepasse) {
        $this->Model->connectUser($identifiant, $motdepasse);
        header('Location: index.php');
        exit;
    }
    public function createIdentification($identifiant, $email, $motdepasse) {
        $this->Model->firstConnectUser($identifiant, $email, $motdepasse);
        header('Location: index.php');
        exit;
    }
    public function closeSession() {
        $this->Model->deconnectUser();
        header('Location: index.php');
        exit;
    }
}