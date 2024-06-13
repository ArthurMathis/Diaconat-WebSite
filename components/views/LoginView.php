<?php

require_once 'View.php';

class LoginView extends View {
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Connexion', [FORMS_STYLES.DS.'connexion.css']);

        // On ajoute le formulaire de connexion
        include FORMULAIRES.DS.'formulaires.php';
        include FORMULAIRES.DS.'formulaire_connexion.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }

    public function getSigninContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Cennexion', [FORMS_STYLES.DS.'connexion.css']);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'formulaires.php';
        include FORMULAIRES.DS.'formulaire_inscription.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}