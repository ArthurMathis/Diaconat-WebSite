<?php

require_once('Controller.php');
require_once(CLASSE.DS.'Candidats.php');

class CandidaturesController extends Controller {
    public function __construct() {
        $this->loadModel('CandidaturesModel');
        $this->loadView('CandidaturesView');
    }

    public function dispayCandidatures() {
        $items = $this->Model->getCandidatures();
        return $this->View->getContent("Candidatures", $items);
    }
    public function displaySaisieCandidat() {
        return $this->View->getSaisieCandidatContent(
            'Ypopsi - Nouveau candidat', 
            $this->Model->getDiplomes(),
            $this->Model->getAides()
        );
    }
    public function displayRechercheCandidat() {
        return $this->View->getRechercheCandidatContent("Ypopsi - Recherche d'un candidat");
    }
    public function displaySaisieCandidature() {
        return $this->View->getSaisieCandidatureContent(
            "Ypopsi - Recherche d'un candidat", 
            $this->Model->getAutoCompPostes(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompTypesContrat(),
            $this->Model->getAutoCompSources()
        );
    }

    /// Méthode publique vérifiant les données d'un candidat avant la redirection vers le formulaire de saisie de candidature
    public function checkCandidat(&$candidat=[], $diplomes=[], $aide=[], $visite_medicale) {
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
                $search['CodePostal_Candidats']
            );
            $candidat->setCle($search['Id_Candidats']);
            
        } catch(InvalideCandidatExceptions $e) {
            forms_manip::error_alert($e->getMessage());
        }

        $_SESSION['candidat'] = $candidat;

        // On redirige la page
        header('Location: index.php?candidatures=saisie-candidature');
    }

    public function createCandidature($candidat, &$candidature=[], &$diplomes=[], &$aide=[]) {
        echo "<h2>On génère la candidat</h2>";
        echo "<h3>On ajoute la disponibilité du candidat</h3>";
        // On ajoute la disponibilité
        $candidat->setDisponibilite($candidature['disponibilite']);

        echo "<h3>On recherche la clé du candidat</h3>";
        if($candidat->getCle() === null) {
            // On test la présence du candidat dans la base de données
            try {
                $search = $this->Model->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());

            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }
            
            if(empty($search)) {
                // On ajoute le candidat à la base de données
                $this->Model->createCandidat($candidat, $diplomes, $aide);

            // On met à jour sa disponibilité
            } else 
                // On ajoute la clé de Candidats
                $candidat->setCle($search['Id_Candidats']);
        }
        var_dump($candidat->getCle());

        echo "<h3>Le candidat</h3>";
        var_dump($candidat);
        // On inscrit la candidature
        $this->Model->inscriptCandidature($candidat, $candidature);
        
        // On redirige la page
        alert_manipulation::alert([
            'title' => 'Candidat inscript !',
            'msg' => strtoupper($candidat->getNom()) . " " . forms_manip::nameFormat($candidat->getPrenom()) . " a bien été inscrit(e).",
            'direction' => "index.php?candidats=" . $candidat->getCle()
        ]);
    }
}