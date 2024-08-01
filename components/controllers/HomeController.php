<?php

require_once('Controller.php');

/**
 * Class representing the home page controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeController extends Controller {
    /**
     * Class constructor
     */
    public function __construct() {
        $this->loadModel('HomeModel');
        $this->loadView('HomeView');
    }

    /**
     * Public function returning the home page 
     *
     * @return void
     */
    public function displayHome() {
        // ON récupère les données de la page
        $items = $this->Model->getNonTraiteeCandidatures();
        $dashboard = [
            [
                'titre' => 'Propositions en Attente', 
                'content' => $this->Model->getReductProposition(), 
                'nb_item_max' => 6,
                'link_add' => null,
                'link_consult' => null
            ],
            [
                'titre' => 'Rendez-vous programmés', 
                'content' => $this->Model->getReductRendezVous(), 
                'nb_item_max' => 6,
                'link_add' => null,
                'link_consult' => null
            ]
        ];
        
        // On génère la vue
        return $this->View->getContent($items, $dashboard);
    }
}