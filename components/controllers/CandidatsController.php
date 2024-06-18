<?php 

require_once('Controller.php');

class CandidatController extends Controller {
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    public function displayCandidat($Cle_Candidat) {
        // Récupération d'un candidat
        $item = $this->Model->getContent($Cle_Candidat);

        // Encodage de l'objet PHP en JSON
        $jsonItem = json_encode($item);
        echo '<script>console.log("Item");</script>';
        echo '<script>console.log(' . $jsonItem . ');</script>';

        $jsonItem = json_encode($item['candidat']);
        echo '<script>console.log("candidat");</script>';
        echo '<script>console.log(' . $jsonItem . ');</script>';

        return $this->View->getContent("Candidat " . $item['candidat']['nom'], $item);
    }
}