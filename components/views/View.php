<?php

class View {
    public function generateCommonHeader($name=null, $cssFiles = []) {
        include LAYOUTS.DS.'entete.php';
    }
    public function generateCommonFooter() {
        include LAYOUTS.DS.'footer.php';
    }
    public function getListesItems($titre, $items = [], $nb_items_max=null) {
        // Si le nombre d'items max n'est pas défini, on l'implémente au nombre d'items total
        if($nb_items_max == null)
            $nb_items_max = count($items);

        include LAYOUTS.DS.'listes.php';
    }
    public function getBulles($titre, $items, $nb_items_max, $link_add, $link_consult) {
        include(LAYOUTS.DS.'bulles.php');
    }
    public function getDashboard($dashboard = []) {
        foreach($dashboard as $item) {
            $titre = $item['titre'];
            $items = $item['content'];
            $nb_items_max = isset($item['nb_item_max']) ? $item['nb_item_max'] : null;
            $link_add = isset($item['link_add']) ? $item['link_add'] : null;
            $link_consult = isset($item['link_consult']) ? $item['link_consult'] : null;
            
            $this->getBulles($titre, $items, $nb_items_max, $link_add, $link_consult);
        }
    }
}