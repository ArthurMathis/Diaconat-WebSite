<?php

require_once 'View.php';

class HomeView extends View {
    public function getContent($titre, $items = [], $dashboard = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Welcome', 
                ["layouts\assets\stylesheet\index.css"]);

        $liste_menu = [
            [
                "intitule" => "Candidatures",
                "action" => "index.php?candidatures=home"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion"
            ]
        ];

        // On ajoute la barre de navigation
        $this->generateMenu($liste_menu);
        // On ajoute le contenu de la page
        echo "<content>";
        $this->getListesItems($titre, $items, $nb_items_max);
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        echo "</content>";
        
        include(LAYOUTS.DS.'import-scripts-listes.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}