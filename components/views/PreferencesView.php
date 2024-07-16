<?php 

require_once('View.php');

class PreferencesView extends View {
    /// Méthode publique retournant la page principale du menu préférences
    public function getContent($items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Préférences', [PAGES_STYLES.DS.'preferences.css']);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste utilisateurs
    public function getUtilisateursContent(&$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css', 
            PAGES_STYLES.DS.'utilisateurs.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="liste-utilisateurs">';
        include BARRES.DS.'utilisateurs_barre.php';
        $this->getListesItems("Utilisateurs", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/preferences-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des nouveaux utilisateurs
    public function getNouveauxUtilisateursContent(&$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'utilisateurs.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="liste-utilisateurs">';
        include BARRES.DS.'nouveaux_utilisateurs_barre.php';
        $this->getListesItems("Utilisateurs", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/nouveaux-utilisateurs-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    


    /// Méthode publique retournant la vue saisie utilisateur
    public function getSaisieUtilisateur($role) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Inscription', [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute la barre de navigation
        $this->generateFormMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription-utilisateur.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}