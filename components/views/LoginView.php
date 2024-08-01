<?php

require_once 'View.php';

/**
 * Class representing the login view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginView extends View {
    /**
     * Public method returning the login form
     *
     * @return void
     */
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Connexion', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, false, false);

        // On ajoute le formulaire de connexion
        include FORMULAIRES.DS.'connexion.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}