<?php 

require_once('View.php');

class CandidatsView extends View {
    public function getContratsBulles($item) {
        include(MY_ITEMS.DS.'contrats_bulles.php');
    }
    public function getContratsBoard($item) {
        echo '<section class="onglet">';
        foreach($item['contrats'] as $obj)
            $this->getContratsBulles($obj);
        echo "</section>";

    }

    public function getPropositionsBulles($item) {
        include(MY_ITEMS.DS.'propositions_bulles.php');
    }
    public function getPropositionsBoard($item) {
        echo '<section class="onglet">';
        foreach($item['contrats'] as $obj)
            $this->getPropositionsBulles($obj);
        echo "</section>";
    }

    public function getCandidaturesBulles($item) {
        include(MY_ITEMS.DS.'candidatures_bulles.php');
    }
    public function getCandidaturesBoard($item) {
        echo '<section class="onglet">';
        foreach($item['candidatures'] as $obj)
            $this->getCandidaturesBulles($obj);
        echo "</section>";
    }
    public function getRendezVousBulles($item) {
        include(MY_ITEMS.DS.'rendez_vous_bulles.php');
    }
    public function getRendezVousBoard($item) {
        echo '<section class="onglet">';
        foreach($item['rendez-vous'] as $obj)
            $this->getRendezVousBulles($obj);
        echo "</section>";
    }

    public function getContent($title, $item) {
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
            // 'Tableau de bord',
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