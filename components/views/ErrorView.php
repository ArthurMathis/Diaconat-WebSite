<?php

require_once('View.php');

class ErrorView extends View {
    public function getErrorContent($e) {
        // On ajoute l'entete de page
        $this->generateCommonHeader("Diaconat - Une erreur est survenue", 
                ["layouts\assets\stylesheet\erreur.css"]);

         // On ajoute le contenu
        echo "<h2>Il semblerait d'une erreur se soit produite...</h2>";
        if($e instanceof Exception && $e != null)
            echo "<p>".$e->getMessage()."</p>";

        // On ajoute le pied de page    
        $this->generateCommonFooter();
    }
}