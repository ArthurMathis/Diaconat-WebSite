<?php 

require_once('View.php');

class CandidatsView extends View {
    public function getContent($title, $item) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);

        $liste_menu = [
            [
                "intitule" => "Home",
                "action" => "index.php"
            ],
            [
                "intitule" => "Candidatures",
                "action" => "index.php?candidatures=home"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion"
            ]
        ];
        $buttons = [
            'Tableau de bord',
            'Contrats', 
            'Candidatures',
            'Propositions',
            'Rendez-vous',
            'Notation'
        ] ;

        // On ajoute la barre de navigation
        $this->generateMenu($liste_menu);

        echo "<content>";
        include(MY_ITEMS.DS.'Candidat_profil.php');
        echo "<main>";
        include(BARRES.DS.'nav.php');
        echo "</main>";
        echo "</content>";

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}