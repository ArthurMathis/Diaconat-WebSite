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
        $aide = $this->Model->getAides();
        return $this->View->getSaisieCandidatContent('Ypopsi - Nouveau candidat', $aide);
    }
    public function displayRechercheCandidat() {
        return $this->View->getRechercheCandidatContent("Ypopsi - Recherche d'un candidat");
    }
    public function displaySaisieCandidature() {
        return $this->View->getSaisieCandidatureContent("Ypopsi - Recherche d'un candidat");
    }
    public function displaySaisieProposition() {
        return $this->View->getSaisieProposition("Ypopsi - Nouvelle proposition");
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

    public function createCandidature($candidat, $candidature=[], $diplomes=[], $aide) {
        // On ajoute la disponibilité
        $candidat->setDisponibilite($candidature['disponibilite']);

        echo "On vérifie la présence de la clé Candidats<br>";

        if($candidat->getCle() === null) {

            echo "On vérifie la présence de la clé dans la base de données<br>";

            // On test la présence du candidat dans la base de données
            $search = $this->Model->searchcandidat($candidat->getNom(), $candidat->getPrenom(), $candidat->getEmail());

            // Encodage de l'objet PHP en JSON
            $jsonItem = json_encode($search);
            echo '<script>console.log("Item");</script>';
            echo '<script>console.log(' . $jsonItem . ');</script>';

            if(empty($search)) {
                echo "On enregistre un nouvel utilisateur<br>";
            
                // On ajoute le candidat à la base de données
                $this->Model->createCandidat($candidat, $diplomes, $aide);

            // On met à jour sa disponibilité
            } else 
                // On ajoute la clé de Candidats
                $candidat->setCle($search['Id_Candidats']);
        }
        
        echo $candidat->getCle();
        
        // On inscrit la candidature
        $this->Model->inscriptCandidature($candidat, $candidature);
        
        // On redirige la page
        header("Location: index.php");
    }
}