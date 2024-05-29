<?php

require_once 'Controller.php';

class LoginController extends Controller {
    public function __construct() {
        $this->loadModel('Login');
        $this->loadView('LoginView');
    }

    function displayLogin() {
        return $this->View->getContent();
    }

    public function checkIdentification($identifiant, $motdepasse) {
        $this->Model->connectUser($identifiant, $motdepasse);
        header('Location: index.php');
    }
}