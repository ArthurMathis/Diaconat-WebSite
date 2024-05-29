<?php

abstract class Controller {
    /// Attributs protégés de la classe contenant le chemin d'accès au model et à la view concernés
    protected $Model, $View;

    public function loadModel(string $model) {
        require_once(MODELS.DS.$model.'.php');
        $this->Model = new $model();
    }

    public function loadView(string $view) {
        require_once(VIEWS.DS.$view.'.php');
        $this->View = new $view();
    }
}