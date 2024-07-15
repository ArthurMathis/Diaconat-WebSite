<?php

require_once('Controller.php');

class PreferencesController extends Controller {
    public function __construct() {
        $this->loadModel('PreferencesModel');
        $this->loadView('PreferencesView');
    }

    public function display() {
        $items=[];
        return $this->View->getContent($items);
    }
}