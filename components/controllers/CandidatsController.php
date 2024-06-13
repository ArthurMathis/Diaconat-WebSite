<?php 

require_once('Controller.php');

class CandidatController extends Controller {
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    public function displayCandidat($Cle_Candidat) {
        // Récupération d'un candidat
        $item = [
            'candidat' => [
                'nom' => 'Mathis',
                'prenom' => 'Arthur',
                'telephone' => 063885557, 
                'email' => 'arthur.mathis@diaconat-mulhouse.fr',
                'adresse' => '22 Quai d\'Izly', 
                'ville' => 'Mulhouse', 
                'code_postal' => 68100, 
                'disponibilite' => '2024-07-07', 
                'diplomes' => [
                        'Brevet des collèges général - mention très bien',
                        'Baccalauréat général, spécialités mathématiques et physique-chimie',
                        'Licence MIAGE'
                    ], 
                'notation' => 3
            ],
            'candidature' => [

            ],
            'contrats' => [

            ], 
            'rendez-vous' => [

            ]
        ];
        return $this->View->getContent("Candidat " . $item['candidat'['nom']], $item);
    }
}