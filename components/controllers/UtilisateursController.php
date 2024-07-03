<?php 

require_once('Controller.php');

class UtilisateurController extends Controller {
    /// Constructeur de la classe
    public function __construct() {
        $this->loadModel('UtilisateursModel');
        $this->loadView('UtilisateursView');
    }

    /// Méthode publique retournant la page Utilisateurs
    public function displayUtilisateurs() {
        $items = $this->Model->getUtilisateurs();
        return $this->View->getUtilisateursContent("Utilisateurs", $items);
    }
    /// Méthode publique retournant la page Historique
    public function displayHistorique() {
        $items = $this->Model->getHistorique();
        return $this->View->getHistoriqueContent("Historique", $items);
    }
    /// Méthode publique retournant le formulaire d'inscription d'un utilisateur
    public function displaySaisieUtilisateur() {
        $role = $this->Model->getRoles();
        return $this->View->getSaisieUtilisateur($role);
    }

    public function createUtilisateur(&$infos=[]) {
        // On vérifie l'intégrité des données
        if($infos == null || empty($infos))
            throw new Exception("Erreur lors de l'inscription du nouvel utilisateur. Donnée manquante !");

        // On génère le nouvel utilisateur    
        else $this->Model->createUser($infos);

        header("Location: index.php?utilisateurs=home");
    }
}