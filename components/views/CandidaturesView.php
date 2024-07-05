<?php

require_once 'View.php';

class CandidaturesView extends View {
    /// Méthode publique retournant la page de candidatures (liste)
    public function getContent($titre, $items = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'candidatures.css']);

        // $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'candidatures_barre.php';

        $this->getListesItems($titre, $items, $nb_items_max, 'main-liste');


        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/candidatures-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant le formulaire de saisie d'un candidat
    public function getSaisieCandidatContent($title, $aide=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute la barre de navigation
        $this->generateFormMenu(true);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription_candidats.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant le formulaire de recherche d'un candidat
    public function getRechercheCandidatContent($title) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'saisie-candidatures.css']);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'recherche_candidats.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant le formulaire de saisie d'une candidature
    public function getSaisieCandidatureContent($title) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription_candidatures.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}