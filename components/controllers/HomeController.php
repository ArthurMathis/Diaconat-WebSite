<?php

require_once('Controller.php');

class HomeController extends Controller {
    public function __construct() {
        $this->loadModel('HomeModel');
        $this->loadView('HomeView');
    }

    function displayHome() {
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
    
        return $this->View->getContent($items, $dashboard);
    }
}