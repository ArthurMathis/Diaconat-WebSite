<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent($titre, $items = [], $dashboard = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Welcome', 
                [PAGES_STYLES.DS.'index.css']);

        $id = 'main-liste';

        // On ajoute la barre de navigation
        $this->generateMenu();
        // On ajoute le contenu de la page
        echo "<content>";
        $this->getListesItems($titre, $items, $nb_items_max, $id);
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        echo "</content>";
        
        include(SCRIPTS.DS.'import-scripts-listes.php');
        include(SCRIPTS.DS.'import-listes.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}