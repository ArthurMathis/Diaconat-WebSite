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
            $new_c = [
                'Statut' => $c['statut'],
                'Poste' => $c['intitule'],
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
                'Poste' => $p['intitule'],
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
                'Recruteur' => $r['utilisateur'],
                'Date' => $r['date'] // corrected syntax error
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

    /// Méthode publique générant une ContratsBulles selon les information d'un contrat
    public function getContratsBulles($item) {
        include(MY_ITEMS.DS.'contrats_bulles.php');
    }
    /// Méthode publique générant l'onglet conrtat d'un candidat
    public function getContratsBoard($item=[]) {
        echo '<section class="onglet">';
        if(!empty($item['contrat'])) foreach($item['contrats'] as $obj)
            $this->getContratsBulles($obj);
        else echo "<h2>Aucun contrat enregistré </h2>";   

        // On ajoute le bouton d'ajout
        $link = '';
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }

    /// Méthode publique générant une PorpositionsBulles selon les informations d'une proposition
    public function getPropositionsBulles($item=[]) {
        include(MY_ITEMS.DS.'propositions_bulles.php');
    }
    /// Méthode publique générant l'onglet Porpositions d'un candidat selon les informations de son profil
    public function getPropositionsBoard($item) {
        echo '<section class="onglet">';
        if(!empty($item['contrats'])) foreach($item['contrats'] as $obj)
            $this->getPropositionsBulles($obj);
        else echo "<h2>Aucune proposition enregistrée </h2>"; 
        
        // On ajoute le bouton d'ajout
        $link = '';
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }

    /// Méthode publique générant une CandidaturesBulles selon les informations d'une Candidature
    public function getCandidaturesBulles($item=[]) {
        include(MY_ITEMS.DS.'candidatures_bulles.php');
    }
    /// Méthode publique générant l'onglet Candidatures d'un candidat selon les informations de son profil
    public function getCandidaturesBoard($item) {
        echo '<section class="onglet">';
        if(!empty($item['candidatures'])) foreach($item['candidatures'] as $obj)
            $this->getCandidaturesBulles($obj);
        else echo "<h2>Aucune candidature enregistrée </h2>";
        
        // On ajoute le bouton d'ajout
        $link = 'index.php?candidats=saisie-candidatures';
        include(MY_ITEMS.DS.'add_button.php');  
        echo "</section>";
    }

    /// Méthode publique générant une RendezVousBulles seln les informations d'un rendez-vous
    public function getRendezVousBulles($item=[]) {
        include(MY_ITEMS.DS.'rendez_vous_bulles.php');
    }
    /// Méthode publique générant l'onglet rendez-vous d'un candidat selon les informations de son profil
    public function getRendezVousBoard($item=[]) {
        echo '<section class="onglet">';
        if(!empty($item['rendez-vous'])) foreach($item['rendez-vous'] as $obj)
            $this->getRendezVousBulles($obj);
        else echo "<h2>Aucun rendez-vous enregistré </h2>"; 
        
        // On ajoute le bouton d'ajout
        $link = '';
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }

    /// Méthode retournant le contenu de la page profil d'un candidat selon ses informations
    public function getContent($title, $item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);

        $buttons = [
            'Tableau de bord',
            'Contrats',
            'Propositions',
            'Candidatures',
            'Rendez-vous'
            // 'Notation'
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
        echo "</main>";
        echo "</content>";

        include(SCRIPTS.DS.'import-candidats.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}