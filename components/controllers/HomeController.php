<?php

require_once('Controller.php');

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadModel('Home');
        $this->loadView('HomeView');
    }

    function displayHome() {
        $dashboard = [
            [
                'titre' => 'Candidatures en attente',
                'content' => [
                    [
                        'Nom' => 'Rousseau',
                        'Prenom' => 'Chloe',
                        'Poste' => 'Radiologue'
                    ],
                    [
                        'Nom' => 'Petit',
                        'Prenom' => 'Paul',
                        'Poste' => 'Pédiatre'
                    ],
                    [
                        'Nom' => 'Moreau',
                        'Prenom' => 'Sophie',
                        'Poste' => 'Pharmacien'
                    ],
                    [
                        'Nom' => 'David',
                        'Prenom' => 'Thomas',
                        'Poste' => 'Oncologue'
                    ]
                ],
                'nb_item_max' => 4,
                'link_add' => null,
                'link_consult' => null
            ], 
            [
                'titre' => 'Candidatures en attente',
                'content' => [
                    [
                        'Nom' => 'Rousseau',
                        'Prenom' => 'Chloe',
                        'Poste' => 'Radiologue'
                    ],
                    [
                        'Nom' => 'Petit',
                        'Prenom' => 'Paul',
                        'Poste' => 'Pédiatre'
                    ],
                    [
                        'Nom' => 'Moreau',
                        'Prenom' => 'Sophie',
                        'Poste' => 'Pharmacien'
                    ],
                    [
                        'Nom' => 'David',
                        'Prenom' => 'Thomas',
                        'Poste' => 'Oncologue'
                    ]
                ],
                'nb_item_max' => 2,
                'link_add' => null,
                'link_consult' => null
            ],
            [
                'titre' => 'Candidatures en attente',
                'content' => [
                    [
                        'Nom' => 'Rousseau',
                        'Prenom' => 'Chloe',
                        'Poste' => 'Radiologue'
                    ],
                    [
                        'Nom' => 'Petit',
                        'Prenom' => 'Paul',
                        'Poste' => 'Pédiatre'
                    ],
                    [
                        'Nom' => 'Moreau',
                        'Prenom' => 'Sophie',
                        'Poste' => 'Pharmacien'
                    ],
                    [
                        'Nom' => 'David',
                        'Prenom' => 'Thomas',
                        'Poste' => 'Oncologue'
                    ]
                ],
                'nb_item_max' => 2,
                'link_add' => null,
                'link_consult' => null
            ]
        ];

        $items = $this->Model->getNontraiteeCandidature();
        $jsonItems = json_encode($items);
        echo "<script>
            const items = $jsonItems;
            console.table(items);
        </script>";

        
        return $this->View->getContent("Candidatures non-traitée", $items, $dashboard);
    }
}