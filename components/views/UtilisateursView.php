<?php 

require_once('View.php');

class UtilisateursView extends View {
    /// Méthode publique retournant la vue Utilisateurs
    public function getUtilisateursContent($titre, $items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'utilisateurs.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'utilisateurs_barre.php';

        $this->getListesItems($titre, $items, null, $id);

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/utilisateurs-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue Historique
    public function gethistoriqueContent($titre, $items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'historique.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'historique_barre.php';

        $this->getListesItems($titre, $items, null, $id);

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/historique-controller.js'
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
        include FORMULAIRES.DS.'inscription.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}