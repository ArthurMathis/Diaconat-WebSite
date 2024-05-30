<?php

require_once 'View.php';

class LoginView extends View {
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Connexion', 
                ["layouts\assets\stylesheet\connexion.css"]);

        // On ajoute le formulaire de connexion
        include LAYOUTS.DS.'formulaire_connexion.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }

    public function getSigninContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Cennexion', 
                ["layouts\assets\stylesheet\connexion.css"]);

        // On ajoute le formulaire de'inscription
        include LAYOUTS.DS.'formulaire_inscription.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}