<?php

require_once 'View.php';

class LoginView extends View {
    public function getContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Connexion', [FORMS_STYLES.DS.'connexion.css']);

        $liste_menu = [
            [
                "intitule" => "Accueil",
                "action" => "index.php"
            ],
            [
                "intitule" => "Candidatures",
                "action" => "index.php?candidatures=home"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion"
            ]
        ];
        // On ajoute la barre de navigation
        $this->generateMenu($liste_menu);

        // On ajoute le formulaire de connexion
        include FORMULAIRES.DS.'connexion.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }

    public function getSigninContent() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Connexion', [FORMS_STYLES.DS.'connexion.css']);

        $liste_menu = [
            [
                "intitule" => "Accueil",
                "action" => "index.php"
            ],
            [
                "intitule" => "Candidatures",
                "action" => "index.php?candidatures=home"
            ],
            [
                "intitule" => "Se déconnecter",
                "action" => "index.php?login=deconnexion"
            ]
        ];
        // On ajoute la barre de navigation
        $this->generateMenu($liste_menu);

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}