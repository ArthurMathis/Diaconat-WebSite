<?php

require_once 'View.php';

class LoginView extends View {
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Connexion', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, false, false);

        // On ajoute le formulaire de connexion
        include FORMULAIRES.DS.'connexion.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}