<?php

require_once 'View.php';

class CandidaturesView extends View {
    public function getContent($titre, $items = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\candidatures.css"]);

        // On ajoute la barre de navigation
        include LAYOUTS.DS.'navbarre.php';
        include LAYOUTS.DS.'candidatures_barre.php';

        $this->getListesItems($titre, $items, $nb_items_max);

        include(LAYOUTS.DS.'AnimeItems.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}