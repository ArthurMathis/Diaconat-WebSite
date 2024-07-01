<?php 

require_once('Controller.php');

class CandidatController extends Controller {
    /// Constructeur de la classe
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    /// Méthode publique affichant la page candidat
    public function displayCandidat($Cle_Candidat) {
        // Récupération d'un candidat
        $item = $this->Model->getContent($Cle_Candidat);
        // On garde en mémoire la clé du candidat pour les éventuelles modification
        $_SESSION['cle candidat'] = $Cle_Candidat;

        return $this->View->getContent("Candidat " . $item['candidat']['nom'] . ' ' . $item['candidat']['prenom'], $item);
    }

    /// Méthode privée récupérant dans la base de données le candidat depuis sa clé
    private function getCandidat() {
        if(!isset($_SESSION['cle candidat']) && !empty($_SESSION['cle candidat']))
            throw new Exception("Aucun candidat n'est assigné à la demande !");

        $_SESSION['candidat'] = $this->Model->makeCandidat($_SESSION['cle candidat']);
        unset($_SESSION['cle candidat']);
    }

    /// Méthode publique affichant le formulaire de saisie d'une candidature
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
    /// Méthode publique affichant le formulaire de saisie d'une proposition
    public function getSaisieProposition($cle_candidat) {
        return $this->View->getContentProposition("Ypopsi - Nouvelle proposition", $cle_candidat);
    }
    /// Méthode publique affichant le formulaire de saisie d'une proposition depuis une candidature
    public function getSaisiePropositionFromCandidature($cle_candidature) {
        $type_candidature = $this->Model->getTypeContrat($cle_candidature);
        return $this->View->getContentPropositionFromCandidatures("Ypopsi - Nouvelle proposition", $cle_candidature, $type_candidature);
    }
    /// Méthode publique affichant le formulaire de saisie d'une proposition depuis une candidature vide
    public function getSaisiePropositionFromEmptyCandidature($cle_candidature) {
        $type_candidature = $this->Model->getTypeContrat($cle_candidature);
        return $this->View->getContentPropositionFromEmptyCandidatures("Ypopsi - Nouvelle proposition", $cle_candidature, $type_candidature);
    }

    /// Méthode publique donnant le statut acceptée une candidature
    public function acceptCandidature($cle) {
        try {
            $this->Model->setCandidatureStatut('acceptee', $cle);

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
    }
    /// Méthode publique donnant le statut refusée une candidature
    public function rejectCandidature($cle) {
        try {
            $this->Model->setCandidatureStatut('refusee', $cle);

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        
        // header('Location: index.php?candidats=' . $_SESSION['cle candidat']);
    }

    /// Méthode publique générant une proposition et l'inscrivant dans la base de donnés
    public function createProposition($cle, $propositions) {
        $this->Model->createPropositions($cle, $propositions);
        header('Location: index.php?candidats=' . $cle);
    }
    /// Méthode publique préparant les données d'une candidature pour la génération d'une porposition d'embauche 
    public function createPropositionFromCandidature($cle_candidature, $propositions=[]) {
        $cle_candidat = null;
        // On récupère les données du futur contrat
        $this->Model->createPropositionsFromCandidature($cle_candidature, $propositions, $cle_candidat);
        
        // On génère la proposition
        $this->createProposition($cle_candidat, $propositions);
        // On assigne le nouveau statut à la candidature
        $this->acceptCandidature($cle_candidature);
    }
    /// Méthode publique préparant les données d'une candidature pour la génération d'une porposition d'embauche
    public function createPropositionFromEmptyCandidature($cle_candidature, $propositions=[]) {
        $cle_candidat = null;
        // On récupère les données du futur contrat
        $this->Model->createPropositionsFromEmptyCandidature($cle_candidature, $propositions, $cle_candidat);
        
        // On génère la proposition
        $this->createProposition($cle_candidat, $propositions);
        // On assigne le nouveau statut à la candidature
        $this->acceptCandidature($cle_candidature);
    }
}