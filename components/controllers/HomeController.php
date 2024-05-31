<?php

require_once('Controller.php');

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Home');
        $this->loadView('HomeView');
    }

    function displayHome() {
        $items = $this->Model->getNontraiteesCandidatures();
        $dashboard = [
            [
                'titre' => 'Candidatures en Attente', 
                'content' => $this->Model->getReductEnattenteCandidatures(), 
                'nb_item_max' => 4,
                'link_add' => null,
                'link_consult' => null
            ],
            [
                'titre' => 'Offres en cours', 
                'content' => [], 
                'nb_item_max' => 2,
                'link_add' => null,
                'link_consult' => null
            ],
            [
                'titre' => 'Rendez-vous programmés', 
                'content' => [], 
                'nb_item_max' => 2,
                'link_add' => null,
                'link_consult' => null
            ],
        ];
    
        return $this->View->getContent("Candidatures non-traitée", $items, $dashboard);
    }
}