<?php 

require_once('View.php');

class UtilisateursView extends View {
    public function getContent($titre, $items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'candidatures.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'candidatures_barre.php';

        $this->getListesItems($titre, $items, null, $id);

        include(SCRIPTS.DS.'import-listes.php');
        include(SCRIPTS.DS.'import-candidatures.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}