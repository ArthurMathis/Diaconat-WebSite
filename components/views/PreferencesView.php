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
        include(MY_ITEMS.DS.'utilisateur_profil.php');
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant la liste utilisateurs
    public function getUtilisateursContent($items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [PAGES_STYLES.DS.'preferences.css']);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'utilisateur_profil.php');
        echo '<main>';
        include BARRES.DS.'utilisateurs_barre.php';
        $this->getListesItems($titre, $items, null, $id);
        echo '</main>';
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}