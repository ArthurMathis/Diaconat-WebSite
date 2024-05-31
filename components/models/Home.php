<?php 

require_once(MODELS.DS.'Model.php');

class Home extends Model {
    public function getNontraiteeCandidature() {
        // On initialise la requête
        $request = "SELECT intitule_postes AS Poste, 
        nom_candidats AS Nom, 
        prenom_candidats AS Prénom, 
        email_candidats AS Email, 
        telephone_candidats AS Téléphone, 
        intitule_sources AS Source
        FROM `candidatures` as c
        INNER JOIN candidats as i on c.Cle_Candidats = i.Id_Candidats
        INNER JOin postes as p on c.Cle_Postes = p.Id_Postes
        INNER JOIN sources as s on c.Cle_Sources = s.Id_Sources
        WHERE c.Status_Candidatures = 'non-traitee'";

        // On lance la requête
        $result = $this->get_request($request, $params=[]);

        // On retourne le rôle
        return $result;
    }
}