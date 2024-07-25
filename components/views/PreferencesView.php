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
        echo '<main id="profil-user">';
        $this->getProfil($items);
        $this->getUtilisateurHistorique($items);
        echo '</main>';
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode privée retournant leprofil de l'utilisateur
    private function getProfil(&$items=[]) {
        echo "<div class='left'>";
        include(MY_ITEMS.DS.'profil_user.php');
        echo "</div>";
    }
    /// Méthode privée retournant la page d'historique d'un utilisateur
    private function getUtilisateurHistorique(&$items=[]) {
        echo "<div class='right'>"; 
        $this->getBulles("Historique d'actions", $items['actions'], 8, null, null);
        $this->getBulles("Historique de connexions", $items['connexions'], 4, null, null);
        echo "</div>";
    }
    /// Méthod epublique retournant la page de modification du mot de passe
    public function getEditpassword() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Préférences', [
            PAGES_STYLES.DS.'preferences.css', 
            FORMS_STYLES.DS.'edit-user.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main>';
        include(FORMULAIRES.DS.'edit-user.php');
        echo '</amin>';
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
    /// Méthode publique retournant la vue Historique de connexions
    public function getConnexionHistoriqueContent(&$items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'connexion-historique.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'connexion_historique_barre.php';
        $this->getListesItems("Historique de connexions", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/connexion-historique-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue Historique d'actions
    public function getActionHistoriqueContent(&$items) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'action-historique.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'action_historique_barre.php';
        $this->getListesItems("Historique d'actions", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/action-historique-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des postes
    public function getPostesContent(&$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste postes', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'postes_barre.php';
        $this->getListesItems("Postes", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/poste-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des services
    public function getServicesContent(&$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste services', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'services_barre.php';
        $this->getListesItems("Services", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/service-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des établissements
    public function getEtablissementsContent(&$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Liste établissements', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
           PAGES_STYLES.DS.'etablissements.css'
        ]);

        // On ajoute les barres de navigation
        $this->generateMenu();

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'etablissements_barre.php';
        $this->getListesItems("Etablissements", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-views.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/etablissement-controller.js'
        ];
        include(SCRIPTS.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant la vue saisie utilisateur
    public function getSaisieUtilisateur(&$role) {
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
    /// Méthode publique retournant la vue saisie d'une poste
    public function getSaisiePoste() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Inscription poste', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateFormMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription-poste.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue saisie d'un service
    public function getSaisieService() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Inscription service', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateFormMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription-service.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode pubique retournant la vue de siasise d'un établissement
    public function getSaisieEtablissement() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Diaconat - Inscription établissement', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateFormMenu();

        // On ajoute le formulaire de'inscription
        include FORMULAIRES.DS.'inscription-etablissements.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}