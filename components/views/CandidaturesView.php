<?php

require_once 'View.php';

class CandidaturesView extends View {
    public function getContent($titre, $items = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', [PAGES_STYLES.DS.'candidatures.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'candidatures_barre.php';

        $this->getListesItems($titre, $items, $nb_items_max, $id);

        include(SCRIPTS.DS.'import-listes.php');
        include(SCRIPTS.DS.'import-candidatures.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    public function getSaisieCandidatContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', [FORMS_STYLES.DS.'saisie-candidatures.css']);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription_candidats.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    public function getRechercheCandidatContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', [FORMS_STYLES.DS.'saisie-candidatures.css']);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'recherche_candidats.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    public function getSaisieCandidatureContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat Web Site - Candidatures', [FORMS_STYLES.DS.'connexion.css']);

        // On ajoute la barre de navigation
        $this->generateMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription_candidatures.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}