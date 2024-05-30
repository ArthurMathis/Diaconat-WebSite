<?php

require_once(VIEWS.DS.'ErrorView.php');

abstract class Controller {
    /// Attributs protégés de la classe contenant le chemin d'accès au model et à la view concernés
    protected $Model, $View, $Error;

    /// Constructeur de la classe Controller
    public function __construct() {
        $this->Error = new ErrorView();
    }

    /// Méthode publique téléchargeant le modèle dans le controller
    public function loadModel(string $model) {
        require_once(MODELS.DS.$model.'.php');
        $this->Model = new $model();
    }
    /// Méthode publique téléchargeant la vue dans le controller
    public function loadView(string $view) {
        require_once(VIEWS.DS.$view.'.php');
        $this->View = new $view();
    }

    /// Méthode publique affaichant une page d'erreur
    public function displayErreur($e) {
        return $this->Error->getErrorContent($e);
    }
}