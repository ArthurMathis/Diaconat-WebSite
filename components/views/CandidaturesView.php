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
        include BARRES.DS.'candidatures.php';

        $this->getListesItems($titre, $items, $nb_items_max, 'main-liste');


        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/candidatures-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant le formulaire de saisie d'un candidat
    public function getSaisieCandidatContent($title, &$aide=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'candidats.php';
        include FORMULAIRES.DS.'waves.php';

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant le formulaire de saisie d'une candidature
    public function getSaisieCandidatureContent($title, $poste=[], $service=[], $typeContrat=[], $source=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'candidatures.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}