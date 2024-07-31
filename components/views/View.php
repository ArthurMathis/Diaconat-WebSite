<?php

/**
 * Abstract class representing a view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class View {
    /**
     * Private array containing the list of tabs the user can visit
     *
     * @var array<object>
     */
    private $menu;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->menu = $this->makeMenuListe();
    }
    /**
     * Private method generating in according to the user's role, the list of tabs he can visit
     *
     * @return void
     */
    private function makeMenuListe() {
        return [
            [
                "intitule" => "Accueil",
                "action" => "index.php",
                "logo" => LOGO.DS."white-home.svg"
            ],
            [
                "intitule" => "Candidatures",
                "action" => "index.php?candidatures=home",
                "logo" => LOGO.DS."white-candidature.svg"
            ],
            // [
            //     "intitule" => "Statistiques",
            //     "action" => "#",
            //     "logo" => LOGO.DS."white-statistiques.svg"
            // ],
            // [
            //     "intitule" => "Besoins",
            //     "action" => "#",
            //     "logo" => LOGO.DS."white-offre.svg"
            // ],
            [
                "intitule" => "Préférences",
                "action" => "index.php?preferences=home",
                "logo" => LOGO.DS."white-preferences.svg"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion",
                "logo" => LOGO.DS."white-log-out.svg"
            ]
        ];
    }


    public function generateCommonHeader($name=null, $cssFiles=[]) {
        include COMMON.DS.'entete.php';
    }
    public function generateCommonFooter() {
        include COMMON.DS.'footer.php';
    }
    public function generateMenu($form=false, $home=true, $menu=true) {
        // On récupère la liste des menus
        $liste_menu = $this->menu;

        // On génère la barre de navigation
        include BARRES.DS.'navbarre.php';
    }

    public function getListesItems($titre=null, $items=[], $nb_items_max=null, $id=null, $class=null, $direction=null) {
        // Si le nombre d'items max n'est pas défini, on l'implémente au nombre d'items total
        if($nb_items_max == null)
            $nb_items_max = empty($items) ? 0 : count($items);

        // On génère la liste    
        include MY_ITEMS.DS.'listes.php';
    }
    public function getBulles($titre, $items=[], $nb_items_max, $link_add, $link_consult) {
        include(MY_ITEMS.DS.'bulles.php');
    }
    public function getDashboard($dashboard = []) {
        foreach($dashboard as $item) {
            // On récupère les informations de la bulle
            $titre = $item['titre'];
            $items = $item['content'];
            $nb_items_max = isset($item['nb_item_max']) ? $item['nb_item_max'] : null;
            $link_add = isset($item['link_add']) ? $item['link_add'] : null;
            $link_consult = isset($item['link_consult']) ? $item['link_consult'] : null;
            
            // On génère la bulle
            $this->getBulles($titre, $items, $nb_items_max, $link_add, $link_consult);
        }
    }
}