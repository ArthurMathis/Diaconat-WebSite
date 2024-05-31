<?php

require_once 'View.php';

class CandidaturesView extends View {
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', ["layouts\assets\stylesheet\candidatures.css"]);

        // On ajoute la barre de navigation
        include LAYOUTS.DS.'navbarre.php';
        include LAYOUTS.DS.'candidatures_barre.php';

        echo "<p>Bonjour !!</p>";

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}