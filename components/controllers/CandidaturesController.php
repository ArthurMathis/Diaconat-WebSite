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

    public function checkCandidat($candidat=[], $diplomes=[], $aide, $visite_medicale) {
        $this->Model->verify_candidat($candidat, $diplomes, $aide, $visite_medicale);
        header('Location: index.php?candidatures=saisie-candidature');
    }

    public function createCandidature($candidat, $candidature=[], $diplomes=[], $aide=null) {
        // On ajoute la disponibilité
        $candidat->setDisponibilie($candidature['disponibilite']);

        // On test la présence du candidat dans la base de données
        $search = $this->Model->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());
        if($search == null) {
            // On ajoute le candidat à la base de données
            $this->Model->createCandidat($candidat, $diplomes, $aide);

            // On récupère l'Id du candidat
            $search = $this->Model->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());
            $candidat->setCle($search['Id_Candidats']);

        // On met à jour sa disponibilité
        } else {

        }

        $this->Model->inscriptCandidature($candidat, $candidature);
    }

    // public function createCandidature($candidat, $candidature=[], $diplomes=[], $aide=null) {
    //     // Si le canidat ne fait pas partie de la base de données
    //     if($candidat->getCle() == null) {
    //         // On ajoute la disponibilité
    //         $candidat->setDisponibilie($candidature['disponibilite']);
    // 
    //         // On inscrit le candidat
    //         $this->Model->inscriptCandidat($candidat);
    // 
    //         // On enregistre les diplomes
    //         foreach($diplomes as $item) 
    //             $this->Model->inscriptDiplome($candidat, $item);
    // 
    //         // On enregistre l'aide
    //         $this->Model->inscriptAide($candidat, $aide);
    //     } 
    //     
    //     // Mettre à jour la disponibilité   
    // }
}