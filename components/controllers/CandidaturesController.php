<?php

require_once('Controller.php');
require_once(CLASSE.DS.'Candidats.php');

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
    public function displayRechercheCandidat() {
        return $this->View->getRechercheCandidatContent("Recherche d'un candidat");
    }
    public function displaySaisieCandidature() {
        return $this->View->getSaisieCandidatureContent("Ajout d'une candidature");
    }

    public function checkCandidat($candidat=[], $diplomes=[], $aide, $visite_medicale) {
        // On contruit le nouveau candidat
        $this->Model->verify_candidat($candidat, $diplomes, $aide, $visite_medicale);
        // On redirige la page
        header('Location: index.php?candidatures=saisie-candidature');
    }
    public function findCandidat($nom, $prenom, $email=null, $telephone=null) {
        // On récupère le candidat dans la base de données
        $search = $this->Model->searchCandidat($nom, $prenom, $email, $telephone);

        // On l'enregistre dans la session
        try {
            $candidat = new Candidat(
                $search['Nom_Candidats'],
                $search['Prenom_Candidats'],
                $search['Email_Candidats'],
                $search['Telephone_Candidats'],
                $search['Adresse_Candidats'],
                $search['Ville_Candidats'],
                $search['CodePostale_Candidats']
            );
            $candidat->setCle($search['Id_Candidats']);
            
        } catch(InvalideCandidatExceptions $e) {
            $Error = new ErrorView();
            $Error->getErrorContent($e);
            exit;
        }

        $_SESSION['candidat'] = $candidat;

        // On redirige la page
        header('Location: index.php?candidatures=saisie-candidature');
    }

    public function createCandidature($candidat, $candidature=[], $diplomes=[], $aide=null) {
        // On ajoute la disponibilité
        $candidat->setDisponibilite($candidature['disponibilite']);

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

        // On inscrit la candidature
        $this->Model->inscriptCandidature($candidat, $candidature);

        // On redirige la page
        header("Location: index.php");
    }
}