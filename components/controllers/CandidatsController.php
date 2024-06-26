<?php 

require_once('Controller.php');

class CandidatController extends Controller {
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    public function displayCandidat($Cle_Candidat) {
        // Récupération d'un candidat
        $item = $this->Model->getContent($Cle_Candidat);
        // On garde en mémoire la clé du candidat pour les éventuelles modification
        $_SESSION['cle candidat'] = $Cle_Candidat;

        return $this->View->getContent("Candidat " . $item['candidat']['nom'] . ' ' . $item['candidat']['prenom'], $item);
    }

    private function getCandidat() {
        if(!isset($_SESSION['cle candidat']) && !empty($_SESSION['cle candidat']))
            throw new Exception("Aucun candidat n'est assigné à la demande !");

        $_SESSION['candidat'] = $this->Model->makeCandidat($_SESSION['cle candidat']);
        unset($_SESSION['cle candidat']);
    }

    public function getSaisieCandidature() {
        // On vérifie l'intégrité du candidat
        try {
            $this->getCandidat();

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }

        // On redirige la page
        header('Location: index.php?candidatures=saisie-candidature');
    }
    public function getSaisieProposition() {
        // On vérifie l'intégrité du candidat
        try {
            $this->getCandidat();

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }

        // On redirige la page
        header('Location: index.php?candidatures=saisie-proposition');
    }

    public function acceptCandidature($cle) {

    }
    public function rejectCandidature($cle) {
        try {
            $this->Model->setCandidatureStatut('refusee', $cle);
        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        
        header('Location: index.php?candidats='.$_SESSION['cle candidat']);
    }
}