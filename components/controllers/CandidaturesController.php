<?php

require_once('Controller.php');

class CandidaturesController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadModel('CandidaturesModel');
        $this->loadView('CandidaturesView');
    }

    public function dispayCandidatures() {
        $items = $this->Model->getCandidatures();
        return $this->View->getContent("Candidatures", $items);
    }
}