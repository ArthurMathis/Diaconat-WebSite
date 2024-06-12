<?php

require_once 'View.php';

class CandidaturesView extends View {
    public function getContent($titre, $items = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\candidatures.css"]);

        $liste_menu = [
            [
                "intitule" => "Home",
                "action" => "index.php"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion"
            ]
        ];

        // On ajoute les barres de navigation
        $this->generateMenu($liste_menu);
        include LAYOUTS.DS.'candidatures_barre.php';

        $this->getListesItems($titre, $items, $nb_items_max);

        include(LAYOUTS.DS.'import-AnimeItems.php');
        include(LAYOUTS.DS.'import-candidatures.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    public function getSaisieCandidatContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\saisie-candidatures.css"]);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'formulaires.php';
        include FORMULAIRES.DS.'formulaire_inscription_candidats.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    public function getRechercheCandidatContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\saisie-candidatures.css"]);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'formulaires.php';
        include FORMULAIRES.DS.'formulaire_recherche_candidats.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    public function getSaisieCandidatureContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\saisie-candidatures.css"]);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'formulaires.php';
        include FORMULAIRES.DS.'formulaire_inscription_candidatures.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}