<?php

require_once 'View.php';

class CandidaturesView extends View {
    /// Méthode publique retournant la page de candidatures (liste)
    public function getContent($titre, $items = [], $nb_items_max=null) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'candidatures.css']);

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

    /// Méthode publique retournant le formulaire de saisie d'un candidat
    public function getSaisieCandidatContent($title, $aide=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'inscript_candidats.css']);

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
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'connexion.css']);

        // On ajoute la barre de navigation
        $this->generateMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription_candidatures.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant la formulaire d'ajout d'une proposition
    public function getSaisieProposition($title) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'connexion.css']);

        // On ajoute la barre de navigation
        $this->generateMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'proposition.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}