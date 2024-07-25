<?php

require_once('Controller.php');

class PreferencesController extends Controller {
    /// Constructeur de la classe
    public function __construct() {
        $this->loadModel('PreferencesModel');
        $this->loadView('PreferencesView');
    }

    /// Méthode publique retournant la page de préférences
    public function display() {
        $items = $this->Model->getProfil($_SESSION['user_cle']);
        return $this->View->getContent($items);
    }
    /// Méthode publique retournant la page de modification du mot de passe
    public function displayEdit() {
        return $this->View->getEditpassword();
    }

    /// Méthode publique retournant la page Utilisateurs
    public function displayUtilisateurs() {
        $items = $this->Model->getUtilisateurs();
        return $this->View->getUtilisateursContent($items);
    }
    /// Méthode publique retournant la page de nouvels utilisateurs
    public function displayNouveauxUtilisateurs() {
        $items = $this->Model->getNouveauxUtilisateurs();
        return $this->View->getNouveauxUtilisateursContent($items);
    }
    /// Méthode publique retournant la page Historique
    public function displayConnexionHistorique() {
        $items = $this->Model->getConnexionHistorique();
        return $this->View->getConnexionHistoriqueContent($items);
    }
    /// Méthode publique retournant la page Historique
    public function displayActionHistorique() {
        $items = $this->Model->getActionHistorique();
        return $this->View->getActionHistoriqueContent($items);
    }
    /// Méthode publique retournant la page Postes
    public function displayPostes() {
        $poste = $this->Model->getPostes();
        return $this->View->getPostesContent($poste);
    }
    /// Méthode publique retournant la page Services
    public function displayServices() {
        $poste = $this->Model->getServices();
        return $this->View->getServicesContent($poste);
    }
    /// Méthode publique retournant la page Etablissements
    public function displayEtablissements() {
        $etablissements = $this->Model->getEtablissements();
        return $this->View->getEtablissementsContent($etablissements);
    }
    /// Méthode publique retournant la page Pôles
    public function displayPoles() {
        $pole = $this->Model->getPoles();
        return $this->View->getPolesContent($pole);
    }

    /// Méthode publique retournant le formulaire d'inscription d'un utilisateur
    public function displaySaisieUtilisateur() {
        $role = $this->Model->getRoles();
        return $this->View->getSaisieUtilisateur($role);
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau poste
    public function displaySaisiePoste() {
        return $this->View->getSaisiePoste();
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau service
    public function displaySaisieService() {
        return $this->View->getSaisieService();
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouvel établissement
    public function displaySaisieEtablissement() {
        return $this->View->getSaisieEtablissement();
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau pole
    public function displaySaisiePole() {
        return $this->View->getSaisiePole();
    }

    /// Méthode publique mettant à jour le mot de passe de l'utilisateur actuel
    public function updatePassword(&$password, &$new_password) {
        // On vérifie que le mot de passe saisi est le bon 
        if($this->Model->verify_password($password)) {
            // On met-à-jour le mot de passe
            $this->Model->updatePassword($new_password);
            $this->Model->updatePasswordLogs();
            alert_manipulation::alert([
                'title' => 'Opération réussie',
                'msg' => "Votre mot de passe a bien été modifié !",
                'direction' => 'index.php'
            ]);

        } else 
            forms_manip::error_alert("Erreur lors de la mise à jour du mot de passe", "L'ancien mot de passe ne correspond pas !");
    }

    /// Méthode publique générant un nouvel utilisateur
    public function createUtilisateur(&$infos=[]) {
        // On vérifie l'intégrité des données
        if($infos == null || empty($infos))
            throw new Exception("Erreur lors de l'inscription du nouvel utilisateur. Donnée manquante !");

        // On génère le nouvel utilisateur    
        else $this->Model->createUser($infos);

        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouvel utilisateur enregistré !",
            'direction' => 'index.php?preferences=liste-nouveaux-utilisateurs'
        ]);
    }
    /// Méthode publique générant un nouveau poste
    public function createPoste(&$infos=[]) {
        // On vérifie l'intégrité des données
        if(empty($infos)) 
            throw new Exception("Erreur lors de l'inscription du poste. Données manquantes lors de la génération du poste !");

        // On génère le nouveua poste
        else $this->Model->createPoste($infos);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau poste enregistré !",
            'direction' => 'index.php?preferences=liste-postes'
        ]);
    }
    /// Méthode publique générant un nouveau service
    public function createService(&$service, &$etablissement) {
        // On génère le nouveau poste
        $this->Model->createService($service, $etablissement);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau service enregistré !",
            'direction' => 'index.php?preferences=liste-services'
        ]);
    }
    /// Méthode publique générant un nouvel établissement
    public function createEtablissement(&$infos=[]) {
        // On génère le nouvel établissement
        $this->Model->createEtablissement($infos);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau établissement enregistré !",
            'direction' => 'index.php?preferences=liste-etablissements'
        ]);
    }
    /// Méthode publique générant un nouveau pôle
    public function createPole(&$intitule, &$description) {
        // On génère le nouvel établissement
        $this->Model->createPole($intitule, $description);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau pôle enregistré !",
            'direction' => 'index.php?preferences=liste-poles'
        ]);
    }
}