<?php 

require_once('View.php');

class CandidatsView extends View {
    /// Méthode privée générant une liste de contrats
    private function makeContratsListe($contrats=[], $nb_items_max) {
        // On teste la présence de données
        if(empty($contrats)) 
            return;

        // Le nouveau tableaux de contrats
        $contrats_bulles = [];

        // On construit le tableaux de contrats simplifiés 
        foreach($contrats as $c) if(!empty($c['signature'])){
            // On définit le statut du contrat
            $date = instants::currentInstants()->getDate();
            if($date < $c['date_debut'])
                $statut = "A venir";
            elseif($c['date_fin'] < ($date || $c['demission']))
                $statut = "Terminé";
            else    
                $statut = "En cours";

            // On construit le nouvel item    
            $new_c = [
                'Statut' => $statut,
                'Poste' => $c['poste'],
                'Type de contrat' => $c['type_de_contrat']
            ];
            
            array_push($contrats_bulles, $new_c);
        }

        // On vérifie la présence d'items dans la liste
        if(empty($contrats_bulles))
            return;

        // On génère la bulle
        $this->getBulles('Contrats', $contrats_bulles, $nb_items_max, null, null);
    }
    /// Méthode privée générant une liste de contrats
    private function makePropositionsListe($propositions=[], $nb_items_max) {
        // On teste la présence de données
        if(empty($propositions)) 
            return;

        // Le nouveau tableaux de propositions
        $propositions_bulles = [];

        // On construit le tableaux de contrats simplifiés
        foreach($propositions as $p) if(empty($p['signature'])) {
            $new_p = [
                'Statut' => empty($p['statut']) ? 'en attente' : 'refusée',
                'Poste' => $p['poste'],
                'Type de contrat' => $p['type_de_contrat']
            ];
            array_push($propositions_bulles, $new_p);
        }

        // On vérifie la présence d'items dans la liste
        if(empty($propositions_bulles))
            return;
        
        // On génère la bulle
        $this->getBulles("Propositions d'embauche", $propositions_bulles, $nb_items_max, null, null);
    }
    /// Méthode privée généranr une liste de candidatures
    private function makeCandidaturesListe($candidatures=[], $nb_items_max) {
        // On teste la présence de données
        if(empty($candidatures)) 
            return;

        // Le nouveau tableaux de candidatures
        $candidatures_bulles = [];

        // On construit le tableaux de candidatures simplifiées
        foreach($candidatures as $c) {
            $new_c = [
                'Statut' => $c['statut'],
                'Poste' => $c['poste'],
                'Type de contrat' => $c['type_de_contrat']
            ];
            array_push($candidatures_bulles, $new_c);
        }

        // On vérifie la présence d'items dans la liste
        if(empty($candidatures_bulles))
            return;

        // On génère la bulle
        $this->getBulles("Candidatures", $candidatures_bulles, $nb_items_max, null, null);
    }
    private function makeRendezVousListe($rendezvous=[], $nb_items_max) {
        // On teste la présence de données
        if(empty($rendezvous)) 
            return;

        // Le nouveau tableau de rendez-vous
        $rendezvous_bulles = [];

        // On construit le tableaux de rendez-vous simplifiés
        foreach($rendezvous as $r) {
            $new_r = [
                'Recruteur' => forms_manip::majusculeFormat($r['nom']) . ' ' . $r['prenom'],
                'Date' => $r['date'],
                'Etablissement' => $r['etablissement']
            ];
            array_push($rendezvous_bulles, $new_r);
        }

        // On vérifie la présence d'items dans la liste
        if(empty($rendezvous_bulles))
            return;

        // On génère la bulle
        $this->getBulles("Rendez-vous", $rendezvous_bulles, $nb_items_max, null, null);
    }

