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
    /// Méthode publique retournant la pge de modification du mot de passe
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

    /// Méthode publique retournant le formulaire d'inscription d'un utilisateur
    public function displaySaisieUtilisateur() {
        $role = $this->Model->getRoles();
        return $this->View->getSaisieUtilisateur($role);
    }

    public function updatePassword(&$password, &$new_password) {
        // On vérifie que le mot de passe saisi est le bon 
        if($this->Model->verify_password($password)) {
            // On met-à-jour le mot de passe
            $this->Model->updatePassword($new_password);
            $this->Model->updatePasswordLogs();
            header('Location: index.php');

        } else 
            forms_manip::error_alert("Erreur lors de la mise à jour du mot de passe. L'ancien mot de passe ne correspond pas !");
    }

    public function createUtilisateur(&$infos=[]) {
        // On vérifie l'intégrité des données
        if($infos == null || empty($infos))
            throw new Exception("Erreur lors de l'inscription du nouvel utilisateur. Donnée manquante !");

        // On génère le nouvel utilisateur    
        else $this->Model->createUser($infos);

        header("Location: index.php?preferences=liste-nouveaux-utilisateurs");
    }
}