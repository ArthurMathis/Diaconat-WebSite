<?php 

require_once(MODELS.DS.'Model.php');
require_once(VIEWS.DS.'ErrorView.php');

class CandidaturesModel extends Model {
    public function getCandidatures() {
        // On initialise la requête
        $request = "SELECT  Status_Candidatures AS Status, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prénom, 
        intitule_postes AS Poste,
        email_candidats AS Email, 
        telephone_candidats AS Téléphone, 
        intitule_sources AS Source, 
        Disponibilite_Candidats AS Disponibilité
        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources";
    
        // On lance la requête
        $result = $this->get_request($request);
    
        // On retourne le rôle
        return $result;
    }
}