    /// Méthode publique générant le tableau de bord d'un candidat selon son profil
    public function getDashboard($item=[]) {
        // On génère un nouvel onglet
        echo '<section class="onglet">';
        $this->makeContratsListe($item['contrats'], 4);
        $this->makePropositionsListe($item['contrats'], 4);
        $this->makeCandidaturesListe($item['candidatures'], 4);
        $this->makeRendezVousListe($item['rendez-vous'], 4);

        if(empty($item['contrats']) && empty($item['candidatures']) && empty($item['rendez-vous']))
            echo "<h2>Aucun élément enregistré sur le profil du candidat.</h2>";

        echo "</section>";
    }
    /// Méthode protégée générant une ContratsBulles selon les information d'un contrat
    protected function getContratsBulles($item) {
        include(MY_ITEMS.DS.'contrats_bulles.php');
    }
    /// Méthode protégée générant une PorpositionsBulles selon les informations d'une proposition
    protected function getPropositionsBulles($item=[]) {
        include(MY_ITEMS.DS.'propositions_bulles.php');
    }
    /// Méthode protégée générant une CandidaturesBulles selon les informations d'une Candidature
    protected function getCandidaturesBulles($item=[]) {
        include(MY_ITEMS.DS.'candidatures_bulles.php');
    }
    /// Méthode protégée générant une RendezVousBulles seln les informations d'un rendez-vous
    protected function getRendezVousBulles($item=[]) {
        include(MY_ITEMS.DS.'rendez_vous_bulles.php');
    }

    /// Méthode publique générant l'onglet contrat d'un candidat
    protected function getContratsBoard(&$item=[]) {
        echo '<section class="onglet">';
        if(!empty($item['contrats'])) {
            $compt = 0; $i = 0; $size = count($item['contrats']);
            for($i = 0; $i < $size; $i++) {
                if(!empty($item['contrats'][$i]['signature'])){
                    $this->getContratsBulles($item['contrats'][$i]);
                    $compt++;
                }
            }
               
            // On vérifie la présence de signature
            if($compt == 0)
                echo "<h2>Aucun contrat enregistré</h2>";

        } else 
            echo "<h2>Aucun contrat enregistré</h2>";   

        // On ajoute le bouton d'ajout
        $link = 'index.php?candidats=saisie-contrats&cle_candidat=' . $item['candidat']['id'];
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }
    /// Méthode publique générant l'onglet Porpositions d'un candidat selon les informations de son profil
    protected function getPropositionsBoard(&$item) {
        echo '<section class="onglet">';
        if(!empty($item['contrats'])) foreach($item['contrats'] as $obj) 
            $this->getPropositionsBulles($obj);
        else echo "<h2>Aucune proposition enregistrée </h2>"; 
        
        // On ajoute le bouton d'ajout
        $link = 'index.php?candidats=saisie-propositions&cle_candidat=' . $item['candidat']['id'];
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }
    /// Méthode publique générant l'onglet Candidatures d'un candidat selon les informations de son profil
    protected function getCandidaturesBoard(&$item) {
        echo '<section class="onglet">';
        if(!empty($item['candidatures'])) foreach($item['candidatures'] as $obj)
            $this->getCandidaturesBulles($obj);
        else echo "<h2>Aucune candidature enregistrée </h2>";
        
        // On ajoute le bouton d'ajout
        $link = 'index.php?candidats=saisie-candidatures&cle_candidat=' . $item['candidat']['id'];
        include(MY_ITEMS.DS.'add_button.php');  
        echo "</section>";
    }
    /// Méthode publique générant l'onglet rendez-vous d'un candidat selon les informations de son profil
    protected function getRendezVousBoard(&$item=[]) {
        echo '<section class="onglet">';
        if(!empty($item['rendez-vous'])) foreach($item['rendez-vous'] as $obj)
            $this->getRendezVousBulles($obj);
        else echo "<h2>Aucun rendez-vous enregistré </h2>"; 
        
        // On ajoute le bouton d'ajout
        $link = 'index.php?candidats=saisie-rendez-vous&cle_candidat=' . $item['candidat']['id'];
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }
    /// Méthode protégée générant l'onglet de notation d'un candidat selon les informations de son profil
    protected function getNotationBoard(&$item=[]) {
        echo '<section class="onglet">';
        include(MY_ITEMS.DS.'notation.php'); 
        echo "</section>";
    }

