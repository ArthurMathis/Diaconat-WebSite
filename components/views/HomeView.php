<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent($titre, $items = [], $nb_items_max=null, $dashboard = []) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Welcome', 
                ["layouts\assets\stylesheet\index.css"]);

        // On ajoute la barre de navigation
        include LAYOUTS.DS.'nav_barre.php';

        // On ajoute le contenu de la page
        echo "<content>";
        $this->getListesItems($titre, $items, $nb_items_max=null);
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        // include LAYOUTS.DS.'dashboard.php';
        echo "</content>";

        echo "<script src=\"layouts\assets\scripts\objects\InView.min.js\"></script>
        <script src=\"layouts\assets\scripts\objects\AnimateItems.js\"></script>
        <script>
            // On ajoute les animation de lignes
            const lignes = new AnimateItems('.lignes');
        </script>";

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}