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
                'telephone' => '063885557', 
                'email' => 'arthur.mathis@diaconat-mulhouse.fr',
                'adresse' => '22 Quai d\'Izly', 
                'ville' => 'Mulhouse', 
                'code_postal' => '68100', 
                'disponibilite' => '2024-07-07', 
                'diplomes' => [
                        'Brevet des collèges général - mention très bien',
                        'Baccalauréat général, spécialités mathématiques et physique-chimie',
                        'Licence MIAGE'
                    ], 
                'notation' => 3, 
            ],
            'candidatures' => [
                [
                    'statut' => 'en attente', 
                    'source' => 'email',
                    'type_de_contrat' => 'Stage',
                    'date' => '2024-12-06',
                    'poste' => 'Développeur Web', 
                    'service' => 'Service Développement',
                    'etablissement' => 'Diaconat Fonderie'
                ],
                [
                    'statut' => 'en attente', 
                    'source' => 'email',
                    'type_de_contrat' => 'Alternance',
                    'date' => '2024-12-06',
                    'poste' => 'Développeur Web', 
                    'service' => 'Service Développement',
                    'etablissement' => 'Diaconat Fonderie'
                ]
            ],
            'rendez-vous' => [

            ]
        ];
        return $this->View->getContent("Candidat " . $item['candidat']['nom'], $item);
    }
}