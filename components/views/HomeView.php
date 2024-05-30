<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent($titre, $items = []) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Welcome', 
                ["layouts\assets\stylesheet\index.css"]);

        // On ajoute la barre de navigation
        include LAYOUTS.DS.'nav_barre.php';

        // On ajoute le contenu de la page
        echo "<content>";
        include LAYOUTS.DS.'listes.php';
        include LAYOUTS.DS.'dashboard.php';
        echo "</content>";

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}