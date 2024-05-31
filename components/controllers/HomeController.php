<?php

require_once('Controller.php');

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->loadView('HomeView');
    }

    function displayHome() {
        $items = [
            [
                'Status' => 'non-traitee',
                'Nom' => 'Dupont',
                'Prenom' => 'Jean',
                'Source' => 'Hellowork',
                'Poste' => 'Anesthésiste'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Martin',
                'Prenom' => 'Lucie',
                'Source' => 'Hublo',
                'Poste' => 'Cardiologue'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Bernard',
                'Prenom' => 'Marie',
                'Source' => 'Email',
                'Poste' => 'Chirurgien orthopédique'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Petit',
                'Prenom' => 'Paul',
                'Source' => 'Telephone',
                'Poste' => 'Dermatologue'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Dupont',
                'Prenom' => 'Jean',
                'Source' => 'Hublo',
                'Poste' => 'Endocrinologue'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Martin',
                'Prenom' => 'Lucie',
                'Source' => 'Email',
                'Poste' => 'Gastro-entérologue'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Bernard',
                'Prenom' => 'Marie',
                'Source' => 'Hellowork',
                'Poste' => 'Gynécologue'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Petit',
                'Prenom' => 'Paul',
                'Source' => 'Hublo',
                'Poste' => 'Hématologue'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Moreau',
                'Prenom' => 'Sophie',
                'Source' => 'Email',
                'Poste' => 'Infirmier'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Lefevre',
                'Prenom' => 'Aline',
                'Source' => 'Telephone',
                'Poste' => 'Infirmier anesthésiste'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Durand',
                'Prenom' => 'Hugo',
                'Source' => 'Hellowork',
                'Poste' => 'Kinésithérapeute'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Rousseau',
                'Prenom' => 'Chloe',
                'Source' => 'Hublo',
                'Poste' => 'Masseur-kinésithérapeute'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Morel',
                'Prenom' => 'Lucas',
                'Source' => 'Email',
                'Poste' => 'Médecin généraliste'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Fournier',
                'Prenom' => 'Emma',
                'Source' => 'Telephone',
                'Poste' => 'Médecin urgentiste'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Girard',
                'Prenom' => 'Leo',
                'Source' => 'Hellowork',
                'Poste' => 'Néphrologue'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Lambert',
                'Prenom' => 'Julie',
                'Source' => 'Hublo',
                'Poste' => 'Neurologue'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'David',
                'Prenom' => 'Thomas',
                'Source' => 'Email',
                'Poste' => 'Oncologue'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Bertrand',
                'Prenom' => 'Manon',
                'Source' => 'Telephone',
                'Poste' => 'Ophtalmologue'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Dupont',
                'Prenom' => 'Jean',
                'Source' => 'Hellowork',
                'Poste' => 'Orthodontiste'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Martin',
                'Prenom' => 'Lucie',
                'Source' => 'Hublo',
                'Poste' => 'Orthopédiste'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Bernard',
                'Prenom' => 'Marie',
                'Source' => 'Email',
                'Poste' => 'Ostéopathe'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Petit',
                'Prenom' => 'Paul',
                'Source' => 'Telephone',
                'Poste' => 'Pédiatre'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Moreau',
                'Prenom' => 'Sophie',
                'Source' => 'Hellowork',
                'Poste' => 'Pharmacien'
            ],
            [
                'Status' => 'traitee',
                'Nom' => 'Lefevre',
                'Prenom' => 'Aline',
                'Source' => 'Hublo',
                'Poste' => 'Pneumologue'
            ],
            [
                'Status' => 'non-traitee',
                'Nom' => 'Durand',
                'Prenom' => 'Hugo',
                'Source' => 'Email',
                'Poste' => 'Psychiatre'
            ],
            [
                'Status' => 'en attente',
                'Nom' => 'Rousseau',
                'Prenom' => 'Chloe',
                'Source' => 'Telephone',
                'Poste' => 'Radiologue'
            ]
        ];
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
        return $this->View->getContent("Candidatures", $items, $class=null, $dashboard);
    }
}