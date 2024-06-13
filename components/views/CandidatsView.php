<?php 

require_once('View.php');

class CandidatsView extends View {
    public function getContent($title, $item) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);

        include(BARRES.DS.'Candidat_barre.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}