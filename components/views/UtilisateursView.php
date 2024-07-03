<?php 

require_once('View.php');

class UtilisateursView extends View {
    /// Méthode publique retournant la vue Utilisateurs
    public function getUtilisateursContent($titre, $items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'candidatures.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'utilisateurs_barre.php';

        $this->getListesItems($titre, $items, null, $id);

        include(SCRIPTS.DS.'import-listes.php');
        include(SCRIPTS.DS.'import-candidatures.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue Historique
    public function gethistoriqueContent($titre, $items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'candidatures.css']);

        $id = 'main-liste';

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'historique_barre.php';

        $this->getListesItems($titre, $items, null, $id);

        include(SCRIPTS.DS.'import-listes.php');
        include(SCRIPTS.DS.'import-candidatures.php');

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