<?php

require_once 'Controller.php';

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadView('HomeView');
    }

    function displayHome() {
        return $this->View->getContent();
    }
}