<?php

require_once 'Controller.php';

class LoginController extends Controller {
    public function __construct() 
    {
        // $this->loadModel('LocalModel');
        $this->loadView('LoginView');
    }

    function displayLogin() 
    {
        return $this->View->getContent();
    }
}