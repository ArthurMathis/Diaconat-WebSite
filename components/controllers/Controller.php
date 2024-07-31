<?php

/**
 * Abstract class representing a controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
abstract class Controller {
    /**
     * Protected attributes containing the controller's model
     */
    protected $Model;
    /**
     * Protected attributes containing the controller's view
     */
    protected $View;

    /**
     * Public method downloading the model into the controller
     */
    public function loadModel(string $model) {
        require_once(MODELS.DS.$model.'.php');
        $this->Model = new $model();
    }
    /**
     * Public method downloading the view into the controller
     */
    public function loadView(string $view) {
        require_once(VIEWS.DS.$view.'.php');
        $this->View = new $view();
    }
}