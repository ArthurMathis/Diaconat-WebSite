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
            'contrats' => [
                [
                    'mission' => [
                        'intitule' => 'Développeur fullstack PHP',
                        'postes' => 'Développeur',
                        'service' => 'Service développement', 
                        'etablissement' => 'Diaconat Fonderie'
                    ], 
                    'salaire' => '120',
                    'horaires' => [
                        'heures' => '35',
                        'nuit' => 'false',
                        'week-end' => 'false'
                    ],    
                    'date debut' => '2024-05-13',
                    'date fin' => '2024-08-09',
                    'demission' => 'false', 
                    'type contrat' => 'Stage',
                    'proposition' => '2024-05-01', 
                    'statut' => 'false',
                    'signature' => '2024-05-13'
                ],
                [
                    'mission' => [
                        'intitule' => 'Développeur fullstack PHP',
                        'postes' => 'Développeur',
                        'service' => 'Service développement', 
                        'etablissement' => 'Diaconat Fonderie'
                    ], 
                    'salaire' => '240',
                    'horaires' => [
                        'heures' => '35',
                        'nuit' => 'false',
                        'week-end' => 'false'
                    ],    
                    'date debut' => '2024-09-09',
                    'date fin' => '2026-09-09',
                    'demission' => 'false', 
                    'type contrat' => 'Alternance',
                    'proposition' => '2024-01-09', 
                    'statut' => 'false',
                    'signature' => ''
                ]
            ],
            'rendez-vous' => [
                [
                    'utilisateur' => 'keller.y', 
                    'date' => '2024-01-05',
                    'description' => 'Elément motivé et discipliné'
                ],
                [
                    'utilisateur' => 'keller.y', 
                    'date' => '2025-13-08',
                    'description' => "Férot tu me poses une question. Est-ce qu'il faut vraiment un contexte."
                ],
                [
                    'utilisateur' => 'keller.y', 
                    'date' => '2026-03-21',
                    'description' => "Non mais pitié. Il faut arrêter. "
                ]
            ],
            'notation' => [
                'a' => 'false',
                'b' => 'false',
                'c' => 'false',
                'd' => 'false',
                'e' => 'false',
                'description' => 'Elément sociable, agréable en équipe et performant'
            ]
        ];
        return $this->View->getContent("Candidat " . $item['candidat']['nom'], $item);
    }
}