<?php 

require_once('View.php');

class CandidatsView extends View {
    /// Méthode privée générant une liste de contrats
    private function makeContratsListe($contrats=[], $nb_items_max) {
        // Le nouveau tableaux de contrats
        $contrats_bulles = [];

        // On construit le tableaux de contrats simplifiés
        foreach($contrats as $c) if(!empty($c['signature'])){
            $new_c = [
                'Statut' => $c['statut'],
                'Poste' => $c['mission']['intitule'],
                'Type de contrat' => $c['type contrat']
            ];
            
            array_push($contrats_bulles, $new_c);
        }

        // On génère la bulle
        $this->getBulles('Contrats', $contrats_bulles, $nb_items_max, null, null);
    }
    /// Méthode privée générant une liste de contrats
    private function makePropositionsListe($propositions=[], $nb_items_max) {
        // Le nouveau tableaux de propositions
        $propositions_bulles = [];

        // On construit le tableaux de contrats simplifiés
        foreach($propositions as $p) if(empty($p['signature'])) {
            $new_p = [
                'Statut' => empty($p['statut']) ? 'en attente' : 'refusée',
                'Poste' => $p['mission']['intitule'],
                'Type de contrat' => $p['type contrat']
            ];
            array_push($propositions_bulles, $new_p);
        }
        
        // On génère la bulle
        $this->getBulles("Propositions d'embauche", $propositions_bulles, $nb_items_max, null, null);
    }
    /// Méthode privée généranr une liste de candidatures
    private function makeCandidaturesListe($candidatures=[], $nb_items_max) {
        // Le nouveau tableaux de candidatures
        $candidatures_bulles = [];

        foreach($candidatures as $c) {
            $new_c = [
                'Statut' => $c['statut'],
                'Poste' => $c['poste'],
                'Type de contrat' => $c['type_de_contrat']
            ];
            array_push($candidatures_bulles, $new_c);
        }

        // On génère la bulle
        $this->getBulles("Candidatures", $candidatures_bulles, $nb_items_max, null, null);
    }
    private function makeRendezVousListe($rendezvous=[], $nb_items_max) {
        // Le nouveau tableau de rendez-vous
        $rendezvous_bulles = [];

        foreach($rendezvous as $r) {
            $new_r = [
                'Recruteur' => $r['utilisateur'],
                'Date' => $r['date'] // corrected syntax error
            ];
            array_push($rendezvous_bulles, $new_r);
        }

        // On génère la bulle
        $this->getBulles("Rendez-vous", $rendezvous_bulles, $nb_items_max, null, null);
    }

    /// Méthode publique générant le tableau de bord d'un candidat selon son profil
    public function getDashboard($item=[]) {
        // On génère un nouvel onglet
        echo '<section class="onglet">';

        echo '<script>console.log("On lance la génération du dashBoard");</script>';

        echo '<script>console.log("On la liste de contrats");</script>';

        $this->makeContratsListe($item['contrats'], 4);

        echo '<script>console.log("On la liste de propositions");</script>';

        $this->makePropositionsListe($item['contrats'], 4);

        echo '<script>console.log("On la liste de candidatures");</script>';

        $this->makeCandidaturesListe($item['candidatures'], 4);

        echo '<script>console.log("On la liste de rendez-vous");</script>';

        $this->makeRendezVousListe($item['rendez-vous'], 4);
        echo "</section>";
    }

    /// Méthode publique générant une ContratsBulles selon les information d'un contrat
    public function getContratsBulles($item) {
        include(MY_ITEMS.DS.'contrats_bulles.php');
    }
    /// Méthode publique générant l'onglet conrtat d'un candidat
    public function getContratsBoard($item=[]) {
        echo '<section class="onglet">';
        foreach($item['contrats'] as $obj)
            $this->getContratsBulles($obj);
        echo "</section>";

    }

    /// Méthode publique générant une PorpositionsBulles selon les informations d'une proposition
    public function getPropositionsBulles($item=[]) {
        include(MY_ITEMS.DS.'propositions_bulles.php');
    }
    /// Méthode publique générant l'onglet Porpositions d'un candidat selon les informations de son profil
    public function getPropositionsBoard($item) {
        echo '<section class="onglet">';
        foreach($item['contrats'] as $obj)
            $this->getPropositionsBulles($obj);
        echo "</section>";
    }

    /// Méthode publique générant une CandidaturesBulles selon les informations d'une Candidature
    public function getCandidaturesBulles($item=[]) {
        include(MY_ITEMS.DS.'candidatures_bulles.php');
    }
    /// Méthode publique générant l'onglet Candidatures d'un candidat selon les informations de son profil
    public function getCandidaturesBoard($item) {
        echo '<section class="onglet">';
        foreach($item['candidatures'] as $obj)
            $this->getCandidaturesBulles($obj);
        echo "</section>";
    }

    /// Méthode publique générant une RendezVousBulles seln les informations d'un rendez-vous
    public function getRendezVousBulles($item=[]) {
        include(MY_ITEMS.DS.'rendez_vous_bulles.php');
    }
    /// Méthode publique générant l'onglet rendez-vous d'un candidat selon les informations de son profil
    public function getRendezVousBoard($item=[]) {
        echo '<section class="onglet">';
        foreach($item['rendez-vous'] as $obj)
            $this->getRendezVousBulles($obj);
        echo "</section>";
    }

    /// Méthode retournant le contenu de la page profil d'un candidat selon ses informations
    public function getContent($title, $item=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);

        $liste_menu = [
            [
                "intitule" => "Home",
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
        $buttons = [
            'Tableau de bord',
            'Contrats',
            'Propositions',
            'Candidatures',
            'Rendez-vous'
            // 'Notation'
        ] ;

        // On ajoute la barre de navigation
        $this->generateMenu($liste_menu);

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