    /// Méthode retournant le contenu de la page profil d'un candidat selon ses informations
    public function getContentCandidat($title, &$item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);

        $buttons = [
            'Tableau de bord',
            'Contrats',
            'Propositions',
            'Candidatures',
            'Rendez-vous',
            'Notation'
        ] ;

        // On ajoute la barre de navigation
        $this->generateMenu();

        echo "<content>";
        include(MY_ITEMS.DS.'Candidat_profil.php');
        echo "<main>";
        include(BARRES.DS.'nav.php');
        $this->getDashboard($item);
        $this->getContratsBoard($item);
        $this->getPropositionsBoard($item);
        $this->getCandidaturesBoard($item);
        $this->getRendezVousBoard($item);
        $this->getNotationBoard($item);
        echo "</main>";
        echo "</content>";

        // On importe les scripts JavaScript
        $scripts = [
            'views/candidats-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // include(SCRIPTS.DS.'import-candidats.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    public function getContent($titre, &$items=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css']);

        // On ajoute les barres de navigation
        $this->generateMenu();
        include BARRES.DS.'liste-candidats.php';

        $this->getListesItems($titre, $items, null, 'main-liste');

        // On importe les scripts JavaScript
        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/candidats-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }

    /// Méthode publique retournant la formulaire d'ajout d'une proposition
    public function getContentProposition($title, $cle_candidat, $poste=[], $service=[], $typeContrat=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');
        
        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'proposition.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la formulaire d'ajout d'une proposition
    public function getContentPropositionFromCandidatures($title, $cle_candidature, $statut_candidature) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        $scripts = [
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'proposition-from-candidature.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la formulaire d'ajout d'une proposition selon une candidature sans service
    public function getContentPropositionFromEmptyCandidatures($title, $cle_candidature, $statut_candidature, &$service=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'proposition-from-empty-candidature.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la formulaire d'ajout d'un contrat
    public function getContentContrats($title, $cle_candidat, $poste=[], $service=[], $typeContrat=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'contrats.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant le formulaire d'ajout d'un contrat
    public function GetContentRendezVous($title, $cle_candidat, $utilisateur=[], $etablissement=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true);

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'rendez-vous.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }


    public function getEditNotation(&$item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Modification de la notation de ' . forms_manip::majusculeFormat($item['nom']) . ' ' . $item['prenom'], 
        [FORMS_STYLES.DS.'small-form.css', FORMS_STYLES.DS.'edit-notation.css']);

        // On ajoute les barres de navigation
        $this->generateMenu(true);

        // On ajoute le formulaire de connexion
        include EDIT_FORM.DS.'notation.php';
        include FORMULAIRES.DS.'waves.php';

        // On importe les scripts JavaScript
        $scripts = [
            'controllers/edit-notation-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    public function getEditCandidat(&$item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Modification de ' . forms_manip::majusculeFormat($item['candidat']['nom']) . ' ' . $item['candidat']['prenom'], [FORMS_STYLES.DS.'big-form.css']);

        // On ajoute les barres de navigation
        $this->generateMenu(true);

        // On ajoute le formulaire de connexion
        include EDIT_FORM.DS.'candidat.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    public function getEditRendezVous($cle_candidat, $cle_utilisateur, $cle_instant, &$item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Mise-à-jour rendez-vous', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute les barres de navigation
        $this->generateMenu(true);

        // On ajoute le formulaire de connexion
        include EDIT_FORM.DS.'rendez-vous.php';
        include FORMULAIRES.DS.'waves.php';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}