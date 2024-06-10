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
    public function displaySaisieCandidat() {
        return $this->View->getSaisieCandidatContent("Inscription d'un candidat");
    }
    public function displaySaisieCandidature() {
        return $this->View->getSaisieCandidatureContent("Ajout d'une candidature");
    }

    public function createCandidature($candidat=[], $candidatures=[]) {

    }
    public function createcandidat($candidat=[], $candidatures=[]) {

    }
}