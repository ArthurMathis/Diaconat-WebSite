<?php 

require_once('View.php');

class CandidatView extends View {
    public function getContent($title, $item) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, ["layouts\assets\stylesheet\candidats.css"]);

        include(LAYOUTS.DS.'Candidat_barre.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}