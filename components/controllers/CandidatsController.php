<?php 

require_once('Controller.php');

class CandidatController extends Controller {
    /// Constructeur de la classe
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    /// Méthode publique affichant la liste des candidats inscrits dans la base de données
    public function displayContent() {
        $items = $this->Model->getContent();
        $this->View->getContent('Candidats', $items);
    }
    /// Méthode publique affichant la page candidat
    public function displayCandidat($Cle_Candidat) {
        // Récupération d'un candidat
        $item = $this->Model->getContentCandidat($Cle_Candidat);
        // On retourne lapage du candidat
        return $this->View->getContentCandidat("Candidat " . $item['candidat']['nom'] . ' ' . $item['candidat']['prenom'], $item);
    }

    /// Méthode publique affichant le formulaire de saisie d'une candidature
    public function getSaisieCandidature($cle_candidat) { 
        // On vérifie l'intégrité du candidat
        $_SESSION['candidat'] = $this->Model->makeCandidat($cle_candidat);
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
    /// Méthode publique affichant le formulaire de saisie d'un contrat
    public function getSaisieContrats($cle_candidat) {
        return $this->View->getContentContrats("Ypopsi - Nouveau contrat", $cle_candidat);
    }
    /// Méthode publique affichant le formulaire de saisie d'un rendez-cous
    public function getSaisierendezVous($cle_candidat) {
        return $this->View->GetContentRendezVous("Nouveau rendez-vous", $cle_candidat);
    }
    /// Méthode publique affichant le formulaire d'édition d'une notation
    public function getEditNotation($cle_candidat) {
        $item = $this->Model->getCandidats($cle_candidat);
        return $this->View->getEditNotation($item);
    }
    /// Méthode publique affichant le formulaire d'édition d'un candidat
    public function getEditCandidat($cle_candidat) {
        $item = $this->Model->getEditContent($cle_candidat);
        return $this->View->getEditCandidat($item);
    }

    /// Méthode publique donnant le statut acceptée à une candidature
    public function acceptCandidature($cle) {
        $this->Model->setCandidatureStatut('acceptee', $cle);
    }
    /// Méthode publique donnant le statut refusée à une candidature
    public function rejectCandidature($cle) {
        // On refuse la candidature
        $this->Model->setCandidatureStatut('refusee', $cle);
        $cle_candidat = $this->Model->searchCandidatFromCandidature($cle);
        header('Location: index.php?candidats=' . $cle_candidat['Id_Candidats']);
    }

    /// Méthode publique donnant le statut acceptée à une candidature
    public function acceptProposition($cle) {
        // Ajouter la signature
        $this->Model->addSignature($cle);
        $cle_candidat = $this->Model->searchcandidatFromContrat($cle);
        header('Location: index.php?candidats=' . $cle_candidat['Id_Candidats']);
    }
    /// Méthode publique donnant le statut refusée à une candidature
    public function rejectProposition($cle) {
        $this->Model->setPropositionStatut($cle);
        $cle_candidat = $this->Model->searchcandidatFromContrat($cle);
        header('Location: index.php?candidats=' . $cle_candidat['Id_Candidats']);
    }
    /// Méthode publique ajoutant une demissione à un contrat
    public function demissioneContrat($cle) {
        $this->Model->addDemission($cle);
        $cle_candidat = $this->Model->searchcandidatFromContrat($cle);
        header('Location: index.php?candidats=' . $cle_candidat['Id_Candidats']);
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
    /// Méthode publique inscrivant un contrat dans la base de données
    public function createContrat($cle_candidats, &$contrats=[]) {
        $this->Model->createContrats($cle_candidats, $contrats);
        header('Location: index.php?candidats=' . $cle_candidats);
    }
    public function createRendezVous($cle_candidat, &$rendezvous=[]) {
        $this->Model->createRendezVous($cle_candidat, $rendezvous);
        header('Location: index.php?candidats=' . $cle_candidat);
    }

    public function updateNotation($cle_candidat, &$notation=[]) {
        $this->Model->updateNotation($cle_candidat, $notation);
        header('Location: index.php?candidats=' . $cle_candidat);
    }
}