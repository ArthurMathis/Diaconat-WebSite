<?php 

require_once('Controller.php');

class UtilisateurController extends Controller {
    /// Constructeur de la classe
    public function __construct() {
        $this->loadModel('UtilisateursModel');
        $this->loadView('UtilisateursView');
    }

    public function displayUtilisateurs() {
        $items = $this->Model->getUtilisateurs();
        return $this->View->getContent("Utilisateurs", $items);
    }
}